<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

//Models
use App\Models\Admin;
use App\Models\Notifications;
use App\Models\Admin_employees_addperformance;

class SAdminEmployeeAddPerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SA:EmployeeAddPerformance';

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

		$currDate = date('Y-m-d');
		$UCP_Date = date('Y-m-d', strtotime($currDate.' + 14 days'));
        
        //Geting records of which have 14 days remaining
        $Employees = Admin::where(array('type'=>'Employee', 'employee_status'=>1))
        					->where('upcomming_performance','>=',$currDate)
        					->where('upcomming_performance','<=',$UCP_Date)->get();
        if(!$Employees->isEmpty())
        {
			foreach($Employees as $Employee)
			{
				$Admin = Admin::where(array('type'=>'Super Admin'))->first();
				$message = 'Please review 6 months performance of ('.$Employee->fullname.').';
		        $data = array("name" => $Admin->fullname, "email" => $Admin->email, "messages" => $message);

		        \Mail::send('email.email_template', ["name" => 'Muzamil', "email" => 'muzammil@geeksroot.com', "link"=>url('admin/login'), 'messages' => 'this is test message'], function ($message) use ($data) {
		            $message->from('sos@testing.com', 'SOS');
		            $message->to($data['email'])->subject("Performance Review");
		        });
			}
		}
		//\Log::info('Test'. \Carbon\Carbon::now().' Employee Test '. $currDate);
		
		//updating performance date of employees
		$Employees = Admin::where(array('type'=>'Employee', 'employee_status'=>1))
							->where('upcomming_performance','<=',$currDate)
							->orWhere('upcomming_performance','0000-00-00')->get();
        if(!$Employees->isEmpty())
        {
        	
			foreach($Employees as $Employee)
			{
		        $AdPerfReviews = new Admin_employees_addperformance();
		        $AdPerfReviews->admin_employee_id = $Employee->id;
		        $AdPerfReviews->status = date('Y-m-d h:i:s');
		        $AdPerfReviews->save();
		        
		        $getEmp = Admin::find($Employee->id);
		        $getEmp->upcomming_performance = date('Y-m-d', strtotime($currDate.' + 6 months'));
		        $getEmp->save();
		        //\Log::info('Test'. \Carbon\Carbon::now().' Employee '.$Employee->fullname);
			}
		}
		
		$getPerformances = Admin_employees_addperformance::where('status','')->get();
		if(!$getPerformances->isEmpty())
		{
			foreach($getPerformances as $getPer)
			{
				//\Log::info('Test'. \Carbon\Carbon::now().' Employee Test '. $currDate);
				$emp = Admin::find($getPer->admin_employee_id);
				if($emp->upcomming_performance > $getPer->created_at)
				{
					\Log::info('Test'. \Carbon\Carbon::now().' Employee Test '. $currDate);
					$adPer = Admin_employees_addperformance::find($getPer->id);
					$adPer->status = 'Pending';
					$adPer->save();
				}
			}
		}
		

    }
}
