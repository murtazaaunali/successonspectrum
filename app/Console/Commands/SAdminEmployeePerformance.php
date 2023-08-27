<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

//Models
use App\Models\Admin;
use App\Models\Notifications;

class SAdminEmployeePerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SA:EmployeePerformance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for checking employee performance review';

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
        //
        //\Log::info('Test'. \Carbon\Carbon::now());

        /*$data = array("name" => 'test', "email" => 'muzammil@geeksroot.com', "messages" => 'test message');
        \Mail::send('email.email_template', ["name" => 'Muzamil', "email" => 'muzammil@geeksroot.com', "link"=>url('admin/login'), 'messages' => 'this is test message'], function ($message) use ($data) {
            $message->from('sos@testing.com', 'SOS');
            $message->to($data['email'])->subject("Performance Review");
        });*/

		$currDate = date('Y-m-d');
		$UCP_Date = date('Y-m-d', strtotime($currDate.' + 14 days'));
        
        //Geting records of which have 14 days remaining
        $Employees = Admin::where(array('type'=>'Employee', 'employee_status'=>1, 'upcomming_performance'=>$UCP_Date))->get();
        if(!$Employees->isEmpty()){
			foreach($Employees as $Employee){

				$Admin = Admin::where(array('type'=>'Super Admin'))->first();
				$message = 'Please review 6 months performance of ('.$Employee->fullname.').';
		        $data = array("name" => $Admin->fullname, "email" => $Admin->email, "messages" => $message);

				$Admin = Admin::where('type','Super Admin')->first();
		        $newNoti = new Notifications();
		        $newNoti->title = '<a href="'.url('admin/employee/view/'.$Employee->id).'">Performance Review</a>';
		        $newNoti->description = 'Review '.$Employee->fullname."'s 6 months performance.";
		        $newNoti->type = 'Notice';
		        $newNoti->send_to_admin = '1';
		        $newNoti->user_id = $Admin->id;
		        $newNoti->franchise_id = 0;
		        $newNoti->user_type = 'Administration';
		        $newNoti->send_to_type = 'Administration';
		        $newNoti->notification_type = 'System Notification';
		        $newNoti->save();
		        \Log::info($Employee->fullname.' 6 months perfromance review cron is running');
			}
		}
		
		//Getting records which have last date and updating upcomming performance date for next six months
        /*$Employees = Admin::where(array('type'=>'Employee', 'employee_status'=>1, 'upcomming_performance'=>$currDate))->get();
        if(!$Employees->isEmpty()){
			foreach($Employees as $Employee){

				$getEmp = Admin::find($Employee->id);
				$getEmp->upcomming_performance = $UCP_Date;
				$Admin = Admin::where(array('type','Super Admin'))->first();
				$message = 'Performance review date updated of ('.$Employee->fullname.').';
		        $data = array("name" => $Admin->fullname, "email" => $Admin->email, "messages" => $message);
		        \Mail::send('email.email_template', ["name" => $Admin->fullname, "email" => $Admin->email, "link"=>url('admin/login'), 'messages' => $message], function ($message) use ($data) {
		            $message->from('sos@testing.com', 'SOS');
		            $message->to($data['email'])->subject("Performance Review");
		        });
			}
		}*/

		
    }
}
