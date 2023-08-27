<?php
namespace App\Http\Controllers\Femployee;

use Session;
use Carbon\Carbon;
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
use App\Models\Franchise\Femployees_time_punch;
use App\Models\Franchise\Femployees_certifications;

class DashboardController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard('femployee')->user();
		$users[] = Auth::guard('admin')->user();
	}

    public function index(Request $request)
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

        $active_employees = $Active_Employees;
		
		$user_id = Auth::guard('femployee')->user()->id;
		$franchise_id = Auth::guard('femployee')->user()->franchise_id;
		$upcomming_performance = Auth::guard('femployee')->user()->upcomming_performance;
		$career_allowed_sick_leaves = Auth::guard('femployee')->user()->career_allowed_sick_leaves;
		$career_paid_vacation = Auth::guard('femployee')->user()->career_paid_vacation;
		$femployees_certifications = Femployees_certifications::where('expiration_date', '>=', date('Y-m-d'))->where('admin_employee_id', $user_id)->orderby('expiration_date','asc')->paginate(1);
		$notifications = Notifications::where("archive",0)->where(array('user_type'=>'Franchise Administration', 'send_to_employees'=>1,'franchise_id'=>$franchise_id))->orderBy("created_at","DESC")->get();
		
		$months = array(
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
		
		if($request->month){
			$selected_month = $request->month;
		}else{
			$selected_month = date('m');
		}
		
		$month = date('Y-'.$selected_month);
		$end = Carbon::parse($month)->endOfMonth()->format('d');
		$start = Carbon::parse($month)->startOfMonth()->format('d');
		$end_date = Carbon::parse($month)->endOfMonth()->format('Y-m-d');
		$start_date = Carbon::parse($month)->startOfMonth()->format('Y-m-d');
		//$femployees_time_punch = Femployees_time_punch::whereBetween('date',[$start_date, $end_date])->where('admin_employee_id', $user_id)->orderby('date','asc')->paginate(0);//echo "<pre>";print_r($femployees_time_punch);
		$hours_logs = [];
		for($day = $start; $day <=$end; $day++)
		{
			$day = ($day == '01')?1:$day;
			$hours_logs[$day]['x'] = $day;
			$femployee_time_punch_total_hrs = Femployees_time_punch::where('date',date('Y-'.$selected_month.'-'.$day))->where('admin_employee_id', $user_id)->value('total_hrs');
			$hours_logs[$day]['y'] = !empty($femployee_time_punch_total_hrs)?$femployee_time_punch_total_hrs:0;
		}
		
        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "active_employees"                      => $active_employees,
            "employees"							 => json_encode($employeeData),
			"upcomming_performance"				 => $upcomming_performance,
			"career_allowed_sick_leaves"			=> $career_allowed_sick_leaves,
			"career_paid_vacation"				  => $career_paid_vacation,
			"femployees_certification"			  => $femployees_certifications[0],
			"notifications"						 => $notifications,
			"months"						 	    => $months,
			"selected_month"						=> $selected_month,
			"hours_logs"						 	=> json_encode($hours_logs)
        );

	    return view('femployee.home',$data);
    }
}