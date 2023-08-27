<?php
namespace App\Http\Controllers\Parent;

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
use App\Models\Notifications;
use App\Models\Franchise\Femployee;
use App\Models\Franchise\Femployees_certifications;

class DashboardController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard('parent')->user();
		$users[] = Auth::guard('parent')->user();
	}

    public function index()
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Main Deck";
        $sub_title                      = "Main Deck";
        $menu                           = "main_deck";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        //$Active_Employees = Femployee::where('employee_status','Active')->count();
		$Active_Employees = Femployee::where('personal_status','Active')->count();
        
        //Get Month Employee
        $currentYear = date('Y');
        $employeeData = array();
        $countmonth = 0;
        for($startFrom = 1; $startFrom <=12; $startFrom++){
        	$fromDate = date('Y-m-d H:i:s',strtotime($currentYear.'-'.$startFrom.'-01 00:00:00'));
        	$toDate = date('Y-m-d H:i:s',strtotime($currentYear.'-'.$startFrom.'-31 23:59:59'));
			$monthEmployees = Femployee::whereBetween('created_at',[$fromDate, $toDate])->count();
			
			$employeeData[] = array('x'=> date('Y-m-d',strtotime($fromDate)), 'y'=> $monthEmployees); 
		}

        //Get Month Employee
        $currentYear = date('Y');
        $employeeData = array();
        $countmonth = 0;
        for($startFrom = 1; $startFrom <=12; $startFrom++){
        	$fromDate = date('Y-m-d H:i:s',strtotime($currentYear.'-'.$startFrom.'-01 00:00:00'));
        	$toDate = date('Y-m-d H:i:s',strtotime($currentYear.'-'.$startFrom.'-31 23:59:59'));
			$monthEmployees = Femployee::whereBetween('created_at',[$fromDate, $toDate])->count();
			
			$employeeData[] = array('x'=> date('Y-m-d',strtotime($fromDate)), 'y'=> $monthEmployees); 
		}

        $active_employees           = $Active_Employees;
		
		$user_id 					= Auth::guard('parent')->user()->id;
		$franchise_id 				= Auth::guard('parent')->user()->franchise_id;
		$upcomming_performance 		= Auth::guard('parent')->user()->upcomming_performance;
		$career_allowed_sick_leaves = Auth::guard('parent')->user()->career_allowed_sick_leaves;
		$career_paid_vacation 		= Auth::guard('parent')->user()->career_paid_vacation;
		$femployees_certifications 	= Femployees_certifications::where('expiration_date', '<=', date('Y-m-d'))->where('admin_employee_id', $user_id)->orderby('expiration_date','asc')->paginate(1);
		$notifications 				= Notifications::where("archive",0)->where(array('user_type'=>'Franchise Administration', 'franchise_id'=>$franchise_id))->orderBy("created_at","DESC")->get();
		
        $data = array(
            "page_title"                    => $page_title,
            "sub_title"                     => $sub_title,
            "menu"                          => $menu,
            "sub_menu"                      => $sub_menu,
            "active_employees"              => $active_employees,
            "employees"						=> json_encode($employeeData),
			"upcomming_performance"			=> $upcomming_performance,
			"career_allowed_sick_leaves"	=> $career_allowed_sick_leaves,
			"career_paid_vacation"			=> $career_paid_vacation,
			"femployees_certification"		=> $femployees_certifications[0],
			"notifications"					=> $notifications
        );

	    return view('parent.home',$data);
    }
}