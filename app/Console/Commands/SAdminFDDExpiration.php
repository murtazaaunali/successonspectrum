<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

//models
use App\Models\Admin;
use App\Models\Fusers;
use App\Models\Franchise;
use App\Models\Franchise\Fuser;
use App\Models\Franchise_tasklist;

use App\Models\Notifications;
use App\Models\Notifications_read_by;
use App\Models\Notifications_to_franchise;

class SAdminFDDExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SA:fdd_expiration_renewed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is for checking which franchise have pending tasks.';

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
		$currDate = date('Y-m-d');
		//Adding two weeks into current Date for check upcomming perforamance
		$upcommingDate = date('Y-m-d',strtotime($currDate."+14 days"));
        $Franchises = Franchise::whereBetween('fdd_expiration_date',[$currDate, $upcommingDate])->orWhere('fdd_expiration_date','<=',$currDate)->get();
        if(!$Franchises->isEmpty())
        {

			foreach($Franchises as $Franchise)
			{
				$datediff = strtotime($Franchise->fdd_expiration_date) - strtotime($currDate);

				$days = round($datediff / (60 * 60 * 24));	
				if($days > 0)
				{
					$message = 'Your franchise will be expire with in '.($days > 1 ? $days.' days.' : $days.' day.');

				}elseif($days == 0)
				{
					$message = 'Your franchise will be expire today.';
				
				}else
				{
					$message = 'Your franchise is expired.';
				}
				
		        $data = array("name" => $Franchise->Location, "email" => $Franchise->email, "Message" => $message);
		        \Mail::send('email.email_template', ["name" => $Franchise->Location, "email" => $Franchise->email, "link"=>url('franchise/login'), 'Message' => $message], function ($message) use ($data) {
		            $message->from(['address' => 'sos@testing.com', 'name' => 'SOS']);
		            $message->to($data['email'])->subject("Franchise Expiration Notice");
		        });
		        
		        \Log::info($Franchise->Location." Franchise Expiration Cron Running.");
			}
			
		}//Franchise Condition
    }
}
