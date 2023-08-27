<?php

namespace App\Http\Controllers\Franchise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\State;
use Session;
use DateTime;
use Carbon\Carbon;

//Requests
use App\Http\Requests\Franchise\Employee\CreateEmployeeRequest;
use App\Http\Requests\Franchise\Employee\EditEmployeeRequest;

//Models
use App\Models\Admin;
use App\Models\Franchise;
use App\Models\Franchise\Femployee;
use App\Models\Franchise\Femployees_tasklist;
use App\Models\Franchise\Femployees_schedules;
use App\Models\Franchise\Femployees_time_punch;
use App\Models\Franchise\Femployees_certifications;
use App\Models\Franchise\Femployees_performance_log;
use App\Models\Franchise\Femployees_login_credentials;
use App\Models\Franchise\Femployees_emergency_contacts;
use App\Models\Franchise\Femployees_aba_experience_reference;


class EmployeesController extends Controller
{
	
	function __construct(){
		$users[] = Auth::user();
		$users[] = Auth::guard('franchise')->user();
		$users[] = Auth::guard('franchise')->user();
		
		$this->middleware(function ($request, $next) {
		    $this->user = auth()->user();
			//If user type is not owner or manager then redirecting to dashboard
			if($this->user->type != 'Owner' && $this->user->type != 'Manager' && $this->user->type != 'BCBA' && $this->user->type != 'Intern'){
				return redirect('franchise/dashboard');
			}
		    return $next($request);
		});
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
 
		$getEmployees = Femployee::when($request->employee_type, function ($query, $title) {
            return $query->where('assigned_position', $title);  
        })
        ->when($request->employee_name, function ($query, $name) {
        		return $query->where('personal_name', 'LIKE', "%".$name."%");
        })->when($request->status, function ($query, $status) {
        		return $query->where('personal_status', $status);
        })
        ->where('franchise_id',Auth::guard('franchise')->user()->franchise_id)
        ->orderby('created_at','desc')->paginate($this->pagelimit);
            
		
		$data['getEmployees'] = $getEmployees;

	    return view('franchise.employees.list',$data);
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
		
		$getFranchises = Franchise::when('Active', function ($query, $status) {
            return $query->where('status', $status);
        })
		->orderby('created_at','desc')->paginate($this->pagelimit);
		$data['franchises'] = array();
		if($getFranchises){
			foreach($getFranchises as $franchise){
				$data['franchises'][] = $franchise;
			}
		}
		
	    return view('franchise.employees.form',$data);			
	}


	function weeks($month, $year){
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
        if(!$employee_id) return redirect('franchise/employees');
        
        $Employee = Femployee::find($employee_id);
        
        if(!$Employee){ return redirect('franchise/employees'); }
        if($Employee->franchise_id != Auth::guard('franchise')->user()->franchise_id){
			echo "You can't access another Franchise of Employee";exit;
		}

        $data['Employee'] = $Employee;
		return view('franchise.employees.view',$data);
	}
	
