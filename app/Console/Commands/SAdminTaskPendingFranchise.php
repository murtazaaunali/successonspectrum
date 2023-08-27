<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

//models
use App\Models\Admin;
use App\Models\Franchise;
use App\Models\Notifications;
use App\Models\Franchise_tasklist;

class SAdminTaskPendingFranchise extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SA:TaskPendingFranchise';

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
		$Franchises = Franchise::all();
		if(!$Franchises->isEmpty()){
			foreach($Franchises as $Franchise){
		
				/*$messgeEmail = 'Hello! ('.$Franchise->location.'), These tasks are Incomplete, <br/><br/>';
				$EmailTest = false;
				$tasks = Franchise_tasklist::where('franchise_id', $Franchise->id)->orderby('sort','asc')->get();
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
			        $data = array("name" => $Franchise->location, "email" => $Franchise->email, "messages" => $messgeEmail);
			        \Mail::send('email.email_template', ["name" => $Franchise->location, "email" => $Franchise->email, "link"=>url('franchise/login'), 'messages' => $messgeEmail], function ($message) use ($data) {
			            $message->from('sos@testing.com', 'SOS');
			            $message->to($data['email'])->subject("Franchise Pending Task List");
			        });						
				}*/

				$messgeEmail = '';
				$EmailTest = false;
				$tasks = Franchise_tasklist::where('franchise_id', $Franchise->id)->orderby('sort','asc')->get();
				if(!$tasks->isEmpty()){
					
					foreach($tasks as $getTask)
					{
						if($getTask['status'] == 'Incomplete')
						{
							$EmailTest = true;
							$messgeEmail = $getTask['task'];

							$Admin = Admin::where('type','Super Admin')->first();
					        $newNoti = new Notifications();
					        $newNoti->title = '<a href="'.url('admin/franchise/view/'.$Franchise->id).'">Pending tasks of '.$Franchise->location.'</a>';
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
				
			}
		}//Checkin Franchises object is not empty
		\Log::info("Franchise Pending Task list Cron Running.");
    }
}
