<?php
namespace App\Http\Controllers\Femployee;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\Profile\UpdateProfile;

//Models
use App\Models\State;
use App\Models\Franchise;
use App\Models\Franchise\Femployee;
use App\Models\Franchise\Femployees_tasklist;
use App\Models\Franchise\Femployees_schedules;
use App\Models\Franchise\Femployees_certifications;
use App\Models\Franchise\Femployees_performance_log;
use App\Models\Franchise\Femployees_login_credentials;
use App\Models\Franchise\Femployees_emergency_contacts;
use App\Models\Franchise\Femployees_aba_experience_reference;

//Requests
use App\Http\Requests\Femployee\Employee\EditEmployeeRequest;

class FemployeeController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard('femployee')->user();
		$users[] = Auth::guard('admin')->user();
	}


    public function index()
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Employee";
        $sub_title                      = "Employee";
        $menu                           = "employee";
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

        $employee_id = Auth::guard('femployee')->user()->id;
		//If ID IS NULL THEN REDIRECT
        if(!$employee_id) return redirect('femployee/login');
		
		$Employee = Femployee::find($employee_id);
        
        if(!$Employee){
			return redirect('femployee/dashboard');
		}

        $data['Employee'] = $Employee;
		return view('femployee.employee.view',$data);
    }
	
	///////////////////
	//	Edit Profile
	///////////////////	
	public function editProfile()
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Profile Edit";
        $sub_title                      = "Profile Edit";
        $menu                           = "profile";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
		
		$employee_id = Auth::guard('femployee')->user()->id;
		//If ID IS NULL THEN REDIRECT
        if(!$employee_id) return redirect('femployee/login');

        $femployee = Femployee::find($employee_id);

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "femployee"                             => $femployee,
        );

        return view('femployee.profile.edit',$data);
    }
	
	///////////////////
	//	Store Profile
	///////////////////	
	public function storeProfile(Request $request)
    {
        $femployee = Femployee::find($request->id);
        $femployee->personal_name   = $request->personal_name;
        $femployee->personal_email  = $request->personal_email;
        if($request->password != "") $femployee->password = bcrypt($request->password);

        if($request->profile_picture)
        {
            $file_storage   = 'public/femployee/'.Auth::guard('femployee')->user()->id;

            $exists = Storage::exists($femployee->personal_picture);

            if($exists)
            {
                Storage::delete($femployee->personal_picture);
            }

            $put_data               = Storage::put($file_storage, $request->profile_picture);
            $full_path              = Storage::url($put_data);
            $femployee->personal_picture  = $full_path;

            //To Rename the File uncomment below code.
            //Storage::rename($put_data,$file_storage.'/img.png');
        }

        $femployee->save();

        Session::flash('Success','<div class="alert alert-success">Profile updated successfully!</div>');
        //return redirect(route('femployee.home'));
		return redirect('femployee/edit_profile');
    }
	
	///////////////////
	//	Edit Employee
	///////////////////	
	public function edit(EditEmployeeRequest $request){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Employee";
        $sub_title                      = "Edit Employee";
        $menu                           = "employee";
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
		$employee_id = Auth::guard('femployee')->user()->id;
		
		if($request->isMethod('post')){
			//exit;
			$employee = Femployee::find($employee_id);
			$employee->personal_status 						= ($request->status == 1) ? 1 : 0;
			$employee->personal_name 						= $request->employee_fullname;
			$employee->personal_dob 						= date('Y-m-d',strtotime($request->employee_dob));
			$employee->personal_address 					= $request->employee_address;
			$employee->personal_city 						= $request->employee_city;
			$employee->personal_state 						= $request->employee_state;
			$employee->personal_zipcode 					= $request->employee_zipcode;
			$employee->personal_ss 							= $request->employee_ss;
			$employee->personal_email 						= $request->employee_email;
			$employee->personal_phone 						= $request->employee_phone;
			$employee->work_authorised	 				    = $request->work_authorised;
			$employee->work_capable	 				        = $request->work_capable;
			$employee->work_nocapable	 				    = $request->work_nocapable;
			$employee->work_liftlbs	 				        = $request->work_liftlbs;
			$employee->career_desired_schedule	 		    = $request->employee_type;
			$employee->career_desired_position	 			= isset($request->desired_title) && !empty($request->desired_title) ? implode(',',$request->desired_title) : '';
			$employee->assigned_position	 				= $request->employee_title;
			$employee->career_earliest_startdate	 		= date('Y-m-d',strtotime($request->hiring_date));
			if($request->completion_date) 					
			$employee->career_probation_completion_date     = date('Y-m-d',strtotime($request->completion_date));
			$employee->career_highest_degree 	 		    = $request->highest_degree_held;
			$employee->career_desired_location	 		    = $request->career_desired_location;
			$employee->career_bacb             	 		    = $request->career_bacb;
			$employee->career_cpr_certified        		    = $request->career_cpr_certified;
			
			$employee->save();

			Session::flash('Success','<div class="alert alert-success">Employee successfully updated</div>');
			return redirect('/femployee/view/');
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
		
		return view('femployee.employee.editEmployee',$data);
	}

	///////////////
	//INVITE EMAIL
	///////////////
	public function inviteEmployee(REQUEST $request){
		$franchise_id = Auth::guard('femployee')->user()->franchise_id;
		$employee_id = Auth::guard('femployee')->user()->id;
		$Employee = Femployee::find($employee_id);
		if($Employee->franchise_id != $franchise_id){
			echo "You can't access another franchise of Employee";exit;
		}
		
		$Employee->email 	= $request->login_email;
		$Employee->password = bcrypt($request->emp_password);
		$Employee->save();
		
        $data = array( "name" => $Employee->personal_name, "email" => $Employee->email, "password" => $request->emp_password);
        \Mail::send('email.invite_email', ["name" => $data['name'], "email" => $data['email'], "password" => $data['password']], function ($message) use ($data) {
            $message->from('sos@testing.com', 'SOS');
            $message->to($data['email'])->subject("INVITATION OF SOS");
        });
        
		Session::flash('Success','<div class="alert alert-success">Invitation successfully sent to Employee.</div>');
		return redirect('/femployee/edit');
		
	}

	////////////////////
	// Add Relation
	////////////////////
	public function addRelation(Request $request){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Relation";
        $sub_title                      = "Edit Relation";
        $menu                           = "employee";
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
		$employee_id = Auth::guard('femployee')->user()->id;
		$Employee = Femployee::find($employee_id);
		if(!$Employee) return redirect('femployee/dashbaord');
				
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
			return redirect('/femployee/view');

		}
        $data['Employee'] = $Employee;
        return view('femployee.employee.relationship.addRelation',$data);
	}

	////////////////////
	// Edit Relation
	////////////////////
	public function editRelation(Request $request, $relation_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Relation";
        $sub_title                      = "Edit Relation";
        $menu                           = "employee";
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
		$employee_id = Auth::guard('femployee')->user()->id;
		$data['Employee'] = Femployee::find($employee_id);
		if(!$data['Employee']) return redirect('femployee/dashbaord');
		
		$e_contact = Femployees_emergency_contacts::where('admin_employee_id' , $employee_id)->where('id',$relation_id)->first();
		if(!$e_contact) return redirect('femployee/view');
		
		$data['emergency_contact'] = $e_contact;
		
		if($request->isMethod('post')){

			$e_raltion = Femployees_emergency_contacts::find($relation_id);
			$e_raltion->relationship 	= $request->relationship_type;
			$e_raltion->fullname 		= $request->fullname;
			$e_raltion->phone_number 	= $request->phonenumber;
			$e_raltion->email 			= $request->email;
			$e_raltion->save();

			Session::flash('Success','<div class="alert alert-success">Relation successfully updated</div>');
			return redirect('/femployee/view');

		}
        
        return view('femployee.employee.relationship.editRelation',$data);
	}	

	//////////////////
	// DELETE contact
	//////////////////
	public function deletecontact($contact_id){

		$employee_id = Auth::guard('femployee')->user()->id;
		$Employee = Femployee::find($employee_id);
        if(!$Employee){
			return redirect('femployee/dashbaord');
		}
		
		$F_owner = Femployees_emergency_contacts::where('admin_employee_id',$employee_id)->where('id',$contact_id);
		if(!$F_owner) return redirect('femployee/dashbaord');
		$F_owner->delete();
		
		Session::flash('Success','<div class="alert alert-success">Emergency Contact deleted successfully.</div>');
		return redirect('femployee/view');
		
	}		
	
	////////////////////
	// Edit Benifits
	////////////////////
	public function editBenifits(Request $request){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Benifits";
        $sub_title                      = "Edit Benifits";
        $menu                           = "employee";
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

		$employee_id = Auth::guard('femployee')->user()->id;
		$Employee = Femployee::find($employee_id);
		if(!$Employee) return redirect('femployee/dashbaord');
				
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
			return redirect('/femployee/view');

		}
        $data['Employee'] = $Employee;
        return view('femployee.employee.benifit.editBenifit',$data);
	}
	
	////////////////////
	// Edit Certification
	////////////////////
	public function editCertification(Request $request, $certification_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Certification";
        $sub_title                      = "Edit Certification";
        $menu                           = "employee";
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
		
		$employee_id = Auth::guard('femployee')->user()->id;
		$data['Employee'] = Femployee::find($employee_id);
		if(!$data['Employee']) return redirect('femployee/dashbaord');
		
		$e_certification = Femployees_certifications::where('admin_employee_id' , $employee_id)->where('id',$certification_id)->first();
		if(!$e_certification) return redirect('femployee/view');
		
		$data['certification'] = $e_certification;
		
		if($request->isMethod('post')){

			$e_certification = Femployees_certifications::find($certification_id);
			$e_certification->certification_name 	= $request->certification_name;
			$e_certification->expiration_date 	   = date('Y-m-d',strtotime($request->expiration_date));
			$e_certification->save();

			Session::flash('Success','<div class="alert alert-success">Certification successfully updated</div>');
			return redirect('/femployee/view');

		}
        
        return view('femployee.employee.certifications.editCertification',$data);
	}	

	////////////////////
	// Add Certification
	////////////////////
	public function addCertification(Request $request){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Certification";
        $sub_title                      = "Edit Certification";
        $menu                           = "employee";
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
		
		$employee_id = Auth::guard('femployee')->user()->id;
		$Employee = Femployee::find($employee_id);
		if(!$Employee) return redirect('femployee/dashbaord');
				
		if($request->isMethod('post')){

			if(!empty($request->certification)){
				foreach($request->certification as $certification){
					$Employee_certification = new Femployees_certifications();
					$Employee_certification->admin_employee_id  = $Employee->id;
					$Employee_certification->certification_name  	   = $certification['certification_name'];
					$Employee_certification->expiration_date  	= date('Y-m-d',strtotime($certification['expiration_date']));
					$Employee_certification->save();
				}			
			}

			Session::flash('Success','<div class="alert alert-success">Certification successfully Added</div>');
			return redirect('/femployee/view');

		}
        $data['Employee'] = $Employee;
        return view('femployee.employee.certifications.addCertification',$data);
	}
	
	//////////////////
	// DELETE Certification
	//////////////////
	public function deleteCertification($certification_id){

		$employee_id = Auth::guard('femployee')->user()->id;
		$Employee = Femployee::find($employee_id);
        if(!$Employee){
			return redirect('femployee/dashbaord');
		}
		
		$F_owner = Femployees_certifications::where('admin_employee_id',$employee_id)->where('id',$certification_id);
		if(!$F_owner) return redirect('femployee/dashbaord');
		$F_owner->delete();
		
		Session::flash('Success','<div class="alert alert-success">Certification deleted successfully.</div>');
		return redirect('femployee/view');
		
	}	
	
	////////////////////
	// Edit Credential
	////////////////////
	public function editCredential(Request $request, $credential_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Credential";
        $sub_title                      = "Edit Credential";
        $menu                           = "employee";
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

		$employee_id = Auth::guard('femployee')->user()->id;
		$data['Employee'] = Femployee::find($employee_id);
		if(!$data['Employee']) return redirect('femployee/dashbaord');
		
		$e_credential = Femployees_login_credentials::where('admin_employee_id' , $employee_id)->where('id',$credential_id)->first();
		if(!$e_credential) return redirect('femployee/view');
		
		$data['credential'] = $e_credential;
		
		if($request->isMethod('post')){

			$e_credential = Femployees_login_credentials::find($credential_id);
			$e_credential->app_name  = $request->app_name;
			$e_credential->url 	   = $request->url;
			$e_credential->username  = $request->username;
			$e_credential->password  = ($request->password);
			$e_credential->save();

			Session::flash('Success','<div class="alert alert-success">Credential successfully updated</div>');
			return redirect('/femployee/view');

		}
        
        return view('femployee.employee.logincredentials.editCredential',$data);
	}	

	////////////////////
	// Add Credential
	////////////////////
	public function addCredential(Request $request){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Credential";
        $sub_title                      = "Edit Credential";
        $menu                           = "employee";
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
		
		$employee_id = Auth::guard('femployee')->user()->id;
		$Employee = Femployee::find($employee_id);
		if(!$Employee) return redirect('femployee/dashbaord');
				
		if($request->isMethod('post')){

			if(!empty($request->credential)){
				foreach($request->credential as $credential){
					$Employee_credential = new Femployees_login_credentials();
					$Employee_credential->admin_employee_id  = $Employee->id;
					$Employee_credential->app_name  	   = $credential['app_name'];
					$Employee_credential->url  			= $credential['url'];
					$Employee_credential->username  	   = $credential['username'];
					$Employee_credential->password  	   = ($credential['password']);
					$Employee_credential->save();
				}			
			}

			Session::flash('Success','<div class="alert alert-success">Credential successfully Added</div>');
			return redirect('/femployee/view');

		}
        $data['Employee'] = $Employee;
        return view('femployee.employee.logincredentials.addCredential',$data);
	}
	
	//////////////////
	// DELETE Credential
	//////////////////
	public function deleteCredential($credential_id){

		$employee_id = Auth::guard('femployee')->user()->id;
		$Employee = Femployee::find($employee_id);
        if(!$Employee){
			return redirect('femployee/dashbaord');
		}
		
		$F_owner = Femployees_login_credentials::where('admin_employee_id',$employee_id)->where('id',$credential_id);
		if(!$F_owner) return redirect('femployee/dashbaord');
		$F_owner->delete();
		
		Session::flash('Success','<div class="alert alert-success">Credential deleted successfully.</div>');
		return redirect('femployee/view');
		
	}	
	
	/////////////////
	// VIEW TASKLIST
	////////////////
	public function viewTasklist(){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Employee Tasklist";
        $sub_title                      = "Employee Tasklist";
        $menu                           = "employee";
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

        $employee_id = Auth::guard('femployee')->user()->id;
		if(!$employee_id) return redirect('femployee/dashbaord');
        
        $Employee = Femployee::find($employee_id);
        
        if(!$Employee){
			return redirect('femployee/dashbaord');
		}
		$data['Employee'] = $Employee;
		
		return view('femployee.employee.tasklist.viewTasklist',$data);
	}
	
	//////////////////////
	//PERFORMANCE LOG
	//////////////////////
	public function performancelog(Request $request){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Employee Performance";
        $sub_title                      = "Employee Performance";
        $menu                           = "performance";
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
		
		$employee_id = Auth::guard('femployee')->user()->id;
        if(!$employee_id) return redirect('femployee/dashbaord');
        
        $Employee = Femployee::find($employee_id);
        
        if(!$Employee){
			return redirect('femployee/dashbaord');
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

		$Employee_performance = Femployees_performance_log::where('admin_employee_id',$employee_id)
		->when($request->month, function ($query, $month) {
                return $query->whereMonth('date', $month);
        })->when($request->event, function ($query, $event) {
                return $query->where('event', $event);
        })->orderby('date','desc')->get();
        
        $data['PerformanceLogEvents'] = $PerformanceLogEvents;
		$data['Employee'] = $Employee;
		$data['Employee_performance']   = $Employee_performance;
		
		return view('femployee.employee.performance.listPerformancelog',$data);
	}
	
	public function EmailExist(Request $request){
		
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