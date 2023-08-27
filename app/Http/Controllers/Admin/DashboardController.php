<?php
namespace App\Http\Controllers\Admin;

use Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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
use App\Models\Franchise\Fuser;
use App\Models\Franchise_payments;
use App\Models\Frontend\Admissionform;
use App\Models\Frontend\Employmentform;

class DashboardController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard()->user();
		$users[] = Auth::guard('admin')->user();
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

        //$getFranchises = Franchise::orderby('created_at','desc')->paginate(10);
		//GETTING UPCOMMING PERFORMANCE 
		$currDate = date('Y-m-d');
		//Adding two weeks into current Date for check upcomming perforamance
		$upcommingDate = date('Y-m-d',strtotime($currDate."+14 days"));
		$getFranchises = Franchise::whereBetween('fdd_expiration_date',[$currDate, $upcommingDate])->orderBy('created_at','asc')->paginate(10);
        $AllFranchises = Franchise::all();
        $Total_Franchises = Franchise::count();
        
        $stateCounts = array();
		$TotalStateCounts = 0;
        if(!$AllFranchises->isEmpty()){
	        foreach($AllFranchises as $Franchise){
				if(!array_key_exists($Franchise->state,$stateCounts)){
					$stateCounts[$Franchise->state] = 1;
				}else{
					$stateCounts[$Franchise->state] = $stateCounts[$Franchise->state] + 1;
				}
				if(!empty($Franchise->state))$TotalStateCounts++;
			}
		}
		
		//Getting max value of array and key of greater value
		
		$most_franchises_state = "-";
		if(!empty($stateCounts)){
			$state_id = array_search(max($stateCounts), $stateCounts);
			if(!empty($state_id))
			{
				$getState = State::find($state_id);
				$most_franchises_state = $getState->state_name;
			}
		}
		
		//$TotalStates = State::count();
		$TotalStates = $TotalStateCounts;
        
        $F_terminated = Franchise::where('status','Terminated')->count();
		$F_potential = Franchise::where('status','Potential')->count();
		$F_expired = Franchise::where('status','Expired')->count();
        $F_active = Franchise::where('status','Active')->count();
		$TotalStates = Franchise::distinct('state')->count('state');	
        $total_franchises_states        = $TotalStates;
        $total_franchises               = $Total_Franchises;
        $active_franchises              = $F_active;
        $terminated_franchises          = $F_terminated;
		$potential_franchises           = $F_potential;
		$expired_franchises             = $F_expired;
        
		$most_clients_monthly           = 0;
        $most_clients_franchise         = NULL;
        $most_employees_franchise       = 0;
        $most_employees_franchise_name  = NULL;
		$most_clients = Admissionform::where("client_status","!=","Applicant")->where(DB::raw(' MONTH(created_at) '), '=', date('m') )->orderBy('count', 'desc')->groupBy('franchise_id')->select('franchise_id', DB::raw('count(*) as count'))->paginate(1);
		if(!$most_clients->isEmpty())
		{
			$most_clients_monthly           = $most_clients[0]->count;
			$most_clients_franchise         = Franchise::find($most_clients[0]->franchise_id);
			$most_clients_franchise         = $most_clients_franchise->name;
		}
		
		/*$most_employees = Employmentform::where("personal_status","!=","Applicant")->where(DB::raw(' MONTH(created_at) '), '=', date('m') )->orderBy('count', 'desc')->groupBy('franchise_id')->select('franchise_id', DB::raw('count(*) as count'))->paginate(1);*/
		$most_employees = Employmentform::where("personal_status","!=","Applicant")->orderBy('count', 'desc')->groupBy('franchise_id')->select('franchise_id', DB::raw('count(*) as count'))->paginate(1);
		if(!$most_employees->isEmpty())
		{
			$most_employees_franchise       = $most_employees[0]->count;
			$most_employees_franchise_data  = Franchise::find($most_employees[0]->franchise_id);
			$most_employees_franchise_name  = $most_employees_franchise_data->name;
		}
		
        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "total_franchises_states"               => $total_franchises_states,
            "total_franchises"                      => $total_franchises,
            "active_franchises"                     => $active_franchises,
            "terminated_franchises"                 => $terminated_franchises,
			"potential_franchises"                  => $potential_franchises,
			"expired_franchises"                    => $expired_franchises,
            "most_franchises_state"                 => $most_franchises_state,
            "most_clients_monthly"                  => $most_clients_monthly,
            "most_clients_franchise"                => $most_clients_franchise,
            "most_employees_franchise"              => $most_employees_franchise,
            "most_employees_franchise_name"         => $most_employees_franchise_name,
            "upcoming_contract_expiration_title"    => "Upcoming Contract Expirations",
            "franchises"							=> $getFranchises
        );

	    return view('admin.home',$data);
    }
	
	public function testemail()
	{
		$data = array("name" => "Test User", "email" => "waseem.ansari@geeksroot.com", "messages" => "Test Message");
		\Mail::send('email.email_template', ["name" => "Test User", "email" => "waseem.ansari@geeksroot.com", "link"=>url('dashboard'), 'messages' =>  "Test Message"], function ($message) use ($data) {
			$message->from('sos@testing.com', 'SOS');
			$message->to($data['email'])->subject("Test Email");
		});
	}
    
}