	//////////////////
	//Delete Employee
	//////////////////
	public function deleteEmployee($employee_id){
		
		$franchise_id = Auth::guard('franchise')->user()->franchise_id;
		$Emp = Femployee::where(array('id'=>$employee_id, 'franchise_id'=>$franchise_id))->first();
		
		if(!$Emp){ echo "Employee not found";exit; }
        //if($Employee->franchise_id != $franchise_id){
		if($Emp->franchise_id != $franchise_id){	
        	
			echo "Employee not found";exit;
			
		}else{
			
			if($Emp->pdf){
				if (file_exists(storage_path().'/app/public/employmentform/pdf')) {
				    unlink(storage_path().'/app/public/employmentform/pdf/'.basename($Emp->pdf));
				}				
			}
			$Emp->delete();
			
			Femployees_emergency_contacts::where('admin_employee_id',$employee_id)->delete();
			Femployees_schedules::where('admin_employee_id',$employee_id)->delete();
			Femployees_time_punch::where('admin_employee_id',$employee_id)->delete();
			Femployees_tasklist::where('employee_id',$employee_id)->delete();
			Femployees_performance_log::where('admin_employee_id',$employee_id)->delete();
			Femployees_aba_experience_reference::where('admin_employee_id',$employee_id)->delete();
			Femployees_certifications::where('admin_employee_id',$employee_id)->delete();
			Femployees_login_credentials::where('admin_employee_id',$employee_id)->delete();
			
			Session::flash('Success','<div class="alert alert-success">Employee successfully deleted</div>');
			return redirect('/franchise/employees');
		}
		
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
			//exit;
			$employee = Femployee::find($employee_id);
			$employee->personal_status 					= $request->status;
			$employee->personal_name 					= $request->employee_fullname;
			$employee->personal_dob 					= ($request->employee_dob) ? date('Y-m-d',strtotime($request->employee_dob)) : '0000-00-00';
			$employee->personal_address 				= $request->employee_address;
			$employee->personal_city 					= $request->employee_city;
			$employee->personal_state 					= $request->employee_state;
			$employee->personal_zipcode 				= $request->employee_zipcode;
			$employee->personal_ss 						= $request->employee_ss;
			$employee->personal_email 					= $request->employee_email;
			$employee->personal_phone 					= $request->employee_phone;
			$employee->crew_type 						= $request->crew_type;
			$employee->work_authorised	 				= $request->work_authorised;
			$employee->work_capable	 				    = $request->work_capable;
			$employee->work_nocapable	 				= $request->work_nocapable;
			$employee->work_liftlbs	 				    = $request->work_liftlbs;
			$employee->career_desired_schedule	 		= $request->employee_type;
			$employee->career_desired_position	 		= isset($request->desired_title) && !empty($request->desired_title) ? implode(',',$request->desired_title) : '';
			$employee->assigned_position	 			= $request->employee_title;
			$employee->career_earliest_startdate	 	= ($request->hiring_date) ? date('Y-m-d',strtotime($request->hiring_date)) : '0000-00-00';
			$employee->career_probation_completion_date = ($request->completion_date) ? date('Y-m-d',strtotime($request->completion_date)) : '0000-00-00';
			$employee->career_highest_degree 	 		= $request->highest_degree_held;
			$employee->career_desired_location	 		= $request->career_desired_location;
			$employee->career_bacb             	 		= $request->career_bacb;
			$employee->bacb_regist_date 				= ($request->career_bacb == 'Yes') ? date('Y-m-d',strtotime($request->bacb_regist_date)) : '0000-00-00';
			$employee->career_cpr_certified        		= $request->career_cpr_certified;
			$employee->cpr_regist_date 					= ($request->career_cpr_certified == 'Yes') ? date('Y-m-d',strtotime($request->cpr_regist_date)) : '0000-00-00';
			
			$currDate = date('Y-m-d');
			$employee->upcomming_performance 			= date('Y-m-d',strtotime($currDate.'+6 months'));
			if($request->emp_password)					$employee->password = bcrypt($request->emp_password);

			//EMAIL
			if($request->status != $employee->status){
				$Franchise = Franchise::find($employee->franchise_id);
				$message = 'Your Account is '.$request->status.' by ('.$Franchise->location.').';
		        $data = array("name" => $employee->personal_name, "email" => $employee->personal_email, "messages" => $message);
		        \Mail::send('email.email_template', ["name" => $employee->personal_name, "email" => $employee->personal_email, "link"=>url('femployee/login'), 'messages' => $message], function ($message) use ($data) {
		            $message->from('sos@testing.com', 'SOS');
		            $message->to($data['email'])->subject("Account Status Notice");
		        });
			}
			
			$employee->save();

			Session::flash('Success','<div class="alert alert-success">Employee successfully updated</div>');
			return redirect('/franchise/employee/view/'.$employee_id);

		}
        
        $data['Employee'] = Femployee::find($employee_id);
		
		$getFranchises = Franchise::when('Active', function ($query, $status) {
            return $query->where('status', $status);
        })
		->orderby('created_at','desc')->paginate(0);
		$data['franchises'] = array();
		if($getFranchises){
			foreach($getFranchises as $franchise){
				$data['franchises'][] = $franchise;
			}
		}
		
