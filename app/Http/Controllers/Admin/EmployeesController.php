<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\State;
use Session;
use DateTime;
use Carbon\Carbon;

use App\Models\Admin;
use App\Models\Notifications;
use App\Models\Admins_employees;
use App\Models\Employee_tasklist;
use App\Models\Admins_employees_schedules;
use App\Models\Admin_employees_time_punch;
use App\Models\Admin_employees_addperformance;
use App\Models\Admin_employees_performance_log;
use App\Models\Admins_employees_emergency_contacts;

use App\Http\Requests\Admin\Employee\CreateEmployeeRequest;
use App\Http\Requests\Admin\Employee\EditEmployeeRequest;

class EmployeesController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard()->user();
		$users[] = Auth::guard('admin')->user();
	}

    public function index(Request $request)
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Employees List";
        $sub_title                      = "Employees";
        $menu                           = "employees";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        
		//$weeks = $this->weeks(7,date('Y'));

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu
        );
        
		/*if ($handle = opendir('../storage/app/public/default_documents')) {
		    while (false !== ($entry = readdir($handle))) {
		        if ($entry != "." && $entry != "..") {
		            //echo "$entry\n <br/>";
		            //echo "['title' => '".$entry."', 'franchise_id' => 0, 'category' => 'Template Company Forms', 'user_type' => 'Franchise', 'user_id' => 0, 'shared_with_franchise_admin' => 1, 'file' => '/app/public/default_documents/".$entry."'],<br/>";
		        }
		    }
		    closedir($handle);
		}exit; */
		
		$getEmployees = Admin::where('type','Employee')
		->when($request->employee_type, function ($query, $title) {
            return $query->where('employee_title', $title);  
        })
        ->when($request->employee_name, function ($query, $name) {
        		return $query->where('fullname', 'LIKE', "%".$name."%");
        })->orderby('created_at','desc')->paginate($this->pagelimit);
            
		
		$data['getEmployees'] = $getEmployees;
		/*
		echo "<pre>";
		print_r($getEmployees);
		exit;
		*/
	    return view('admin.employees.list',$data);
    }

    public function form(){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Add Employee";
        $sub_title                      = "Add Employee";
        $menu                           = "employees";
        $sub_menu                       = "";

		$getStates = State::get();
		$states = array();
		if(!$getStates->isEmpty()){
			foreach($getStates as $state){
				$states[] = $state;
			}
		}
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "states"								=> $states
        );

		$data['days'] = array();
		for($i = 1; $i<=31; $i++){
			if($i <= 9){
				$data['days'][] = '0'.$i;
			}else{
				$data['days'][] = $i;
			}
		}

		$data['months'] = array('01','02','03','04','05','06','07','08','09','10','11','12');
		
		$data['years'] = array();
		$current_year = date('Y');
		for($i = 1970; $i<=$current_year; $i++){
			$data['years'][] = $i;
		}

	    return view('admin.employees.form',$data);			
	}

	function weeks($month, $year){
        //return $current_week = ceil((date("d",strtotime($today_date)) - date("w",strtotime($today_date)) - 1) / 7) + 1;
		/*$firstday = date("w", mktime(0, 0, 0, $month, 1, $year)); 
        $lastday = date("t", mktime(0, 0, 0, $month, 1, $year)); 
		if ($firstday!=0) $count_weeks = 1 + ceil(($lastday-8+$firstday)/7);
		else $count_weeks = 1 + ceil(($lastday-8+$firstday)/7);
	  	return $count_weeks;*/
		$weeks_in_month = $this->weeks_in_month($month, $year);
		//echo "<pre>";print_r($weeks_in_month);
		return sizeof($weeks_in_month);
	}
	
	public function getWeeks(Request $request){
		return $this->weeks($request->month, date('Y'));
	}
	
	public function weeks_in_month($month, $year)
	{
		$day_count = 1;$week = 1;$dates = [];
		$days = Carbon::createFromDate($year,$month,1)->daysInMonth;
		for ($day = 1; $day <= $days; $day++) {
			
			$dates[$week][]= Carbon::createFromDate($year,$month,$day)->format('Y-m-d');
			
			/*$dayOfWeek = Carbon::createFromDate($year,$month,$day)->format('l');
			if ($dayOfWeek === 'Sunday') {
				$week++;
			}*/
			
			if ($day_count <= 7) {
				$day_count++;
			}
			
			if ($day_count > 7) {
				$week++;
				$day_count = 1;
			}
		}
		return $dates;
	}

	/////////////////
	// View Employee
	/////////////////
	public function view(Request $request, $employee_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Employees";
        $sub_title                      = "Employees";
        $menu                           = "employees";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
        );

        //If ID IS NULL THEN REDIRECT
        if(!$employee_id) return redirect('admin/employees');
        
        $Employee = Admin::find($employee_id);
        
        if(!$Employee){
			return redirect('admin/employees');
		}

        $data['Employee'] = $Employee;
        $data['p_reviews'] = Admin_employees_addperformance::where('admin_employee_id', $employee_id)->get();
		//$data['EmployeePlannedTimeOff'] = $this->getPlannedTimeOff($employee_id);
		//$data['EmployeeUnplannedCallIn'] = $this->getUnplannedCallIn($employee_id);
		return view('admin.employees.view',$data);
	}
	
	public function updatereview(REQUEST $request)
	{
		$id = $request->id;
		$status = $request->status;
		$employee_id = $request->employee_id;
		
		$Performance 				  	= Admin_employees_addperformance::find($id);
		$Performance->status 		   	= $status;
		$Performance->save();
		return response()->json(['success' => 'Done']);		
	}
	
	function getPlannedTimeOff($employee_id)
	{
		return $Employee_performance_log = Admin_employees_performance_log::where("admin_employee_id",$employee_id)->where("event","Planned Time Off")->count();
	}
	
	function getUnplannedCallIn($employee_id)
	{
		return $Employee_performance_log = Admin_employees_performance_log::where("admin_employee_id",$employee_id)->where("event","Unplanned Call In")->count();
	}
	
	//////////////////
	//Delete Employee
	//////////////////
	public function deleteEmployee($employee_id){
		$Emp = Admin::find($employee_id);
		$Emp->delete();
		
		Admins_employees_emergency_contacts::where('admin_employee_id',$employee_id)->delete();
		Admins_employees_schedules::where('admin_employee_id',$employee_id)->delete();
		Admin_employees_time_punch::where('admin_employee_id',$employee_id)->delete();
		Employee_tasklist::where('employee_id',$employee_id)->delete();
		Admin_employees_performance_log::where('admin_employee_id',$employee_id)->delete();
		
		Session::flash('Success','<div class="alert alert-success">Employee successfully deleted</div>');
		return redirect('/admin/employees');
	}
	

	///////////////////
	//	Edit Employee
	///////////////////	
	public function edit(EditEmployeeRequest $request, $employee_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Employee";
        $sub_title                      = "Edit Employee";
        $menu                           = "employees";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
        );		
		
		$data['days'] = array();
		for($i = 1; $i<=31; $i++){
			if($i <= 9){
				$data['days'][] = '0'.$i;
			}else{
				$data['days'][] = $i;
			}
		}

		$data['months'] = array('01','02','03','04','05','06','07','08','09','10','11','12');
		
		$data['years'] = array();
		$current_year = date('Y');
		for($i = 1970; $i<=$current_year; $i++){
			$data['years'][] = $i;
		}

		if($request->isMethod('post')){

			$employee = Admin::find($employee_id);
			$employee->employee_status 							= ($request->status == 1) ? 1 : 0;
			$employee->fullname 								= $request->employee_fullname;
			$employee->employee_title 							= $request->employee_title;
			$employee->employee_address 						= $request->employee_address;
			if( $request->hiring_date ) $employee->hiring_date 	= date('Y-m-d',strtotime($request->hiring_date));
			$employee->employee_type 							= $request->employee_type;
			$employee->employee_dob 							= date('Y-m-d',strtotime($request->employee_dob));
			if( $request->completion_date ) $employee->ninty_days_probation_completion_date = date('Y-m-d',strtotime($request->completion_date));
			$employee->highest_degree_held 						= $request->highest_degree_held;
			$employee->employee_ss 								= $request->employee_ss;
			//$employee->email 									= $request->employee_email;
			$employee->email 									= $request->login_email;

			//EMAIL
			//if($request->status != $employee->employee_status){
			if(($request->status != $employee->employee_status) && !empty($employee->email)){	
				$Franchise = Franchise::find($employee->franchise_id);
				$message = 'Your Account is '.($request->status == 1 ? 'Active' : 'Inactive').' now.';
		        $data = array("name" => $employee->fullname, "email" => $employee->email, "messages" => $message);
		        \Mail::send('email.email_template', ["name" => $employee->fullname, "email" => $employee->email, "link"=>url('admin/login'), 'messages' => $message], function ($message) use ($data) {
		            $message->from('sos@testing.com', 'SOS');
		            $message->to($data['email'])->subject("Account Status Notice");
		        });
			}
			
			$employee->save();

			Session::flash('Success','<div class="alert alert-success">Employee successfully updated</div>');
			return redirect('/admin/employee/view/'.$employee_id);

		}
        
        $data['Employee'] = Admin::find($employee_id);
        return view('admin.employees.editEmployee',$data);
	}

	////////////////////
	// Add Employee
	////////////////////
	public function add(CreateEmployeeRequest $request){

		//Adding admin as employee
		$Employee = new Admin();
		$Employee->fullname 	= $request->employee_name;
		$Employee->email	 	= $request->employee_email;
		$Employee->password 	= bcrypt($request->password);
		$Employee->type	 		= 'Employee';
		$Employee->is_admin 	= 0;

		//$Employee->admin_id 				= Auth::guard('admin')->user()->id;
		//$Employee->employee_id 			= $AdminEmployee->id;
		$Employee->employee_status 			= $request->status;
		$Employee->employee_title 			= $request->employee_title;
		$Employee->employee_address 		= $request->employee_address;
		$Employee->hiring_date 				= date('Y-m-d',strtotime($request->hiring_date));
		$Employee->employee_type 			= $request->employee_type;
		$Employee->employee_dob 			= date('Y-m-d',strtotime($request->employee_dob));
		if($request->completion_date) 		$Employee->ninty_days_probation_completion_date = date('Y-m-d',strtotime($request->completion_date));
		$Employee->highest_degree_held 		= $request->highest_degree;
		$Employee->employee_ss 				= $request->employee_ss;
		$Employee->starting_pay_rate 		= $request->starting_pay;
		$Employee->current_pay_rate 		= $request->current_pay;
		$Employee->insurance_plan 			= $request->insurance_plan;
		$Employee->retirement_plan 			= $request->retirement_plan;
		$Employee->paid_vacation 			= $request->paid_vacation;
		$Employee->paid_holiday 			= $request->paid_holidays;
		$Employee->allowed_sick_leaves 		= $request->sick_leaves;
		$Employee->upcomming_performance 	= date('Y-m-d', strtotime($request->hiring_date.' + 6 months'));
		$Employee->satisfaction_survey 		= date('Y-m-d', strtotime($request->satisfaction_survey.' + 8 months'));
		$Employee->background_check 		= date('Y-m-d', strtotime($request->background_check.' + 12 months'));
		$Employee->save();
		
		if(!empty($request->emergency)){
			foreach($request->emergency as $emergency){
				$Employee_emergency = new Admins_employees_emergency_contacts();
				$Employee_emergency->admin_employee_id  = $Employee->id;
				$Employee_emergency->relationship  		= $emergency['relationship_type'];
				$Employee_emergency->fullname  			= $emergency['fullname'];
				$Employee_emergency->phone_number  		= $emergency['phonenumber'];
				$Employee_emergency->email  			= $emergency['email'];
				$Employee_emergency->save();
			}			
		}
		
		$Employee_schedule = new Admins_employees_schedules();
		$Employee_schedule->admin_employee_id 	= $Employee->id;
		if($request->monday_timein) 			$Employee_schedule->monday_time_in 		= date('H:i',strtotime($request->monday_timein));
		if($request->monday_timeout) 			$Employee_schedule->monday_time_out 	= date('H:i',strtotime($request->monday_timeout));
		if($request->tuesday_timein) 			$Employee_schedule->tuesday_time_in 	= date('H:i',strtotime($request->tuesday_timein));
		if($request->tuesday_timeout)			$Employee_schedule->tuesday_time_out	= date('H:i',strtotime($request->tuesday_timeout));
		if($request->wednesday_timein) 			$Employee_schedule->wednesday_time_in 	= date('H:i',strtotime($request->wednesday_timein));
		if($request->wednesday_timeout) 		$Employee_schedule->wednesday_time_out 	= date('H:i',strtotime($request->wednesday_timeout));
		if($request->thursday_timein) 			$Employee_schedule->thursday_time_in 	= date('H:i',strtotime($request->thursday_timein));
		if($request->thursday_timeout) 			$Employee_schedule->thursday_time_out 	= date('H:i',strtotime($request->thursday_timeout));
		if($request->friday_timein) 			$Employee_schedule->friday_time_in 		= date('H:i',strtotime($request->friday_timein));
		if($request->friday_timeout) 			$Employee_schedule->friday_time_out 	= date('H:i',strtotime($request->friday_timeout));
		if($request->saturday_timein) 			$Employee_schedule->saturday_time_in 	= date('H:i',strtotime($request->saturday_timein));
		if($request->saturday_timeout) 			$Employee_schedule->saturday_time_out 	= date('H:i',strtotime($request->saturday_timeout));
		if($request->sunday_timein) 			$Employee_schedule->sunday_time_in 		= date('H:i',strtotime($request->sunday_timein));
		if($request->sunday_timeout) 			$Employee_schedule->sunday_time_out 	= date('H:i',strtotime($request->sunday_timeout));
		$Employee_schedule->save();
		
		//Add Aditional Tasks list
		if($Employee->id){
			$sort = 1;
			foreach($this->AdditionalTasks() as $task){
				$ETask = new Employee_tasklist();
				$ETask->task = $task;
				$ETask->employee_id = $Employee->id;
				$ETask->status = 'Incomplete';
				$ETask->sort = $sort;
				$ETask->save();
				$sort++;
			}
		}
		
		if(!empty($Employee->email))
		{
			/*$data = array("name" => $Employee->fullname, "email" => $Employee->email, "password" => $request->password);
			\Mail::send('email.invite_email', ["name" => $Employee->fullname, "email" => $Employee->email, "link"=>url('admin/login'), "password" => $data['password'] ], function ($message) use ($data) {
				$message->from('sos@testing.com', 'SOS');
				$message->to($data['email'])->subject("WELCOME TO SUCCESS OF SPECTRUM");
			});*/
		}

		return response()->json(['success'=>'Yes', 'employee_id'=>$Employee->id]);
	}	

	/////////////////////
	// All task list
	/////////////////////
	public function AdditionalTasks(){
		return array(
			'Application was accepted without discrimination',
			'Interview',
			'Official Job offer sent and signed copy returned',
			'A background check consent from was obtained',
			'Recived completed employee health insurance signup from',
			'Recived completed employee Retirement benifit signup from',
			'Setup Payroll',
			'Completed Handbook training',
			'Completed HIPAA training',
			'Completed Job Duties Training',
			'Send referal to Catalyst',
			'Completed Clinical ABA Training',
			'Trainer supervised completion of Competency Checklist',
		);
	}
	
	////////////////////
	// Edit Relation
	////////////////////
	public function editRelation(Request $request, $employee_id, $relation_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Relation";
        $sub_title                      = "Edit Relation";
        $menu                           = "employees";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
        );		

		$data['Employee'] = Admin::find($employee_id);
		if(!$data['Employee']) return redirect('admin/employees');
		
		$e_contact = Admins_employees_emergency_contacts::where('admin_employee_id' , $employee_id)->where('id',$relation_id)->first();
		if(!$e_contact) return redirect('admin/employee/view/'.$employee_id);
		
		$data['emergency_contact'] = $e_contact;
		
		if($request->isMethod('post')){

			$e_raltion = Admins_employees_emergency_contacts::find($relation_id);
			$e_raltion->relationship 	= $request->relationship_type;
			$e_raltion->fullname 		= $request->fullname;
			$e_raltion->phone_number 	= $request->phonenumber;
			$e_raltion->email 			= $request->email;
			$e_raltion->save();

			Session::flash('Success','<div class="alert alert-success">Relation successfully updated</div>');
			return redirect('/admin/employee/view/'.$employee_id);

		}
        
        return view('admin.employees.relationship.editRelation',$data);
	}	

	////////////////////
	// Add Relation
	////////////////////
	public function addRelation(Request $request, $employee_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Relation";
        $sub_title                      = "Edit Relation";
        $menu                           = "employees";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
        );		

		$Employee = Admin::find($employee_id);
		if(!$Employee) return redirect('admin/employees');
				
		if($request->isMethod('post')){

			if(!empty($request->emergency)){
				foreach($request->emergency as $emergency){
					$Employee_emergency = new Admins_employees_emergency_contacts();
					$Employee_emergency->admin_employee_id  = $Employee->id;
					$Employee_emergency->relationship  		= $emergency['relationship_type'];
					$Employee_emergency->fullname  			= $emergency['fullname'];
					$Employee_emergency->phone_number  		= $emergency['phonenumber'];
					$Employee_emergency->email  			= $emergency['email'];
					$Employee_emergency->save();
				}			
			}

			Session::flash('Success','<div class="alert alert-success">Relation successfully Added</div>');
			return redirect('/admin/employee/view/'.$employee_id);

		}
        $data['Employee'] = $Employee;
        return view('admin.employees.relationship.addRelation',$data);
	}

	//////////////////
	// DELETE contact
	//////////////////
	public function deletecontact($employee_id, $contact_id){

		$Employee = Admin::find($employee_id);
        if(!$Employee){
			return redirect('admin/employees');
		}
		
		$F_owner = Admins_employees_emergency_contacts::where('admin_employee_id',$employee_id)->where('id',$contact_id);
		if(!$F_owner) return redirect('admin/employees');
		$F_owner->delete();
		
		Session::flash('Success','<div class="alert alert-success">Emergency Contact deleted successfully.</div>');
		return redirect('admin/employee/view/'.$employee_id);
		
	}		
	
	
	////////////////////
	// Edit Benifits
	////////////////////
	public function editBenifits(Request $request, $employee_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Benifits";
        $sub_title                      = "Edit Benifits";
        $menu                           = "employees";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
        );		

		$Employee = Admin::find($employee_id);
		if(!$Employee) return redirect('admin/employees');
				
		if($request->isMethod('post')){

			$Employee = Admin::find($employee_id);
			$Employee->starting_pay_rate 					= $request->starting_pay;
			$Employee->current_pay_rate 					= $request->current_pay;
			$Employee->insurance_plan 						= $request->insurance_plan;
			$Employee->retirement_plan 						= $request->retirement_plan;
			$Employee->paid_vacation 						= $request->paid_vacation;
			$Employee->paid_holiday 						= $request->paid_holidays;
			$Employee->allowed_sick_leaves 					= $request->sick_leaves;
			$Employee->save();

			Session::flash('Success','<div class="alert alert-success">Employee Benifits successfully Updated</div>');
			return redirect('/admin/employee/view/'.$employee_id);

		}
        $data['Employee'] = $Employee;
        return view('admin.employees.benifit.editBenifit',$data);
	}	


	///////////////////
	// Add Task list
	//////////////////
	public function addtasklist(Request $request, $employee_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Add Task list";
        $sub_title                      = "Add Task list";
        $menu                           = "employees";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
        );
        
        $Employee = Admin::find($employee_id);
        
        if(!$Employee){
			return redirect('admin/employees');
		}
		
		if($request->isMethod('post')){

			$messages = [
			    'task.required' => 'Task field is required',
			];
			$validator = Validator::make($request->all(), [
			    'task' => 'required',
			], $messages);
			
			if ($validator->fails()) {
	            return redirect()->back()
	                        ->withErrors($validator)
	                        ->withInput();
			}

			$tasks = Employee_tasklist::where('employee_id', $employee_id)->orderby('sort','asc')->get();
			if(!$tasks->isEmpty()){
				$sort = 1;
				foreach($tasks as $getTask){
					$U_task = Employee_tasklist::find($getTask->id);
					$U_task->sort = $sort;
					$U_task->save();
					$sort++;
				}
			}
	
			$messgeEmail = 'Hello! ('.$Employee->fullname.'), New tasks are assinged by Super Admin, <br/><br/>';
			$EmailTest = false;
		
			if(!empty($request->task)){
				foreach($request->task as $task){
					if($task == '') continue;

					$eTask = new Employee_tasklist();
					$eTask->task = $task;
					$eTask->employee_id = $employee_id;
					$eTask->status = 'Incomplete';
					$eTask->save();

					$EmailTest = true;
					$messgeEmail .= '<strong>Task: </strong>'.$eTask->task.' <br/>';

				}
			}
			
			//if($EmailTest){
		    if($EmailTest && !empty($Employee->email)){
			    $data = array("name" => $Employee->fullname, "email" => $Employee->email, "messages" => $messgeEmail);
		        \Mail::send('email.email_template', ["name" => $Employee->fullname, "email" => $Employee->email, "link"=>url('admin/login'), 'messages' => $messgeEmail], function ($message) use ($data) {
		            $message->from('sos@testing.com', 'SOS');
		            $message->to($data['email'])->subject("Employee New Task Assigned By Super Admin");
		        });						
			}
			
			Session::flash('Success','<div class="alert alert-success">Task added successfully.</div>');
			return redirect('admin/employee/viewtasklist/'.$employee_id);
		}
		
        $data['Employee'] = $Employee;

		return view('admin.employees.tasklist.addTask',$data);
	}

	/////////////////
	// VIEW TASKLIST
	////////////////
	public function viewTasklist($employee_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Employees";
        $sub_title                      = "Employees";
        $menu                           = "employees";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
        );

        if(!$employee_id) return redirect('admin/employees');
        
        $Employee = Admin::find($employee_id);
        
        if(!$Employee){
			return redirect('admin/employees');
		}
		$data['Employee'] = $Employee;
		
		//return view('admin.employees.tasklist.viewTasklist',$data);
		return view('admin.employees.tasklist.editTask',$data);
	}
	
	///////////////////
	// Edit Task list
	//////////////////
	public function edittasklist(Request $request, $employee_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Task list";
        $sub_title                      = "Edit Task list";
        $menu                           = "employees";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
        );
        
        $Employee = Admin::find($employee_id);
        
        if(!$Employee){
			return redirect('admin/employees');
		}
		
		if($request->isMethod('post')){

			$messgeEmail = 'These tasks status are changed by Super Admin, <br/><br/>';
			$EmailTest = false;
			$CompleteTaskCount = 0;

			if(!empty($request->task)){
				foreach($request->task as $task){

					$E_Tasks = Employee_tasklist::where('employee_id',$Employee->id)->where('id',$task['task_id'])->get();
					if(!$E_Tasks->isEmpty()){
						foreach($E_Tasks as $getTask)
						{
							if($getTask->id == $task['task_id'])
							{
								if($task['status'] != $getTask['status']){
									$EmailTest = true;
									$messgeEmail .= '<strong>Task:</strong> '.$task['task_description'].'. <strong>Status Changed:</strong> '.$getTask['status']. ' To '. $task['status'].'<br/>';
									if($task['status'] == 'Complete') $CompleteTaskCount = $CompleteTaskCount + 1;
								}
							}
						}
					}

					Employee_tasklist::where('employee_id',$Employee->id)->where('id',$task['task_id'])
					->update(['sort' => $task['sort'], 'task' => $task['task_description'], 'status' => $task['status'] ]);
				}
			}

			if($EmailTest){
				$Admin = Admin::where('type','Super Admin')->first();
		        if(!empty($Employee->email)){
					$data = array("name" => $Employee->fullname, "email" => $Employee->email, "messages" => $messgeEmail);
					\Mail::send('email.email_template', ["name" => $Employee->fullname, "email" => $Employee->email, "link"=>url('admin/login'), 'messages' => $messgeEmail], function ($message) use ($data) {
						$message->from('sos@testing.com', 'SOS');
						$message->to($data['email'])->subject("Admin Task List Updated");
					});			
				}
		        $newNoti = new Notifications();
		        $newNoti->title = 'Task list Updated';
		        $newNoti->description = ($CompleteTaskCount > 1 ? $CompleteTaskCount.' Tasks' : $CompleteTaskCount.' Task').' Completed of '.$Employee->fullname;
		        $newNoti->type = 'Update';
		        $newNoti->send_to_admin = '1';
		        $newNoti->user_id = Auth::guard('admin')->user()->id;
		        $newNoti->franchise_id = 0;
		        $newNoti->user_type = 'Administration';
		        $newNoti->send_to_type = 'Director of Administration';
		        $newNoti->save();
		        
			}
			
			Session::flash('Success','<div class="alert alert-success">Task list updated successfully.</div>');
			return redirect('admin/employee/viewtasklist/'.$Employee->id);
		}
        $data['Employee'] = $Employee;

		return view('admin.employees.tasklist.editTask',$data);
	}	

	/////////////////
	//	DELETE TASK
	/////////////////
	public function deletetask($employee_id, $task_id){

		$Employee = Admin::find($employee_id);
        if(!$Employee){
			return redirect('admin/employees');
		}
		
		$E_task = Employee_tasklist::where('employee_id',$employee_id)->where('id',$task_id);
		if(!$E_task) return redirect('admin/employees');
		$E_task->delete();
		
		Session::flash('Success','<div class="alert alert-success">Task deleted successfully.</div>');
		//return redirect('admin/employee/edittasklist/'.$employee_id);
		return redirect('admin/employee/viewtasklist/'.$employee_id);
	}	
	
	///////////////////////////
	// Add Forgotin time punch
	///////////////////////////
	public function addTimepunch(Request $request, $employee_id){

        $Employee           = Admin::find($employee_id);
        $employee_schedules = $Employee->employee_schedules;

		$days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
		$time1 = new DateTime($request->time_in);
		$time2 = new DateTime($request->time_out);
		$dteDiff = $time1->diff($time2);
		$hours = $dteDiff->format("%h.%I");
		
		$fullNameday = date('w',strtotime($request->date));

        //$schedule_time1        = strtotime( $employee_schedules->{strtolower($days[$fullNameday]) . '_time_in'} );
        //$schedule_time2        = strtotime( $employee_schedules->{strtolower($days[$fullNameday]) . '_time_out'} );
		$schedule_time1        = isset($employee_schedules->{strtolower($days[$fullNameday]).'_time_in'}) ? strtotime($employee_schedules->{strtolower($days[$fullNameday]).'_time_in'}) : 0;
        $schedule_time2        = isset($employee_schedules->{strtolower($days[$fullNameday]).'_time_out'}) ? strtotime($employee_schedules->{strtolower($days[$fullNameday]).'_time_out'}) : 0;
        $schedule_difference   = round(abs($schedule_time2 - $schedule_time1) / 3600,2);
        $schedule_total_hours  = ($schedule_difference) ? $schedule_difference : 0;
        $extra_hours           = $hours - $schedule_total_hours;
		
		$time = new Admin_employees_time_punch();
		$time->date					= date('Y-m-d',strtotime($request->date));
		$time->admin_employee_id	= $employee_id;
		$time->day				  = $days[$fullNameday];
		$time->time_in			  = date('H:i',strtotime($request->time_in));
		$time->time_out			 = date('H:i',strtotime($request->time_out));
		$time->total_hrs			= $hours;
		$time->status			   = 'Pending';

		if($extra_hours > 0) $time->overtime_hrs = $extra_hours;
		
		//EMAIL
		/*if($request->status != $employee->employee_status){
			$Franchise = Franchise::find($employee->franchise_id);
			$message = 'Your Account is '.($request->status == 1 ? 'Active' : 'Inactive').' now.';
			$data = array("name" => $employee->fullname, "email" => $employee->email, "messages" => $message);
			\Mail::send('email.email_template', ["name" => $employee->fullname, "email" => $employee->email, "link"=>url('admin/login'), 'messages' => $message], function ($message) use ($data) {
				$message->from('sos@testing.com', 'SOS');
				$message->to($data['email'])->subject("Account Status Notice");
			});
		}*/
		
		//Notification to Director of Administrator
		$admin = Admin::find(Auth::user()->id);
		$notification = new Notifications;
		$notification->title = '<a href="'.url('admin/employee/viewtimepunches/'.$Employee->id).'">Time Punch Added</a>';
		$notification->description = $admin->fullname.' added time punch of '.$Employee->fullname;
		$notification->type = 'Activity';
		$notification->send_to_admin = '1';
		$notification->user_id = Auth::user()->id;
		$notification->franchise_id = 0;
		$notification->user_type = 'Administration';
		$notification->send_to_type = 'Administration';
		$notification->notification_type = 'System Notification';
		$notification->save();

		$time->save();
		
		Session::flash('Success','<div class="alert alert-success">Time Punch Added.</div>');
		return redirect('admin/employee/viewtimepunches/'.$employee_id);
		
	}
	
	///////////////////////////
	// Change time punch status
	///////////////////////////
	public function changeTimepunchStatus(Request $request, $employee_id, $timepunch_id){

        $Employee       = Admin::find($employee_id);
        
        if($request->status == 'Disapproved')
        {
			Admin_employees_time_punch::find($timepunch_id)->delete();
			
		}else
		{
			$time = Admin_employees_time_punch::find($timepunch_id);
			$time->status	= $request->status;
			$time->save();
		}
		
		Session::flash('Success','<div class="alert alert-success">Time Punches Status Changed.</div>');
		return redirect('admin/employee/viewtimepunches/'.$employee_id);
		
	}

	//////////////////
	//VIEW TIMEPUNCHES
	//////////////////
	public function viewTimepunches(Request $request ,$employee_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Employees";
        $sub_title                      = "Employees";
        $menu                           = "employees";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
        );

        if(!$employee_id) return redirect('admin/employees');
        
        $Employee = Admin::find($employee_id);
        
        if(!$Employee){
			return redirect('admin/employees');
		}

		$data['months'] = array(
			'01' => 'January',
			'02' => 'February',
			'03' => 'March',
			'04' => 'April',
			'05' => 'May',
			'06' => 'June',
			'07' => 'July',
			'08' => 'August',
			'09' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December',
		);

		//CODE FOR TIME PUNCHES WEEK FILTERS
		$current_date = Carbon::now();
		$current_year = $current_date->year;
		$current_month = $current_date->month;
		$this->date = Carbon::createFromDate(date('Y'),$current_month,date('d'));
		$current_week = $this->date->weekOfMonth;
		
		if(!empty($request->week))
		$week = $request->week; //It comes from filter search
		else
		$week = $current_week;
		
		if(!empty($request->month))
		$month = $request->month; //It comes from filter search
		else
		$month = $current_month;
		
		if($week){
			$weekCount = 0; $startDate = ''; $endDate = ''; $count = 1;
			//$date = date('Y').'-'.$request->month.'-01';
			$date = date('Y').'-'.$current_month.'-01';
			for($i = 1; $i <= $week;  ){

				//$MondayDayCount = date("w", mktime(0, 0, 0, $request->month, $count, date('Y')));
				$MondayDayCount = date("w", mktime(0, 0, 0, $current_month, $count, date('Y')));
				//Counting monday for checking how many monday passed
				if($MondayDayCount == 1){
					$weekCount++;
				}
				//Check if filter week equals to passed week
				if($week == $weekCount){
					if($MondayDayCount == 1){
						$startDate = $date;
					}
					if($startDate != '' && $MondayDayCount == 0){
						$endDate = $date;
						$i++;
						break;
					}
				}
				$date = date('Y-m-d',strtotime($date.'+1 day'));
				$count++;
			}
			
			//$dates = array('startdate'=>$startDate, 'enddate'=>$endDate);
			$weeks_in_month = $this->weeks_in_month($month, $current_year);
			//echo "<pre>";print_r($weeks_in_month);
			$startDate = current($weeks_in_month[$week]);
			$endDate = end($weeks_in_month[$week]);
			$dates = array('startdate'=>$startDate, 'enddate'=>$endDate);			
		}else{
			$dates = array();
		}
		//CODE FOR TIME PUNCHES WEEK FILTERS

		$data['month'] = '';
		$data['week'] = '';

        $Employee_timepunches = array();
		//IF HAS MONTH
        //if($request->month)
		if($current_month)
        {
            /*$Employee_timepunches = Admin_employees_time_punch::where('admin_employee_id',$employee_id)
                ->when($dates, function ($query, $dates) {
                    return $query->whereBetween('date', [$dates['startdate'], $dates['enddate']]);
                })->get();*/
			
			if(Auth::guard('admin')->user()->type != "Super Admin" && Auth::guard('admin')->user()->employee_title != "Director of Administration")
			{
				$Employee_timepunches = Admin_employees_time_punch::where('admin_employee_id',$employee_id)
                ->when($dates, function ($query, $dates) {
                    return $query->whereBetween('date', [$dates['startdate'], $dates['enddate']]);
                })->where('status','Approved')->get();
			}
			else
			{
				$Employee_timepunches = Admin_employees_time_punch::where('admin_employee_id',$employee_id)
                ->when($dates, function ($query, $dates) {
                    return $query->whereBetween('date', [$dates['startdate'], $dates['enddate']]);
                })->get();
			}
        }

        $days = array( "monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday");

        $employee_schedules_data    = array();
        $employee_schedules         = $Employee->employee_schedules;
        $complete_hours             = 0;

        foreach($days as $day)
        {

            //$time_in        = ($employee_schedules->{$day.'_time_in'}) ? date("g:i A", strtotime($employee_schedules->{$day.'_time_in'}) ) : "-";
            //$time_out       = ($employee_schedules->{$day.'_time_out'}) ? date("g:i A", strtotime($employee_schedules->{$day.'_time_out'}) ) : "-";
			$time_in        = isset($employee_schedules->{$day.'_time_in'}) ? date("g:i A", strtotime($employee_schedules->{$day.'_time_in'}) ) : "-";
            $time_out       = isset($employee_schedules->{$day.'_time_out'}) ? date("g:i A", strtotime($employee_schedules->{$day.'_time_out'}) ) : "-";
           
            $total_hours    = "-";


            if($time_in != "" && $time_out != "")
            {
                $time1          = strtotime($time_in);
                $time2          = strtotime($time_out);
                $difference     = round(abs($time2 - $time1) / 3600,2);
                $total_hours    = ($difference) ? $difference : "-";
            }

            $employee_schedules_data[] = array(
                "day"           =>  ucfirst($day),
                "time_in"       =>  $time_in,
                "time_out"      =>  $time_out,
                "total_hours"   =>  $total_hours
            );

            if($total_hours != "-") $complete_hours = $complete_hours + $total_hours;
        }
        
        /*$data['month'] = $request->month;
        $data['week'] = $request->week;*/
		$data['month'] = $month;
        $data['week'] = $week;
        
		$data['Employee'] = $Employee;
		$data['Employee_timepunches']   = $Employee_timepunches;
		$data['Employee_schedule_hours']= $complete_hours;
		
		$hours_logs = [];
		foreach($Employee_timepunches as $key=>$Employee_timepunch)
		{
			$hours_logs[$key]['x'] = $Employee_timepunch->date;
			$femployee_time_punch_total_hrs = $Employee_timepunch->total_hrs;
			$hours_logs[$key]['y'] = !empty($femployee_time_punch_total_hrs)?$femployee_time_punch_total_hrs:0;
		}
		$data['hours_logs']= json_encode($hours_logs);//print_r($data['hours_logs']);
		
		return view('admin.employees.timepunches.viewTimepunches',$data);		
	}	
	
	/////////////////////
	//ADD PERFORMANCE LOG
	/////////////////////
	public function addperformance(Request $request, $employee_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Add Performance";
        $sub_title                      = "Add Performance";
        $menu                           = "employees";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
        );

        $Employee = Admin::find($employee_id);
        
        if(!$Employee){
			return redirect('admin/employees');
		}

        $PerformanceLogEvents = array(
            'Tardy',
            'Planned Time Off',
            'Unplanned Call In',
            'Performance Review',
            'Pay Change',
            'Policy Violation',
            'FMLA',
            'Bereavement Leave',
            'Human Resources'
        );
        $data['PerformanceLogEvents'] = $PerformanceLogEvents;
		
		if($request->isMethod('post')){

			$addPerform = new Admin_employees_performance_log();
			$addPerform->date 			= date('Y-m-d',strtotime($request->date));
			$addPerform->event 			= $request->event;
			$addPerform->comment 		= $request->comment;
			$addPerform->description 	= $request->description;
			$addPerform->admin_employee_id 	= $employee_id;
			$addPerform->save();
			
			Session::flash('Success','<div class="alert alert-success">Performance Log added successfully.</div>');
			return redirect('admin/employee/viewperformancelog/'.$Employee->id);
		}
        $data['Employee'] = $Employee;
        		
		return view('admin.employees.performance.addPerformance',$data);
	}

	//////////////////////
	//VIEW PERFORMANCE LOG
	//////////////////////
	public function viewPerformancelog(Request $request ,$employee_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Employees";
        $sub_title                      = "Employees";
        $menu                           = "employees";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
        );

        if(!$employee_id) return redirect('admin/employees');
        
        $Employee = Admin::find($employee_id);
        
        if(!$Employee){
			return redirect('admin/employees');
		}

		$data['months'] = array(
			'01' => 'January',
			'02' => 'February',
			'03' => 'March',
			'04' => 'April',
			'05' => 'May',
			'06' => 'June',
			'07' => 'July',
			'08' => 'August',
			'09' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December',
		);
		
        $PerformanceLogEvents = array(
            'Tardy',
            'Planned Time Off',
            'Unplanned Call In',
            'Performance Review',
            'Pay Change',
            'Policy Violation',
            'FMLA',
            'Bereavement Leave',
            'Human Resources'
        );

		//FILTERS FOR PERFORMANCE LOG

		$Employee_performance = Admin_employees_performance_log::where('admin_employee_id',$employee_id)
		->when($request->month, function ($query, $month) {
                return $query->whereMonth('date', $month);
        })->when($request->event, function ($query, $event) {
                return $query->where('event', $event);
        })->orderby('date','desc')->get();
        
        $data['PerformanceLogEvents'] = $PerformanceLogEvents;
		$data['Employee'] = $Employee;
		$data['Employee_performance']   = $Employee_performance;
		
		return view('admin.employees.performance.viewPerformancelog',$data);
	}
	
	//////////////////////
	//PERFORMANCE UPDATE
	//////////////////////
	public function performanceupdate(Request $request, $employee_id){
		
		$perform = Admin_employees_performance_log::where('admin_employee_id',$employee_id);
		$perform->delete();
		
		if(!empty($request->performance)){
			foreach($request['performance'] as $performance){
				$addPerform = new Admin_employees_performance_log();
				$addPerform->date 				= date('Y-m-d',strtotime( $performance['date'] ));
				$addPerform->event 				= $performance['event'];
				$addPerform->comment 			= $performance['comment'];
				$addPerform->description 		= $performance['description'];
				$addPerform->admin_employee_id 	= $employee_id;
				$addPerform->save();				
			}
		}
		
		Session::flash('Success','<div class="alert alert-success">Performance Log updated successfully..</div>');
		return redirect('admin/employee/viewperformancelog/'.$employee_id);		

	}
	
	//////////////////////
	//PERFORMANCE DELETE
	//////////////////////
	public function performanceDelete($employee_id, $performanceID){
		if(Auth::guard('admin')->check()){
			$emp = Admin::find($employee_id);
			if(!$emp){
				echo "employee not found";exit;
			}
			$performance = Admin_employees_performance_log::where(array('id'=>$performanceID, 'admin_employee_id'=> $employee_id))->first();
			if($performance){
				Admin_employees_performance_log::find($performance->id)->delete();
			}
			
			Session::flash('Success','<div class="alert alert-success">Performance successfully deleted</div>');
			return redirect('/admin/employee/viewperformancelog/'.$employee_id.'?performance_log=edit');
		}else{
			echo "No performance log found";
		}
	}

	////////////////
	//TRIP ITINERARY
	////////////////
	public function viewTripitinerary($employee_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Employees";
        $sub_title                      = "Employees";
        $menu                           = "employees";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
        );

        if(!$employee_id) return redirect('admin/employees');
        
        $Employee = Admin::find($employee_id);
        
        if(!$Employee){
			return redirect('admin/employees');
		}

       $days = array( "monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday");

        $employee_schedules_data    = array();
        $employee_schedules         = $Employee->employee_schedules;
        $complete_hours             = 0;

        foreach($days as $day)
        {

            $time_in        = ($employee_schedules->{$day.'_time_in'}) ? date("g:i A", strtotime($employee_schedules->{$day.'_time_in'}) ) : "-";
            $time_out       = ($employee_schedules->{$day.'_time_out'}) ? date("g:i A", strtotime($employee_schedules->{$day.'_time_out'}) ) : "-";
            $total_hours    = "-";


            if($time_in != "" && $time_out != "")
            {
                $time1          = strtotime($time_in);
                $time2          = strtotime($time_out);
                $difference     = round(abs($time2 - $time1) / 3600,2);
                $total_hours    = ($difference) ? $difference : "-";
            }

            $employee_schedules_data[] = array(
                "day"           =>  ucfirst($day),
                "time_in"       =>  $time_in,
                "time_out"      =>  $time_out,
                "total_hours"   =>  $total_hours
            );

            if($total_hours != "-") $complete_hours = $complete_hours + $total_hours;
        }
        
		$data['Employee'] = $Employee;
        $data['Employee_schedule']      = $employee_schedules_data;
        $data['Employee_schedule_hours']= $complete_hours;
		
		return view('admin.employees.tripitinerary.viewTripitinerary',$data);
	}

	///////////////////////
	//TRIP ITINERARY UPDATE
	///////////////////////
    public function tripitenaryupdate(Request $request, $id)
    {
        $days = array(
            "monday",
            "tuesday",
            "wednesday",
            "thursday",
            "friday",
            "saturday",
            "sunday",
        );

        $tripitenary = Admins_employees_schedules::findOrNew($id);
        foreach($days as $day)
        {
            if( $request->{$day.'_time_in'})  $tripitenary->{$day.'_time_in'} = date("H:i:s",strtotime( $request->{$day.'_time_in'}));
            else $tripitenary->{$day.'_time_in'} = NULL;

            if( $request->{$day.'_time_out'})  $tripitenary->{$day.'_time_out'} = date("H:i:s",strtotime( $request->{$day.'_time_out'}));
            else $tripitenary->{$day.'_time_out'} = NULL;
        }
        $tripitenary->save();

        Session::flash('Success','<div class="alert alert-success">Trip Itenary updated successfully.</div>');
        return redirect('admin/employee/viewtripitinerary/'.$request->admin_employee_id);

    }
	
	public function printReport(Request $request, $employee_id){
		
		$starDate = date('Y-m-d',strtotime($request->startReport));
		$endDate = date('Y-m-d',strtotime($request->endReport));
		$report = Admin_employees_time_punch::whereBetween('date', [$starDate, $endDate])->where('admin_employee_id',$employee_id)->orderby('date','asc')->get();
		
		$data['report'] = $report;
		$data['employee_id'] = $employee_id;
		
		return view('admin.employees.report',$data);
		
	}
	
	
	///////////////////////////////
	// Email Exist for add employee
	///////////////////////////////
	public function EmailExist(Request $request){
		
		$messages = [
		    'email.required' => 'Email Already exit.',
		];
		
		$condition = 'email|unique:admins,email';
		if(isset($request->employee_id)){
			$condition = 'email|unique:admins,email,'.$request->employee_id;
		}
		
		$validator = Validator::make($request->all(), [
		    'email' => $condition,
		], $messages);
		
		if ($validator->fails()) {
            return response()->json([ 'errors' => $validator->customMessages ]);
		}
		
		 return response()->json(['success' => 'Done']);
		 		
	}


	/////////////////
	//Invite Employee
	/////////////////
	public function inviteEmployee(REQUEST $request, $employee_id){
		$Employee = Admin::find($employee_id);
		
		$Employee->email 	= $request->login_email;
		$Employee->password = bcrypt($request->emp_password);
		$Employee->save();
		
        if(!empty($Employee->email))
		{
			$data = array( "name" => $Employee->fullname, "email" => $Employee->email, "password" => $request->emp_password);
			\Mail::send('email.invite_email', ["name" => $data['name'], "email" => $data['email'], "password" => $data['password'], "link"=>url('admin/login')], function ($message) use ($data) {
				$message->from('sos@testing.com', 'SOS');
				$message->to($data['email'])->subject("INVITATION OF SOS");
			});
		}
        
		Session::flash('Success','<div class="alert alert-success">Credentials successfully sent to Employee.</div>');
		return redirect('/admin/employee/edit/'.$employee_id);
		
	}

}