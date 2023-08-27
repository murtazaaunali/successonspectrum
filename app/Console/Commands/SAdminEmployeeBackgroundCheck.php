<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

//Models
use App\Models\Admin;
use App\Models\Notifications;

class SAdminEmployeeBackgroundCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SA:employee_background_check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for checking employee 1 year background';

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
		$UCP_Date = date('Y-m-d', strtotime($currDate.' + 14 days'));
        \Log::info($UCP_Date);
        //Geting records of which have 14 days remaining
        $Employees = Admin::where(array('type'=>'Employee', 'employee_status'=>1, 'background_check'=>$UCP_Date))->get();
        if(!$Employees->isEmpty()){
			foreach($Employees as $Employee){

				$Admin = Admin::where(array('type'=>'Super Admin'))->first();
				$message = 'Please check 12 months background of ('.$Employee->fullname.').';
		        $data = array("name" => $Admin->fullname, "email" => $Admin->email, "messages" => $message);
		        /*\Mail::send('email.email_template', ["name" => $Admin->fullname, "email" => $Admin->email, "link"=>url('admin/login'), 'messages' => $message], function ($message) use ($data) {
		            $message->from('sos@testing.com', 'SOS');
		            $message->to($data['email'])->subject("Performance Review");
		        });*/

				$Admin = Admin::where('type','Super Admin')->first();
		        $newNoti = new Notifications();
		        $newNoti->title = '<a href="'.url('admin/employee/view/'.$Employee->id).'">Background Check</a>';
		        $newNoti->description = $message;
		        $newNoti->type = 'Notice';
		        $newNoti->send_to_admin = '1';
		        $newNoti->user_id = $Admin->id;
		        $newNoti->franchise_id = 0;
		        $newNoti->user_type = 'Administration';
		        $newNoti->send_to_type = 'Administration';
		        $newNoti->notification_type = 'System Notification';
		        $newNoti->save();
		        \Log::info($Employee->fullname.' 12 months background checking cron is running');
			}
		}
		
    }
}
