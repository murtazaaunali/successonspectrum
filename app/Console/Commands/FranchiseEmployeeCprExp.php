<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

//models
use App\Models\Admin;
use App\Models\Franchise;
use App\Models\Notifications;
use App\Models\Franchise\Fuser;
use App\Models\Franchise\Femployee;
use App\Models\Notifications_to_franchise;
use App\Models\Franchise\Femployees_tasklist;

class FranchiseEmployeeCprExp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FR:EmployeeExpCpr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is for checking which franchise employee cpr or bacb expires.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		
		$franchises = Franchise::where('status','Active')->select('id')->get();
		
		if(!$franchises->isEmpty())
		{
			foreach($franchises as $franchise)
			{
				$F_Owner = Fuser::where('franchise_id',$franchise->id)->where('type','Owner')->first();
				$Employees = Femployee::where(array('personal_status'=>'Active', 'franchise_id'=>$franchise->id))->get();
				if(!$Employees->isEmpty()){

					foreach($Employees as $Employee)
					{
						if($Employee->cpr_regist_date)
						{
							$regDate = $Employee->cpr_regist_date;
							$regExpDate = date('Y-m-d', strtotime($regDate.'+1 year'));
							$regExpDate = date('Y-m-d', strtotime($regExpDate.'-21 days'));
							$currDate = date('Y-m-d');

							if($currDate == $regExpDate){

								$newNoti = new Notifications();
						        $newNoti->title = '<a href="'.url('franchise/employee/view/'.$Employee->id).'">CPR expiration of '.$Employee->fullname.'</a>';
						        $newNoti->description = 'CPR will be expired after 3 weeks';
						        $newNoti->type = 'Notice';
						        $newNoti->send_to_franchise_admin = '1';
						        $newNoti->user_id = $F_Owner->id;
						        $newNoti->franchise_id = $franchise->id;
						        $newNoti->user_type = 'Administration';
						        $newNoti->send_to_type = 'Franchise Administration';
						        $newNoti->notification_type = 'System Notification';
						        $newNoti->save();

					            $noti_to_franch = new Notifications_to_franchise;
					            $noti_to_franch->notification_id = $newNoti->id;
					            $noti_to_franch->franchise_id = $franchise->id;
					            $noti_to_franch->save();
								
							}
						}
					}
				}//Checkin Franchises object is not empty					
			}
		
		}

		\Log::info("Franchise Employee CPR Exp.");
    }
}
