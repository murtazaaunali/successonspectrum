<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

//models
use App\Models\Admin;
use App\Models\Franchise;
use App\Models\Notifications;
use App\Models\Employee_tasklist;

class SAdminTaskPendingEmployee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SA:TaskPendingEmployee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is for checking which employee have pending tasks.';

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
		$Employees = Admin::where('employee_title','Human Resources')->get();
		if(!$Employees->isEmpty()){
			/*foreach($Employees as $Employee){
		
				$messgeEmail = 'Hello! ('.$Employee->fullname.'), These tasks are Incomplete, <br/><br/>';
				$EmailTest = false;
				$tasks = Employee_tasklist::where('employee_id', $Employee->id)->orderby('sort','asc')->get();
				if(!$tasks->isEmpty()){
					
					foreach($tasks as $getTask){
						if($getTask['status'] == 'Incomplete'){
							$EmailTest = true;
							$messgeEmail .= '<strong>Task:</strong> '.$getTask['task'].'. <strong>Status:</strong> '.$getTask['status'].'<br/>';
						}
					}
				}
				
				if($EmailTest){
			        $Admin = Admin::where('type','Super Admin')->first();
			        $data = array("name" => $Employee->fullname, "email" => $Employee->email, "messages" => $messgeEmail);
			        \Mail::send('email.email_template', ["name" => $Employee->fullname, "email" => $Employee->email, "link"=>url('franchise/login'), 'messages' => $messgeEmail], function ($message) use ($data) {
			            $message->from('sos@testing.com', 'SOS');
			            $message->to($data['email'])->subject("Employee Pending Task List");
			        });						
				}
				
			}*/


			foreach($Employees as $Employee){
		
				$EmailTest = false;
				$tasks = Employee_tasklist::where('employee_id', $Employee->id)->orderby('sort','asc')->get();
				if(!$tasks->isEmpty()){
					
					foreach($tasks as $getTask){
						if($getTask['status'] == 'Incomplete'){
							$EmailTest = true;
							$messgeEmail = $getTask['task'];

							$Admin = Admin::where('type','Super Admin')->first();
					        $newNoti = new Notifications();
					        $newNoti->title = '<a href="'.url('admin/employee/view/'.$Employee->id).'">Pending tasks of '.$Employee->fullname.'</a>';
					        $newNoti->description = $messgeEmail;
					        $newNoti->type = 'Notice';
					        $newNoti->send_to_admin = '1';
					        $newNoti->user_id = $Admin->id;
					        $newNoti->franchise_id = 0;
					        $newNoti->user_type = 'Administration';
					        $newNoti->send_to_type = 'Administration';
					        $newNoti->notification_type = 'System Notification';
							$newNoti->notification_groups = 'tasklist';
					        $newNoti->save();

						}
					}
				}
				
				/*if($EmailTest){
			        $Admin = Admin::where('type','Super Admin')->first();
			        $data = array("name" => $Employee->fullname, "email" => $Employee->email, "messages" => $messgeEmail);
			        \Mail::send('email.email_template', ["name" => $Employee->fullname, "email" => $Employee->email, "link"=>url('franchise/login'), 'messages' => $messgeEmail], function ($message) use ($data) {
			            $message->from('sos@testing.com', 'SOS');
			            $message->to($data['email'])->subject("Employee Pending Task List");
			        });						
				}*/
				
			}
		}//Checkin Franchises object is not empty
		\Log::info("Employee Pending Task list Cron Running.");
    }
}
