<?php
namespace App\Http\Controllers\Franchise;

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
use App\Models\Franchise_payments;
use App\Models\Franchise\Femployee;
use App\Models\Franchise\Client;
use App\Models\Frontend\Admissionform;
use App\Models\Frontend\Employmentform;

class DashboardController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard('franchise')->user();
		$users[] = Auth::guard('franchise')->user();

		$this->middleware(function ($request, $next) {
		    $this->user = auth()->user();
			//If user type is not owner or manager then redirecting to dashboard
			if($this->user->type == 'BCBA' || $this->user->type == 'Intern'){
				return redirect('franchise/clients');
			}
			if($this->user->type == 'Receptionist'){
				return redirect('franchise/clients');
			}
			
		    return $next($request);
		});
	}

    public function index()
    {
        $page_title                     = "Main Deck";
        $sub_title                      = "Main Deck";
        $menu                           = "main_deck";
        $sub_menu                       = "";

        //$Active_Employees = Femployee::where('employee_status','Active')->count();
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		$Active_Employees 	= Employmentform::where(array('personal_status'=>'Active', 'franchise_id'=>$franchise_id))->count();
		$emp_vacation 		= Employmentform::where(array('personal_status'=>'Vacation', 'franchise_id'=>$franchise_id))->count();
		$Active_Clients 	= Admissionform::where(array('client_status'=>'Active', 'franchise_id'=>$franchise_id))->count();
		$applicant_Clients 	= Admissionform::where(array('client_status'=>'Applicant', 'franchise_id'=>$franchise_id))->count();
		$Total_Ocean_Clients 	= Admissionform::where(array('client_crew'=>'Ocean', 'franchise_id'=>$franchise_id))->count();
		$Total_Voyager_Clients 	= Admissionform::where(array('client_crew'=>'Voyager', 'franchise_id'=>$franchise_id))->count();
		$Total_Sailor_Clients 	= Admissionform::where(array('client_crew'=>'Sailor', 'franchise_id'=>$franchise_id))->count();
        
        //GET EMPLOYEES OF MONTH
        $currentYear = date('Y');
		$currentMonth = date('m');
        
        $employeeData = array();
        $employeeDataForNewGraph = array();
        
        $countmonth = 0;
		$number_of_days = cal_days_in_month(CAL_GREGORIAN,$currentMonth,$currentYear);
		for($startFrom = 1; $startFrom <=$number_of_days; $startFrom++){	
			$fromDate = date('Y-m-d H:i:s',strtotime($currentYear.'-'.$currentMonth.'-'.$startFrom.' 00:00:00'));

			$a_date = $currentYear.'-'.$currentMonth.'-'.$startFrom;
			$lastDayOfMonth = date("t", strtotime($a_date));
        	
			$toDate = date('Y-m-d H:i:s',strtotime($currentYear.'-'.$currentMonth.'-'.($startFrom).' 23:59:59'));
			$monthEmployees = Employmentform::where('franchise_id',$franchise_id)->where('personal_status','Active')->whereBetween('created_at',[$fromDate, $toDate])->count();
			
			$employeeData[] = array('x'=> date('Y-m-d',strtotime($fromDate)), 'y'=> $monthEmployees); 
			$employeeDataForNewGraph['employees'][] = $monthEmployees; 
			$employeeDataForNewGraph['days'][] = date('d',strtotime($fromDate)); 
		}
		
        //GET Clients OF MONTH
        $currentYear = date('Y');
		$currentMonth = date('m');
        $clientsData = array();
        $countmonth = 0;
		for($startFrom = 1; $startFrom <=$number_of_days; $startFrom++){		
			$fromDate = date('Y-m-d H:i:s',strtotime($currentYear.'-'.$currentMonth.'-'.$startFrom.' 00:00:00'));

			$a_date = $currentYear.'-'.$currentMonth.'-'.$startFrom;
			$lastDayOfMonth = date("t", strtotime($a_date));
        	
			$toDate = date('Y-m-d H:i:s',strtotime($currentYear.'-'.$currentMonth.'-'.($startFrom).' 23:59:59'));
			$monthClients = Admissionform::where('franchise_id',$franchise_id)->where('client_status','Active')->whereBetween('created_at',[$fromDate, $toDate])->count();
			
			$clientsData[] = array('x'=> date('Y-m-d',strtotime($fromDate)), 'y'=> $monthClients); 
			$employeeDataForNewGraph['clients'][] = $monthClients; 
		}

		//GETTING UPCOMMING PERFORMANCE 
		$currDate = date('Y-m-d');
		//Adding two weeks into current Date for check upcomming perforamance
		$upcommingDate = date('Y-m-d',strtotime($currDate."+14 days"));
		$upcomming_performance = Employmentform::where(array('personal_status'=>'active', 'franchise_id'=>$franchise_id))
		->whereBetween('upcomming_performance',[$currDate, $upcommingDate])
		->orderBy('upcomming_performance','asc')->paginate($this->pagelimit);
		
		//GETTING EXPIRED CLIENTS
		
		//GETTING FRANCHISE CLIENTS AND THEIR CREWS
		//$Clients 	= Client::where(array('client_status'=>'active', 'franchise_id'=>Auth::guard('franchise')->user()->franchise_id))->paginate(10);
		$Clients 	= Client::where(array('client_status'=>'active', 'franchise_id'=>Auth::guard('franchise')->user()->franchise_id));//echo "<pre>";print_r($Clients);

		$Clients = $Clients->join('parent_insurance_policy', function ($join) {
            $join->on('admission_form.id', '=', 'parent_insurance_policy.client_id')->where('parent_insurance_policy.client_insurance_primary', 1);
        })->leftJoin('parent_insurance_policy_authorizations', function ($join) {
			$join->on('parent_insurance_policy.id', '=', 'parent_insurance_policy_authorizations.client_insurance_id');
		})->paginate(10);

		$Employees = Femployee::where(array('personal_status'=>'active', 'franchise_id'=>Auth::guard('franchise')->user()->franchise_id))->paginate(10);
		
		//GETTING FRANCHISE PAYMENTS DETAILS
		$setMonths = array('January','February','March','April','May','June','July','August','September','October','November','December');
		$months=array();
		foreach ( $setMonths as $key => $val )
		{
		    $months[ $key+1 ] = $val;		
		}
		
		$monthly_royalty_fee = Franchise_payments::where(array('invoice_name'=>'Monthly Royalty Fee', 'franchise_id'=>Auth::guard('franchise')->user()->franchise_id))->where('month',$months[date('n')])->first();
		$monthly_system_advertising_fee = Franchise_payments::where(array('invoice_name'=>'Monthly System Advertising Fee', 'franchise_id'=>Auth::guard('franchise')->user()->franchise_id))->first();

        $active_employees               = $Active_Employees;
        $Franchise = Franchise::find(Auth::user()->franchise_id);
        
        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "active_employees"                      => $active_employees,
            "active_clients"                      	=> $Active_Clients,
            "applicant_Clients"                     => $applicant_Clients,
            "emp_vacation"                     		=> $emp_vacation,
            "upcomming_performance"                 => $upcomming_performance,
            //"expClients"                 			=> $expClients,
            "employees"							 	=> json_encode($employeeData),
            "clients"							   	=> json_encode($clientsData),
			"monthly_royalty_fee"			       	=> $monthly_royalty_fee,
			"monthly_system_advertising_fee"		=> $monthly_system_advertising_fee,
			"DashClients"						   	=> $Clients,
			"DashEmployees"						 	=> $Employees,
			"Franchise"								=> $Franchise,
			"Total_Ocean_Clients"					=> $Total_Ocean_Clients,
			"Total_Voyager_Clients"					=> $Total_Voyager_Clients,
			"Total_Sailor_Clients"   					 => $Total_Sailor_Clients,
			"GraphData"								=> json_encode($employeeDataForNewGraph)
        );

	    return view('franchise.home',$data);
    }
    
    
    public function LogoutImpersonate(REQUEST $request){
		Auth::guard('franchise')->logout();
		$request->session()->forget('impersonate');
		return redirect('/admin/dashboard');
	}
}