		return view('franchise.employees.editEmployee',$data);
	}
	
	/////////////////
	//Invite Employee
	/////////////////
	public function inviteEmployee(REQUEST $request, $employee_id){
		$Employee = Femployee::find($employee_id);
		$franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Employee->franchise_id != $franchise_id){
			echo "You can't access another franchise of Employee";exit;
		}
		
		$Employee->personal_email 	= $request->login_email;
		$Employee->password = bcrypt($request->emp_password);
		$Employee->save();
		
        /*$data = array( "name" => $Employee->personal_name, "email" => $Employee->email, "password" => $request->emp_password);
        \Mail::send('email.invite_email', ["name" => $data['name'], "email" => $data['email'], "password" => $data['password'], "link"=>url('femployee/login')], function ($message) use ($data) {
            $message->from('sos@testing.com', 'SOS');
            $message->to($data['email'])->subject("INVITATION OF SOS");
        });*/
        
		Session::flash('Success','<div class="alert alert-success">Invitation successfully sent to Employee.</div>');
		return redirect('/franchise/employee/edit/'.$employee_id);
		
	}

	////////////////////
	// Add Employee
	////////////////////
	public function add(CreateEmployeeRequest $request){

		//Adding admin as employee
		$Employee = new Femployee();
		
		//Employer's Demographic
		$Employee->personal_status       			= $request->status;
		$Employee->personal_name					= $request->employee_name;
		if($request->employee_dob)					$Employee->personal_dob 					= date('Y-m-d',strtotime($request->employee_dob));
		$Employee->personal_address	 				= $request->employee_address;
		$Employee->personal_city	 				= $request->employee_city;
		$Employee->personal_state	 				= $request->employee_state;
		$Employee->personal_zipcode	 				= $request->employee_zipcode;
		$Employee->personal_ss 						= $request->employee_ss;
		$Employee->personal_email	 				= $request->employee_email;
		$Employee->email	 						= $request->employee_email;
		$Employee->personal_phone	 				= $request->employee_phone;
		$Employee->work_authorised	 				= $request->work_authorised;
		$Employee->work_capable	 				    = $request->work_capable;
		$Employee->work_nocapable	 				= $request->work_nocapable;
		$Employee->work_liftlbs	 				    = $request->work_liftlbs;
		$Employee->career_desired_schedule	 		= $request->employee_type;
		$Employee->career_desired_position	 		= $request->employee_title;
		if($request->hiring_date)					$Employee->career_earliest_startdate	 	= date('Y-m-d',strtotime($request->hiring_date));
		if($request->completion_date) 				$Employee->career_probation_completion_date = date('Y-m-d',strtotime($request->completion_date));
		$Employee->career_highest_degree 	 		= $request->highest_degree;
		$Employee->career_desired_location	 		= $request->career_desired_location;
		$Employee->career_bacb             	 		= $request->career_bacb;
		$Employee->career_cpr_certified        		= $request->career_cpr_certified;
		$Employee->password 						= bcrypt($request->password);
		//$Employee->admin_id 						= Auth::guard('franchise')->user()->id;
		$Employee->franchise_id 					= Auth::guard('franchise')->user()->franchise_id;
		
		//Benefits Information
		$Employee->career_desired_pay 				= $request->desired_pay;
		$Employee->career_starting_pay 				= $request->starting_pay;
		$Employee->career_current_pay 				= $request->current_pay;
		$Employee->career_insurance_plan 			= $request->insurance_plan;
		$Employee->career_retirement_plan 			= $request->retirement_plan;
		$Employee->career_paid_vacation 			= $request->paid_vacation;
		$Employee->career_paid_holiday 				= $request->paid_holidays;
		$Employee->career_allowed_sick_leaves 		= $request->sick_leaves;

		$currDate = date('Y-m-d');
		$Employee->upcomming_performance 			= date('Y-m-d',strtotime($currDate.'+6 months'));
		
		$Employee->save();
		
		//Add Emergency Contacts
		if(!empty($request->emergency)){
			foreach($request->emergency as $emergency){
				$Employee_emergency = new Femployees_emergency_contacts();
				$Employee_emergency->admin_employee_id  = $Employee->id;
				$Employee_emergency->relationship  		= $emergency['relationship_type'];
				$Employee_emergency->fullname  			= $emergency['fullname'];
				$Employee_emergency->phone_number  		= $emergency['phonenumber'];
				$Employee_emergency->email  			= $emergency['email'];
				$Employee_emergency->save();
			}			
		}
		
		//Add Scedule Times
		$Employee_schedule = new Femployees_schedules();
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
				$ETask = new Femployees_tasklist();
				$ETask->task = $task;
				$ETask->employee_id = $Employee->id;
				$ETask->status = 'Incomplete';
				$ETask->sort = $sort;
				$ETask->save();
				$sort++;
			}
		}		
		
		//Add Experience/Reference 
		if(!empty($request->aba_experience_reference)){
			foreach($request->aba_experience_reference as $aba_experience_reference){
				$Femployees_aba_experience_reference = new Femployees_aba_experience_reference();
				$Femployees_aba_experience_reference->admin_employee_id  = $Employee->id;
				$employment_startingdate = date('Y-m-d',strtotime($aba_experience_reference['employment_startingdate']));
				$employment_endingdate = date('Y-m-d',strtotime($aba_experience_reference['employment_endingdate']));
				$Femployees_aba_experience_reference->employment_startingdate = $employment_startingdate;
				$Femployees_aba_experience_reference->employment_endingdate = $employment_endingdate;
				$Femployees_aba_experience_reference->companyname = $aba_experience_reference['companyname'];
				$Femployees_aba_experience_reference->positionheld = $aba_experience_reference['positionheld'];
				$Femployees_aba_experience_reference->reasonforleaving = $aba_experience_reference['reasonforleaving'];
				$Femployees_aba_experience_reference->managersname = $aba_experience_reference['managersname'];
				$Femployees_aba_experience_reference->phone = $aba_experience_reference['phone'];
				$Femployees_aba_experience_reference->save();
			}			
		}

		$data = array("name" => $Employee->personal_name, "email" => $Employee->personal_email, "password" => $request->password);
        \Mail::send('email.invite_email', ["name" => $Employee->fullname, "email" => $Employee->email, "link"=>url('femployee/login'), "password" => $data['password'] ], function ($message) use ($data) {
            $message->from('sos@testing.com', 'SOS');
            $message->to($data['email'])->subject("WELCOME TO SUCCESS OF SPECTRUM");
        });	
		
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
		
		$Employee = Femployee::find($employee_id);
		if(!$Employee) return redirect('franchise/employees');
		
		if(Auth::guard('franchise')->user()->franchise_id != $Employee->franchise_id){ return redirect('franchise/employees'); }

		$data['Employee'] = $Employee;
		if(!$data['Employee']) return redirect('franchise/employees');
		
		$e_contact = Femployees_emergency_contacts::where('admin_employee_id' , $employee_id)->where('id',$relation_id)->first();
		if(!$e_contact) return redirect('franchise/employee/view/'.$employee_id);
		
		$data['emergency_contact'] = $e_contact;
		
		if($request->isMethod('post')){

			$e_raltion = Femployees_emergency_contacts::find($relation_id);
			$e_raltion->relationship 	= $request->relationship_type;
			$e_raltion->fullname 		= $request->fullname;
			$e_raltion->phone_number 	= $request->phonenumber;
			$e_raltion->email 			= $request->email;
			$e_raltion->save();

			Session::flash('Success','<div class="alert alert-success">Relation successfully updated</div>');
			return redirect('/franchise/employee/view/'.$employee_id);

		}
        
        return view('franchise.employees.relationship.editRelation',$data);
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

		$Employee = Femployee::find($employee_id);
		if(!$Employee) return redirect('franchise/employees');
		
		if(Auth::guard('franchise')->user()->franchise_id != $Employee->franchise_id){ return redirect('franchise/employees'); }
				
		if($request->isMethod('post')){

			if(!empty($request->emergency)){
				foreach($request->emergency as $emergency){
					$Employee_emergency = new Femployees_emergency_contacts();
					$Employee_emergency->admin_employee_id  = $Employee->id;
					$Employee_emergency->relationship  		= $emergency['relationship_type'];
					$Employee_emergency->fullname  			= $emergency['fullname'];
					$Employee_emergency->phone_number  		= $emergency['phonenumber'];
					$Employee_emergency->email  			= $emergency['email'];
					$Employee_emergency->save();
				}			
			}

			Session::flash('Success','<div class="alert alert-success">Relation successfully Added</div>');
			return redirect('/franchise/employee/view/'.$employee_id);

		}
        $data['Employee'] = $Employee;
        return view('franchise.employees.relationship.addRelation',$data);
	}

	//////////////////
	// DELETE contact
	//////////////////
	public function deletecontact($employee_id, $contact_id){

		$Employee = Femployee::find($employee_id);
        if(!$Employee){
			return redirect('franchise/employees');
		}
		
		if(Auth::guard('franchise')->user()->franchise_id != $Employee->franchise_id){ return redirect('franchise/employees'); }
		
		$F_owner = Femployees_emergency_contacts::where('admin_employee_id',$employee_id)->where('id',$contact_id);
		if(!$F_owner) return redirect('franchise/employees');
		$F_owner->delete();
		
		Session::flash('Success','<div class="alert alert-success">Emergency Contact deleted successfully.</div>');
		return redirect('franchise/employee/view/'.$employee_id);
		
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

		$Employee = Femployee::find($employee_id);
		if(!$Employee) return redirect('franchise/employees');
		if(Auth::guard('franchise')->user()->franchise_id != $Employee->franchise_id){ return redirect('franchise/employees'); }
				
		if($request->isMethod('post')){

			$Employee = Femployee::find($employee_id);
			$Employee->career_desired_pay 				   = $request->desired_pay;
			$Employee->career_starting_pay 				  = $request->starting_pay;
			$Employee->career_current_pay 				   = $request->current_pay;
			$Employee->career_insurance_plan 				= $request->insurance_plan;
			$Employee->career_retirement_plan 			   = $request->retirement_plan;
			$Employee->career_paid_vacation 				 = $request->paid_vacation;
			$Employee->career_paid_holiday 				  = $request->paid_holidays;
			$Employee->career_allowed_sick_leaves 		   = $request->sick_leaves;
			$Employee->save();

			Session::flash('Success','<div class="alert alert-success">Employee Benifits successfully Updated</div>');
			return redirect('/franchise/employee/view/'.$employee_id);

		}
        $data['Employee'] = $Employee;
        return view('franchise.employees.benifit.editBenifit',$data);
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
        
        $Employee = Femployee::find($employee_id);
        
        if(!$Employee){
			return redirect('franchise/employees');
		}
		
		if(Auth::guard('franchise')->user()->franchise_id != $Employee->franchise_id){ return redirect('franchise/employees'); }
		
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

			$tasks = Femployees_tasklist::where('employee_id', $employee_id)->orderby('sort','asc')->get();
			if(!$tasks->isEmpty()){
				$sort = 1;
				foreach($tasks as $getTask){
					$U_task = Femployees_tasklist::find($getTask->id);
					$U_task->sort = $sort;
					$U_task->save();
					$sort++;
				}
			}
			
			if(!empty($request->task)){
				foreach($request->task as $task){
					if($task == '') continue;

					$eTask = new Femployees_tasklist();
					$eTask->task = $task;
					$eTask->employee_id = $employee_id;
					$eTask->status = 'Incomplete';
					$eTask->save();

				}
			}
			
			Session::flash('Success','<div class="alert alert-success">Task added successfully.</div>');
			return redirect('franchise/employee/viewtasklist/'.$employee_id);
		}
		
        $data['Employee'] = $Employee;

		return view('franchise.employees.tasklist.addTask',$data);
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

        if(!$employee_id) return redirect('franchise/employees');
        
        $Employee = Femployee::find($employee_id);
        
        if(!$Employee){
			return redirect('franchise/employees');
		}
		
		if(Auth::guard('franchise')->user()->franchise_id != $Employee->franchise_id){ return redirect('franchise/employees'); }
		
		$data['Employee'] = $Employee;
		
		return view('franchise.employees.tasklist.viewTasklist',$data);
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
        
        $Employee = Femployee::find($employee_id);
        
        if(!$Employee){
			return redirect('franchise/employees');
		}
		
		if(Auth::guard('franchise')->user()->franchise_id != $Employee->franchise_id){ return redirect('franchise/employees'); }
		
		if($request->isMethod('post')){

			if(!empty($request->task)){
				foreach($request->task as $task){
					Femployees_tasklist::where('employee_id',$Employee->id)->where('id',$task['task_id'])
					->update(['sort' => $task['sort'], 'task' => $task['task_description'], 'status' => $task['status'] ]);
				}
			}
			
			Session::flash('Success','<div class="alert alert-success">Task list updated successfully.</div>');
			return redirect('franchise/employee/viewtasklist/'.$Employee->id);
		}
        $data['Employee'] = $Employee;

		return view('franchise.employees.tasklist.editTask',$data);
	}	

	/////////////////
	//	DELETE TASK
	/////////////////
	public function deletetask($employee_id, $task_id){

		$Employee = Femployee::find($employee_id);
        if(!$Employee){
			return redirect('franchise/employees');
		}
		
		if(Auth::guard('franchise')->user()->franchise_id != $Employee->franchise_id){ return redirect('franchise/employees'); }
		
		$E_task = Femployees_tasklist::where('employee_id',$employee_id)->where('id',$task_id);
		if(!$E_task) return redirect('franchise/employees');
		$E_task->delete();
		
		Session::flash('Success','<div class="alert alert-success">Task deleted successfully.</div>');
		return redirect('franchise/employee/edittasklist/'.$employee_id);
		
	}	
	
	
	///////////////////////////
	// Add Forgotin time punch
	///////////////////////////
	public function addTimepunch(Request $request, $employee_id){

        $Employee           = Femployee::find($employee_id);
        $employee_schedules = $Employee->employee_schedules;

		$days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
		$time1 = new DateTime($request->time_in);
		$time2 = new DateTime($request->time_out);
		$dteDiff = $time1->diff($time2);
		$hours = $dteDiff->format("%h.%I");
		
		$fullNameday = date('w',strtotime($request->date));

        if($employee_schedules){
	        $schedule_time1          = strtotime( $employee_schedules->{strtolower($days[$fullNameday]) . '_time_in'} );
	        $schedule_time2          = strtotime( $employee_schedules->{strtolower($days[$fullNameday]) . '_time_out'} );
	        $schedule_difference     = round(abs($schedule_time2 - $schedule_time1) / 3600,2);
	        $schedule_total_hours    = ($schedule_difference) ? $schedule_difference : 0;
	        $extra_hours             = $hours - $schedule_total_hours;
		}
		
		$time = new Femployees_time_punch();
		$time->date					= date('Y-m-d',strtotime($request->date));
		$time->admin_employee_id	= $employee_id;
		$time->day					= $days[$fullNameday];
		$time->time_in				= date('H:i',strtotime($request->time_in));
		$time->time_out				= date('H:i',strtotime($request->time_out));
		$time->total_hrs			= $hours;

		if($employee_schedules){
			if($extra_hours > 0) $time->overtime_hrs = $extra_hours;
		}
		

		$time->save();
		
		Session::flash('Success','<div class="alert alert-success">Time Punch Added.</div>');
		return redirect('franchise/employee/viewtimepunches/'.$employee_id);
		
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

        if(!$employee_id) return redirect('franchise/employees');
        
        $Employee = Femployee::find($employee_id);
        
        if(!$Employee){
			return redirect('franchise/employees');
		}
		if(Auth::guard('franchise')->user()->franchise_id != $Employee->franchise_id){ return redirect('franchise/employees'); }

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
		//$week = $request->week; //It comes from filter search
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
			$date = date('Y').'-'.$month.'-01';
			for($i = 1; $i <= $week;  ){

				//$MondayDayCount = date("w", mktime(0, 0, 0, $request->month, $count, date('Y')));
				$MondayDayCount = date("w", mktime(0, 0, 0, $month, $count, date('Y')));
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
			
			$weeks_in_month = $this->weeks_in_month($month, $current_year);
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
        if($request->month)
        {
            $Employee_timepunches = Femployees_time_punch::where('admin_employee_id',$employee_id)
                ->when($dates, function ($query, $dates) {
                    return $query->whereBetween('date', [$dates['startdate'], $dates['enddate']]);
                })->get();
        }

        $days = array( "monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday");

        $employee_schedules_data    = array();
        $employee_schedules         = $Employee->employee_schedules;
        $complete_hours             = 0;

        foreach($days as $day)
        {

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
		
		return view('franchise.employees.timepunches.viewTimepunches',$data);		
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

        $Employee = Femployee::find($employee_id);
        
        if(!$Employee){
			return redirect('franchise/employees');
		}
		if(Auth::guard('franchise')->user()->franchise_id != $Employee->franchise_id){ return redirect('franchise/employees'); }

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

			$addPerform = new Femployees_performance_log();
			$addPerform->date 			= date('Y-m-d',strtotime($request->date));
			$addPerform->event 			= $request->event;
			$addPerform->comment 		= $request->comment;
			$addPerform->description 	= $request->description;
			$addPerform->admin_employee_id 	= $employee_id;
			$addPerform->save();
			
			Session::flash('Success','<div class="alert alert-success">Performance Log added successfully.</div>');
			return redirect('franchise/employee/viewperformancelog/'.$Employee->id);
		}
        $data['Employee'] = $Employee;
        		
		return view('franchise.employees.performance.addPerformance',$data);
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

        if(!$employee_id) return redirect('franchise/employees');
        
        $Employee = Femployee::find($employee_id);
        
        if(!$Employee){
			return redirect('franchise/employees');
		}
		
		if(Auth::guard('franchise')->user()->franchise_id != $Employee->franchise_id){ return redirect('franchise/employees'); }

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

		$Employee_performance = Femployees_performance_log::where('admin_employee_id',$employee_id)
		->when($request->month, function ($query, $month) {
                return $query->whereMonth('date', $month);
        })->when($request->event, function ($query, $event) {
                return $query->where('event', $event);
        })->orderby('date','desc')->get();
        
        $data['PerformanceLogEvents'] = $PerformanceLogEvents;
		$data['Employee'] = $Employee;
		$data['Employee_performance']   = $Employee_performance;
		
		return view('franchise.employees.performance.viewPerformancelog',$data);
	}
	
	//////////////////////
	//PERFORMANCE UPDATE
	//////////////////////
	public function performanceupdate(Request $request, $employee_id){
		$emp = Femployee::find($employee_id);
		$perform = Femployees_performance_log::where('admin_employee_id',$employee_id);
		if(Auth::guard('franchise')->user()->franchise_id != $emp->franchise_id){ return redirect('franchise/employees'); }
		$perform->delete();
		
		if(!empty($request->performance)){
			foreach($request['performance'] as $performance){
				$addPerform = new Femployees_performance_log();
				$addPerform->date 				= date('Y-m-d',strtotime( $performance['date'] ));
				$addPerform->event 				= $performance['event'];
				$addPerform->comment 			= $performance['comment'];
				$addPerform->description 		= $performance['description'];
				$addPerform->admin_employee_id 	= $employee_id;
				$addPerform->save();				
			}
		}
		
		Session::flash('Success','<div class="alert alert-success">Performance Log updated successfully..</div>');
		return redirect('franchise/employee/viewperformancelog/'.$employee_id);		

	}
	
	//////////////////////
	//PERFORMANCE DELETE
	//////////////////////
	public function performanceDelete($employee_id, $performanceID){
		if(Auth::guard('franchise')->check()){
			$emp = Femployee::find($employee_id);
			if(!$emp){ echo "employee not found";exit;}
			
			if(Auth::guard('franchise')->user()->franchise_id != $emp->franchise_id){ return redirect('franchise/employees'); }
			
			$performance = Femployees_performance_log::where(array('id'=>$performanceID, 'admin_employee_id'=> $employee_id))->first();
			if($performance){
				Femployees_performance_log::find($performance->id)->delete();
			}else{
				echo "No log found.";
			}
			
			Session::flash('Success','<div class="alert alert-success">Performance successfully deleted</div>');
			return redirect('/franchise/employee/viewperformancelog/'.$employee_id.'?performance_log=edit');
		}else{
			echo "Only Franchise can delete this log.";
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

        if(!$employee_id) return redirect('franchise/employees');
        
        $Employee = Femployee::find($employee_id);
        
        if(!$Employee){ return redirect('franchise/employees'); }
        if(Auth::guard('franchise')->user()->franchise_id != $Employee->franchise_id){ return redirect('franchise/employees'); }

       $days = array( "monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday");

        $employee_schedules_data    = array();
        $employee_schedules         = $Employee->employee_schedules;
        $complete_hours             = 0;

        foreach($days as $day)
        {

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
        
		$data['Employee'] = $Employee;
        $data['Employee_schedule']      = $employee_schedules_data;
        $data['Employee_schedule_hours']= $complete_hours;
		
		return view('franchise.employees.tripitinerary.viewTripitinerary',$data);
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
		
        $tripitenary = Femployees_schedules::findOrNew($id);
		if(!$tripitenary->exists)$tripitenary->admin_employee_id = $request->admin_employee_id;
		
        foreach($days as $day)
        {
            if( $request->{$day.'_time_in'})  $tripitenary->{$day.'_time_in'} = date("H:i:s",strtotime( $request->{$day.'_time_in'}));
            else $tripitenary->{$day.'_time_in'} = NULL;

            if( $request->{$day.'_time_out'})  $tripitenary->{$day.'_time_out'} = date("H:i:s",strtotime( $request->{$day.'_time_out'}));
            else $tripitenary->{$day.'_time_out'} = NULL;
        }
        $tripitenary->save();

        Session::flash('Success','<div class="alert alert-success">Trip Itenary updated successfully.</div>');
        return redirect('franchise/employee/viewtripitinerary/'.$request->admin_employee_id);

    }
	
	////////////////////
	// Edit Certification
	////////////////////
	public function editCertification(Request $request, $employee_id, $certification_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Certification";
        $sub_title                      = "Edit Certification";
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

		$data['Employee'] = Femployee::find($employee_id);
		if(!$data['Employee']) return redirect('franchise/employees');
		
		$e_certification = Femployees_certifications::where('admin_employee_id' , $employee_id)->where('id',$certification_id)->first();
		if(!$e_certification) return redirect('franchise/employee/view/'.$employee_id);
		
		$data['certification'] = $e_certification;
		
		if($request->isMethod('post')){

			$e_certification = Femployees_certifications::find($certification_id);
			$e_certification->certification_name 	= $request->certification_name;
			$e_certification->expiration_date 	   = date('Y-m-d',strtotime($request->expiration_date));
			//$e_certification->phone_number 	      = $request->phonenumber;
			//$e_certification->email 		         = $request->email;
			$e_certification->save();

			Session::flash('Success','<div class="alert alert-success">Certification successfully updated</div>');
			return redirect('/franchise/employee/view/'.$employee_id);

		}
        
        return view('franchise.employees.certifications.editCertification',$data);
	}	

	////////////////////
	// Add Certification
	////////////////////
	public function addCertification(Request $request, $employee_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Certification";
        $sub_title                      = "Edit Certification";
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

		$Employee = Femployee::find($employee_id);
		if(!$Employee) return redirect('franchise/employees');
				
		if($request->isMethod('post')){

			if(!empty($request->certification)){
				foreach($request->certification as $certification){
					$Employee_certification = new Femployees_certifications();
					$Employee_certification->admin_employee_id  = $Employee->id;
					$Employee_certification->certification_name  	   = $certification['certification_name'];
					$Employee_certification->expiration_date  	= date('Y-m-d',strtotime($certification['expiration_date']));
					//$Employee_certification->phone_number  	   = $certification['phonenumber'];
					//$Employee_certification->email  			  = $certification['email'];
					$Employee_certification->save();
				}			
			}

			Session::flash('Success','<div class="alert alert-success">Certification successfully Added</div>');
			return redirect('/franchise/employee/view/'.$employee_id);

		}
        $data['Employee'] = $Employee;
        return view('franchise.employees.certifications.addCertification',$data);
	}
	
	//////////////////
	// DELETE Certification
	//////////////////
	public function deleteCertification($employee_id, $certification_id){

		$Employee = Femployee::find($employee_id);
        if(!$Employee){
			return redirect('franchise/employees');
		}
		
		$F_owner = Femployees_certifications::where('admin_employee_id',$employee_id)->where('id',$certification_id);
		if(!$F_owner) return redirect('franchise/employees');
		$F_owner->delete();
		
		Session::flash('Success','<div class="alert alert-success">Certification deleted successfully.</div>');
		return redirect('franchise/employee/view/'.$employee_id);
		
	}	
	
	////////////////////
	// Edit Credential
	////////////////////
	public function editCredential(Request $request, $employee_id, $credential_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Credential";
        $sub_title                      = "Edit Credential";
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

		$data['Employee'] = Femployee::find($employee_id);
		if(!$data['Employee']) return redirect('franchise/employees');
		
		$e_credential = Femployees_login_credentials::where('admin_employee_id' , $employee_id)->where('id',$credential_id)->first();
		if(!$e_credential) return redirect('franchise/employee/view/'.$employee_id);
		
		$data['credential'] = $e_credential;
		
		if($request->isMethod('post')){

			$e_credential = Femployees_login_credentials::find($credential_id);
			$e_credential->app_name  = $request->app_name;
			$e_credential->url 	   = $request->url;
			$e_credential->username  = $request->username;
			//$e_credential->password  = bcrypt($request->password);
			$e_credential->password  = ($request->password);
			$e_credential->save();

			Session::flash('Success','<div class="alert alert-success">Credential successfully updated</div>');
			return redirect('/franchise/employee/view/'.$employee_id);

		}
        
        return view('franchise.employees.logincredentials.editCredential',$data);
	}	

	////////////////////
	// Add Credential
	////////////////////
	public function addCredential(Request $request, $employee_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Credential";
        $sub_title                      = "Edit Credential";
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

		$Employee = Femployee::find($employee_id);
		if(!$Employee) return redirect('franchise/employees');
				
		if($request->isMethod('post')){

			if(!empty($request->credential)){
				foreach($request->credential as $credential){
					$Employee_credential = new Femployees_login_credentials();
					$Employee_credential->admin_employee_id  = $Employee->id;
					$Employee_credential->app_name  	   = $credential['app_name'];
					$Employee_credential->url  			= $credential['url'];
					$Employee_credential->username  	   = $credential['username'];
					//$Employee_credential->password  	   = bcrypt($credential['password']);
					$Employee_credential->password  	   = ($credential['password']);
					$Employee_credential->save();
				}			
			}

			Session::flash('Success','<div class="alert alert-success">Credential successfully Added</div>');
			return redirect('/franchise/employee/view/'.$employee_id);

		}
        $data['Employee'] = $Employee;
        return view('franchise.employees.logincredentials.addCredential',$data);
	}
	
	//////////////////
	// DELETE Credential
	//////////////////
	public function deleteCredential($employee_id, $credential_id){

		$Employee = Femployee::find($employee_id);
        if(!$Employee){
			return redirect('franchise/employees');
		}
		if(Auth::guard('franchise')->user()->franchise_id != $Employee->franchise_id){ return redirect('franchise/employees'); }
		$F_owner = Femployees_login_credentials::where('admin_employee_id',$employee_id)->where('id',$credential_id);
		if(!$F_owner) return redirect('franchise/employees');
		$F_owner->delete();
		
		Session::flash('Success','<div class="alert alert-success">Credential deleted successfully.</div>');
		return redirect('franchise/employee/view/'.$employee_id);
		
	}	
	
	public function printReport(Request $request, $employee_id){

		$Employee = Femployee::find($employee_id);
        if(!$Employee){
			return redirect('franchise/employees');
		}
		
		if(Auth::guard('franchise')->user()->franchise_id != $Employee->franchise_id){ return redirect('franchise/employees'); }
				
		$starDate = date('Y-m-d',strtotime($request->startReport));
		$endDate = date('Y-m-d',strtotime($request->endReport));
		$report = Femployees_time_punch::whereBetween('date', [$starDate, $endDate])->where('admin_employee_id',$employee_id)->orderby('date','asc')->get();
		
		$data['report'] = $report;
		$data['employee_id'] = $employee_id;
		
		return view('franchise.employees.report',$data);
		
	}

	//////////////////////////////
	//Email exist for add employee
	//////////////////////////////

	public function EmailExist(Request $request){
		
		$messages = [
		    'email.required' => 'Email field is required.',
		];
		
		$validator = Validator::make($request->all(), [
		    'email' => 'email|unique:employment_form,'.$request->EmailField,
		], $messages);
		
		if ($validator->fails()) {
            return response()->json([ 'errors' => $validator->customMessages ]);
		}
		
		 return response()->json(['success' => 'Done']);
		 		
	}	
	
	public function EmailExistForInvite(Request $request){
		
		$messages = [
		    'email.required' => 'Email field is required.',
		];
		
		$validator = Validator::make($request->all(), [
		    'email' => 'email|unique:employment_form,'.$request->EmailField.','.$request->employee_id,
		], $messages);
		
		if ($validator->fails()) {
            return response()->json([ 'errors' => $validator->customMessages ]);
		}
		
		 return response()->json(['success' => 'Done']);
		 		
	}
}