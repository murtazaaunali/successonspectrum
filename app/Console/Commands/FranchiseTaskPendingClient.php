<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

//models
use App\Models\Admin;
use App\Models\Franchise;
use App\Models\Notifications;
use App\Models\Franchise\Fuser;
use App\Models\Franchise\Client;
use App\Models\Franchise\Client_tasklist;

class FranchiseTaskPendingClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FR:TaskPendingClient';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is for checking which franchise clients have pending tasks.';

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
		
		$franchises = Franchise::where('status','Active')->select('id, location')->get();
		
		if(!$franchises->isEmpty())
		{
			foreach($franchises as $franchise)
			{
				$F_Owner = Fuser::where('franchise_id',$franchise->id)->where('type','Owner')->first();
				$Employees = Femployee::where(array('personal_status'=>'Active', 'franchise_id'=>$franchise->id))->get();
				if(!$Employees->isEmpty()){

					foreach($Employees as $Employee)
					{
				
						$EmailTest = false;
						$tasks = Femployees_tasklist::where('employee_id', $Employee->id)->orderby('sort','asc')->get();
						if(!$tasks->isEmpty())
						{
							
							foreach($tasks as $getTask)
							{
								if($getTask['status'] == 'Incomplete'){
									$EmailTest = true;
									$messgeEmail = $getTask['task'];

									$newNoti = new Notifications();
							        $newNoti->title = '<a href="'.url('franchise/employee/view/'.$Employee->id).'">Pending tasks of '.$Employee->fullname.'</a>';
							        $newNoti->description = $messgeEmail;
							        $newNoti->type = 'Notice';
							        $newNoti->send_to_franchise_admin = '1';
							        $newNoti->user_id = $F_Owner->id;
							        $newNoti->franchise_id = $franchise->id;
							        $newNoti->user_type = 'Franchise Administration';
							        $newNoti->send_to_type = 'Franchise Administration';
							        $newNoti->notification_type = 'System Notification';
									$newNoti->notification_groups = 'tasklist';
							        $newNoti->save();

								}
							}
							
						}
						
					}
				}//Checkin Franchises object is not empty					
			}
		
		}

		\Log::info("Franchise Employee Pending Task list Cron Running.");
    }
}
