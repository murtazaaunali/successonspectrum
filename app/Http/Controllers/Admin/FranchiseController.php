<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\Franchise\CreateFranchiseRequest;
use App\Http\Requests\Admin\Franchise\EditFranchiseRequest;
use App\Http\Requests\Admin\Franchise\EditFeeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

//Franchise Models
use App\Models\State;
use App\Models\Admin;
use App\Models\Cargohold;
use App\Models\Franchise;
use App\Models\Notifications;
use App\Models\Franchise_fees;
use App\Models\Franchise\Fuser;
use App\Models\Franchise_audit;
use App\Models\Franchise_owners;
use App\Models\Cargohold_folders;
use App\Models\Franchise_payments;
use App\Models\Franchise_tasklist;
use App\Models\Franchise_insurance;
use App\Models\Frontend\Admissionform;
use App\Models\Frontend\Employmentform;
use App\Models\Franchise_local_advertisements;

class FranchiseController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard()->user();
		$users[] = Auth::guard('admin')->user();
		//echo $this->testcron();
	}

    public function index(Request $request)
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Franchises List";
        $sub_title                      = "Franchisees"; 
        $menu                           = "franchise";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu
        );

		$getStates = State::get();
		$states = array();
		if(!$getStates->isEmpty()){
			foreach($getStates as $state){
				$states[] = $state;
			}
		}
		
		//////////////
		//  Filters
		//////////////
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
		$data['state'] = '';
		$data['franchise_name'] = '';
		$data['status'] = '';
		$data['month'] = '';
		$data['order'] = '';
		$data['sorting'] = '';

		$getFranchises = Franchise::when($request->get('state'), function ($query, $state) {
            return $query->where('state', $state);
        })
        ->when($request->franchise_name, function ($query, $name) {
        	return $query->where('location','LIKE',$name.'%');
        })
        ->when($request->status, function ($query, $status) {
        	return $query->where('status',$status);
        })
        ->when($request->month, function ($query, $month) {
        	return $query->whereMonth('fdd_expiration_date', $month);
        //})->orderby('created_at','desc')->paginate($this->pagelimit);
		});
		
		if(isset($request->sorting) && isset($request->order))
		{
			$order = $data['order'] = $request->order;
		    $sorting = $data['sorting'] = $request->sorting;
			$getFranchises = $getFranchises->orderby($sorting,$order);
		}
		else
		{
			//$getFranchises = $getFranchises->orderby('created_at','desc');
			$getFranchises = $getFranchises->orderby('state','asc');
		}
		
		$getFranchises = $getFranchises->paginate($this->pagelimit);
        
        $data['state'] = $request->state;
        $data['franchise_name'] = $request->franchise_name;
        $data['status'] = $request->status;
        $data['month'] = $request->month; 
		
		$data['state_registered'] = "";
		if($request->has('state'))
		{
			$getState = State::find($request->get('state'));
			$data['state_registered'] = $getState->registered;
		}
		//////////////
		//  Filters
		//////////////

		$data['franchises'] = array();
		if($getFranchises){
			foreach($getFranchises as $franchise){
				$data['franchises'][] = $franchise;
				
				/*Update column of incomplete_tasks*/
			    if($franchise->id)
				{
					$Franchise = Franchise::find($franchise->id);
					$Franchise->incomplete_tasks = $franchise->franchise_incomplete_tasklists()->count();
					if(strtotime($Franchise->upcoming_audit_date) < strtotime(date('Y-m-d')))
					{
						$fdd_signed_date_day = date('d',strtotime($Franchise->fdd_signed_date));
						$fdd_signed_date_month = date('m',strtotime($Franchise->fdd_signed_date));
						$Franchise->upcoming_audit_date = (date("Y")+1)."-".$fdd_signed_date_month."-".$fdd_signed_date_day;
					}
					if (!file_exists(storage_path().'/app/public/cargohold/'.$franchise->name)) 
					{
						mkdir(storage_path().'/app/public/cargohold/'.$franchise->name, 0777, true);
						$Cargohold_folders = new Cargohold_folders();
						$Cargohold_folders->name = $franchise->name;
						$Cargohold_folders->category = 'Completed Franchisee Forms';
						$Cargohold_folders->save();
					}

					$Franchise->save();
				}
			}
		}
		$data['franchises'] = $getFranchises;
		$data['states'] = $states;
		
	    return view('admin.franchises.list',$data);
    }
    
    public function form(){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Add Franchises";
        $sub_title                      = "Add Franchise";
        $menu                           = "franchise";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
		$getStates = State::get();
		$states = array();
		if(!$getStates->isEmpty()){
			foreach($getStates as $state){
				$states[] = $state;
			}
		}
        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "states"								=> $states
        );

	    return view('admin.franchises.form',$data);		
	}
	
	////////////////////
	// Add Franchise
	////////////////////
	public function add(CreateFranchiseRequest $request){

		/*$d1 = strtotime($request->contract_startdate);
		$d2 = strtotime($request->contract_enddate);*/
		$d1 = strtotime($request->fdd_signed_date);
		$d2 = strtotime($request->fdd_expiration_date);

		$diff = abs($d2 - $d1);  
		$years = floor($diff / (365*60*60*24));
		if($years > 1){
			$years = $years.' Years';
		}else{
			$years = '1 Year';
		}
				
		$franchise = new Franchise();
		//$franchise->name 						= $request->franchise_name;
		$franchise->name 						= $request->location;
		$franchise->email 					   = $request->email;
		$franchise->password 					= bcrypt($request->password);
		$franchise->phone 						= $request->phonenumber;
		$franchise->fax 						= $request->faxnumber;
		$franchise->state 						= $request->state;
		$franchise->city 						= $request->city;
		$franchise->zipcode 					= $request->zipcode;
		$franchise->location 					= $request->location;
		$franchise->address 					= $request->address;
		//$franchise->client_state 				= $request->client_state;
		//$franchise->client_city 				= $request->client_city;
		//$franchise->client_zipcode 				= $request->client_zipcode;
		//$franchise->client_address 				= $request->client_address;
		//$franchise->franchise_activation_date 	= date('Y-m-d',strtotime($request->franchise_activation_date));
		$franchise->fdd_signed_date 			= !empty($request->fdd_signed_date)?date('Y-m-d',strtotime($request->fdd_signed_date)):"";
		$franchise->fdd_expiration_date 		= !empty($request->fdd_expiration_date)?date('Y-m-d',strtotime($request->fdd_expiration_date)):"";
		$franchise->status 						= $request->status;
		$franchise->created_by 					= Auth::guard('admin')->user()->id;
		//if($request->contract_start) 			$franchise->contract_startdate = date('Y-m-d',strtotime($request->contract_start));
		//if($request->contract_end) 				$franchise->contract_enddate = date('Y-m-d',strtotime($request->contract_end));
		$franchise->contract_startdate = date('Y-m-d',strtotime($request->fdd_signed_date));
		$franchise->contract_enddate = date('Y-m-d',strtotime($request->fdd_expiration_date));
		$franchise->save();
		
		//Franchise EMployee
		$fowner = new Fuser();
		$fowner->franchise_id = $franchise->id;
		$fowner->email = $request->email;
		$fowner->password = bcrypt($request->password);
		$fowner->fullname = 'Franchise Administrator';
		$fowner->type = 'Owner';
		$fowner->save();
		
		//Contract & Fee
		$f_fee = new Franchise_fees();
		$f_fee->franchise_id 					= $franchise->id;
		$f_fee->contract_duration 			   = $years;
		$f_fee->fee_due_date 					= $request->feedue_date;
		//if($request->initialfranchise_fee) 	  $f_fee->initial_fee = str_replace('$','',$request->initialfranchise_fee);
		if($request->initialfranchise_fee) 	  $f_fee->initial_fee = $request->initialfranchise_fee;
		/*$f_fee->monthly_royalty_fee 			 = str_replace('$','',$request->monthly_royalty_fee);
		$f_fee->monthly_royalty_fee_second_year = str_replace('$','',$request->monthly_royalty_fee_second_year);
		$f_fee->monthly_royalty_fee_subsequent_years = str_replace('$','',$request->monthly_royalty_fee_subsequent_years);
		$f_fee->monthly_advertising_fee 		 = str_replace('$','',$request->monthly_advertising_fee);
		$f_fee->renewal_fee 					 = str_replace('$','',$request->renewal_fee);*/
		$f_fee->monthly_royalty_fee 			 = $request->monthly_royalty_fee;
		$f_fee->monthly_royalty_fee_second_year = $request->monthly_royalty_fee_second_year;
		$f_fee->monthly_royalty_fee_subsequent_years = $request->monthly_royalty_fee_subsequent_years;
		$f_fee->monthly_advertising_fee 		 = $request->monthly_advertising_fee;
		$f_fee->renewal_fee 					 = $request->renewal_fee;
		$f_fee->save();
		
		//Initial Fee
		$initial_payment = new Franchise_payments();
		$initial_payment->franchise_id 		  = $franchise->id;
		$initial_payment->invoice_name 		  = 'Initial Franchise Fee';
		$initial_payment->amount 				= $request->initialfranchise_fee;
		$initial_payment->save();

		//Monthly Royalty
		$monthly_royalty_payment = new Franchise_payments();
		$monthly_royalty_payment->franchise_id  = $franchise->id;
		$monthly_royalty_payment->invoice_name  = 'Monthly Royalty Fee';
		$monthly_royalty_payment->amount 		= $request->monthly_royalty_fee;
		$monthly_royalty_payment->save();
		
		//Monthly Advertising
		$monthly_advertising_fee = new Franchise_payments();
		$monthly_advertising_fee->franchise_id  = $franchise->id;
		$monthly_advertising_fee->invoice_name  = 'Monthly System Advertising Fee';
		$monthly_advertising_fee->amount 		= $request->monthly_advertising_fee;
		$monthly_advertising_fee->save();

		//Monthly Advertising
		$renewal_fee = new Franchise_payments();
		$renewal_fee->franchise_id 			 = $franchise->id;
		$renewal_fee->invoice_name 			 = 'Renewal Fee';
		$renewal_fee->amount 				   = $request->renewal_fee;
		$renewal_fee->save();
				
		//Franchise Owner Details
		$f_owners 							  = new Franchise_owners();
		$f_owners->fullname 					= $request->owner_name;
		$f_owners->franchise_id 				= $franchise->id;
		$f_owners->email 					   = $request->owner_email;
		$f_owners->phone 					   = $request->owner_contact;
		$f_owners->save();
		
		//Add Aditional Tasks list
		if($franchise->id){
			$sort = 0;
			foreach($this->AdditionalTasks() as $task){
				$fTask = new Franchise_tasklist();
				$fTask->task = $task;
				$fTask->franchise_id = $franchise->id;
				$fTask->status = 'Incomplete';
				$fTask->sort = $sort;
				$fTask->save();
				$sort++;
			}
			
			//WELCOME EMAIL CODE
			if(!empty($request->email))
			{
				$data = array( "password" => $request->password, "email" =>  $request->email, 'name'=>$franchise->location);
				\Mail::send('admin.franchises.email.welcome', ["password" => $data['password'], "email" => $data['email'], 'name'=>$franchise->location], function ($message) use ($data) {
					$message->from('swhouston@successonthespectrum.com', 'SOS');
					$message->to($data['email'])->subject("WELCOME TO SUCCESS ON THE SPECTRUM");
				});		
			}
		}
		
		
		if(!empty($franchise->id)){
			$Franchise_insurance = Franchise_insurance::where('franchise_id',$franchise->id)->get();
			if($Franchise_insurance->isEmpty()){
				//Add Required Insurance
				$required_insurance_data = [
					['franchise_id'=>$franchise->id, 'insurance_type'=> 'General liability insurance'],
					['franchise_id'=>$franchise->id, 'insurance_type'=> 'Professional liability insurance'],
					['franchise_id'=>$franchise->id, 'insurance_type'=> 'Property and casualty insurance'],
					['franchise_id'=>$franchise->id, 'insurance_type'=> 'Business interruption insurance'],
					['franchise_id'=>$franchise->id, 'insurance_type'=> 'Workers compensation insurance']
				];
				Franchise_insurance::insert($required_insurance_data);
			}
		
			$Franchise_local_advertisements = Franchise_local_advertisements::where('franchise_id',$franchise->id)->get();
			if($Franchise_local_advertisements->isEmpty()){
				//Add Local Advertisements
				/*$required_local_advertisements_data = [
					['franchise_id'=>$franchise->id, 'quarter'=> 1, 'year'=> date('Y')],
					['franchise_id'=>$franchise->id, 'quarter'=> 2, 'year'=> date('Y')],
					['franchise_id'=>$franchise->id, 'quarter'=> 3, 'year'=> date('Y')],
					['franchise_id'=>$franchise->id, 'quarter'=> 4, 'year'=> date('Y')]
				];
				Franchise_local_advertisements::insert($required_local_advertisements_data);*/
				$this->addLocalAdvertisementsQuartersData($franchise);
			}
		
			$Franchise_audit = Franchise_audit::where('franchise_id',$franchise->id)->get();
			if($Franchise_audit->isEmpty()){
				//Add Audit
				$required_audit_data = [
					['franchise_id'=>$franchise->id, 'from_year'=> date('Y'), 'to_year'=> date('Y')+1]
				];
				Franchise_audit::insert($required_audit_data);
			}
		}
		
		//Create Cargohold Folder
		if (!file_exists(storage_path().'/app/public/cargohold/'.$franchise->name)) 
		{
			mkdir(storage_path().'/app/public/cargohold/'.$franchise->name, 0777, true);
			$Cargohold_folders = new Cargohold_folders();
			$Cargohold_folders->name = $franchise->name;
			$Cargohold_folders->category = 'Completed Franchisee Forms';
			$Cargohold_folders->save();
		}

		return response()->json(['success'=>'Yes', 'franchise_id'=>$franchise->id]);
				
	}
	
	/////////////////////
	// All task list
	/////////////////////
	public function AdditionalTasks(){
		return array(
			'Received LETTER OF INTEREST',
			'Interview and give tour to potential franchisee',
			'Franchisee Signs Confidentiality Statement',
			'We give them the FDD',
			'Potential Franchisee signs Exhibtt J: Acknowledgment of receipt',
			'We host Discovery Day',
			'Franchisee signs FDD',
			'We supply franchisee with company email, pre-opening checklist, decor ideas, BCBA interview questionnaire, employment application, job listing descriptions',
			'We send them referral to Quickbooks',
			'We send them referral to ringcentral, suggest phone from amazon',
			'Send referral to Catalyst',
			'Franchisee secure a lease within 90 days of signing FDD. Franchisee give us a copy of the lease within five business days after it is signed',
			'Franchisee turns in Schedule 8: collateral assignment of lease signed by landlord',
			'After all construction is complete, Franchisee Returns signed copy of schedule 5 ADA and related certifications',
			'After opening bank account, Franchisee Returns schedule 1 ACH debit form',
			'Franchisee Returns proof of all necessary business licenses, permits, certifications',
			'Franchisee completes 2 week initial training program (within 90 days of signing the FDD and within 60 days of opening the center)',
			'Franchise location opens within 180 days of signing franchise agreement',
		);
	}

	///////////////////
	//	VIEW FRANCHISE
	///////////////////	
	public function edit(EditFranchiseRequest $request, $franchise_id){

        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Franchise";
        $sub_title                      = "Edit Franchise";
        $menu                           = "franchise";
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

		$getStates = State::get();
		$states = array();
		if(!$getStates->isEmpty()){
			foreach($getStates as $state){
				$states[] = $state;
			}
		}
		
		$data['states'] = $states;
		
		$data['Owner'] = Fuser::where(array('franchise_id'=>$franchise_id, 'type'=>'Owner'))->first();
		
		if($request->isMethod('post')){

			$franchise = Franchise::find($franchise_id);
			//$franchise->name 		= $request->franchise_name;
			$franchise->name 		= $request->location;
			$franchise->state 		= $request->state;
			$franchise->location 	= $request->location;
			$franchise->address 	= $request->address;
			$franchise->city 		= $request->city;
			$franchise->zipcode 	= $request->zipcode;
			if($request->email != $franchise->email) $franchise->email = $request->email;
			$franchise->phone 		= $request->phonenumber;
            $franchise->fax 		= $request->faxnumber;
			$franchise->fdd_signed_date 		= !empty($request->fdd_signed_date)?date('Y-m-d',strtotime($request->fdd_signed_date)):"";
			$franchise->fdd_expiration_date 	= !empty($request->fdd_expiration_date)?date('Y-m-d',strtotime($request->fdd_expiration_date)):"";
			
			//EMAIL
			//if($request->status != $franchise->status){
			//if($request->status != $franchise->status){	
			if(($request->status != $franchise->status) && !empty($franchise->email)){
				$message = 'Your franchise is '.$request->status.' now.';
		        $data = array("name" => $franchise->location, "email" => $franchise->email, "messages" => $message);
		        \Mail::send('email.email_template', ["name" => $franchise->location, "email" => $franchise->email, "link"=>url('franchise/login'), 'messages' => $message], function ($message) use ($data) {
		            $message->from('swhouston@successonthespectrum.com', 'SOS');
		            $message->to($data['email'])->subject("Franchise Expiration Notice");
		        });
			}
			
			$franchise->status = $request->status;
			
			if($request->fdd_signed_date != $franchise->fdd_signed_date)
			{
				$years = $this->addLocalAdvertisementsQuartersData($franchise);
				//$fdd_signed_date_year = date('Y',strtotime($request->fdd_signed_date));
				$Franchise_local_advertisements = Franchise_local_advertisements::where('franchise_id',$franchise->id)->whereNotIn('year', $years)->delete();
				/*foreach ($years as $year) {
					$status=NULL;if($year == $fdd_signed_date_year)$status = 'Not Applicable';
					$Franchise_local_advertisements = Franchise_local_advertisements::where('franchise_id',$franchise->id)->where('year',$year)->update(array('status' => $status));
				}*/
			}

			$franchise->save();
			
			Session::flash('Success','<div class="alert alert-success">Franchise successfully updated!</div>');
			//return redirect('/admin/franchise/view/'.$franchise_id);

		}
        
        $data['Franchise'] = Franchise::find($franchise_id);
        return view('admin.franchises.editFranchise',$data);
	}

	///////////////////
	//	VIEW FRANCHISE
	///////////////////	
	public function view(Request $request, $franchise_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Franchises";
        $sub_title                      = "Franchise";
        $menu                           = "franchise";
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
        
        //If id null then redirect
        if(!$franchise_id) return redirect('admin/franchises');
        
        $Franchise = Franchise::find($franchise_id);
        
        if(!$Franchise){
			return redirect('admin/franchises');
		}

		$payment = Franchise::find($franchise_id)->payments()
		->when($request->invoice_name, function ($query, $inv_name) {
                return $query->where('invoice_name', $inv_name);
        })->when($request->year, function ($query, $month) {
        	return $query->whereYear('created_at',$month);
        })->paginate(10);
        
        $data['Franchise'] = $Franchise;
        $data['Payments'] = $payment;
 		
		$data['total_clients'] = Admissionform::where("client_status","!=","Applicant")->where("franchise_id",$franchise_id)->count();
		$data['total_employees'] = Employmentform::where("personal_status","!=","Applicant")->where("franchise_id",$franchise_id)->count();
		
		//Check Franchise Audit ,Insurance and Local Advertisements
		if(!empty($franchise_id)){
			//Add Required Insurance
			$Franchise_insurance = Franchise_insurance::where('franchise_id',$franchise_id)->get();
			if($Franchise_insurance->isEmpty()){
				$required_insurance_data = [
					['franchise_id'=>$franchise_id, 'insurance_type'=> 'General liability insurance'],
					['franchise_id'=>$franchise_id, 'insurance_type'=> 'Professional liability insurance'],
					['franchise_id'=>$franchise_id, 'insurance_type'=> 'Property and casualty insurance'],
					['franchise_id'=>$franchise_id, 'insurance_type'=> 'Business interruption insurance'],
					['franchise_id'=>$franchise_id, 'insurance_type'=> 'Workers compensation insurance']
				];
				Franchise_insurance::insert($required_insurance_data);	
			}
			
			//Add Local Advertisements
			/*$Franchise_local_advertisements = Franchise_local_advertisements::where('franchise_id',$franchise_id)->where('year',date('Y'))->get();
			if($Franchise_local_advertisements->isEmpty()){
				$required_local_advertisements_data = [
					['franchise_id'=>$franchise_id, 'quarter'=> 1, 'year'=> date('Y')],
					['franchise_id'=>$franchise_id, 'quarter'=> 2, 'year'=> date('Y')],
					['franchise_id'=>$franchise_id, 'quarter'=> 3, 'year'=> date('Y')],
					['franchise_id'=>$franchise_id, 'quarter'=> 4, 'year'=> date('Y')]
				];
				Franchise_local_advertisements::insert($required_local_advertisements_data);	
			}*/
			$this->addLocalAdvertisementsQuartersData($Franchise);
			
			//Add Audit
			$Franchise_audit = Franchise_audit::where('franchise_id',$franchise_id)->where('from_year',date('Y'))->where('to_year',date('Y')+1)->get();
			if($Franchise_audit->isEmpty()){
				$required_audit_data = [
					['franchise_id'=>$franchise_id, 'from_year'=> date('Y'), 'to_year'=> date('Y')+1]
				];
				Franchise_audit::insert($required_audit_data);	
			} 
		}
		 
		//Get Franchise Audit ,Insurance and Local Advertisements Data
		$data['Audit'] = Franchise::find($franchise_id)->franchise_audit;
		$data['RequiredInsurance'] = Franchise::find($franchise_id)->franchise_insurance;
		$data['local_advertisements_year'] = isset($request->local_advertisements_year)?$request->local_advertisements_year:date('Y');
		$data['RequiredLocalAdvertisementsYears'] = Franchise_local_advertisements::where('franchise_id',$franchise_id)->groupBy('year')->get();
		$data['RequiredLocalAdvertisements'] = Franchise::find($franchise_id)->franchise_local_advertisements->where('year',$data['local_advertisements_year']);
		
		$franchise_audit_status = DB::select("SHOW COLUMNS FROM sos_franchise_audit LIKE 'status'");
		if ($franchise_audit_status) {
			$franchise_audit_status = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $franchise_audit_status[0]->Type));
		}
		$data['FranchiseAuditStatus'] = $franchise_audit_status;
		$franchise_insurance_status = DB::select("SHOW COLUMNS FROM sos_franchise_insurance LIKE 'status'");
		if ($franchise_insurance_status) {
			$franchise_insurance_status = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $franchise_insurance_status[0]->Type));
		}
		$data['FranchiseInsuranceStatus'] = $franchise_insurance_status;
		$franchise_local_advertisements_status = DB::select("SHOW COLUMNS FROM sos_franchise_local_advertisements LIKE 'status'");
		if ($franchise_local_advertisements_status) {
			$franchise_local_advertisements_status = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $franchise_local_advertisements_status[0]->Type));
		}
		$data['FranchiseLocalAdvertisementsStatus'] = $franchise_local_advertisements_status;
		return view('admin.franchises.view',$data); 
	}
	
	//////////////
	//VIEW PAYMENT
	//////////////
	public function viewPayment(Request $request, $franchise_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Franchises";
        $sub_title                      = "Franchise";
        $menu                           = "franchise";
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
        
        //If id null then redirect
        if(!$franchise_id) return redirect('admin/franchises');
        
        $Franchise = Franchise::find($franchise_id);
        
        if(!$Franchise){
			return redirect('admin/franchises');
		}

		$payment = Franchise::find($franchise_id)->payments()
		->when($request->invoice_name, function ($query, $inv_name) {
                return $query->where('invoice_name', $inv_name);
        })->when($request->year, function ($query, $month) {
        	return $query->whereYear('created_at',$month);
        })->paginate(10);
        
        $data['Franchise'] = $Franchise;
        $data['Payments'] = $payment;
 
		return view('admin.franchises.payment.viewPayment',$data);		
	}
	
	///////////////
	//VIEW TASKLIST
	///////////////
	public function viewtasklist(Request $request, $franchise_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Franchises";
        $sub_title                      = "Franchise";
        $menu                           = "franchise";
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
        
        //If id null then redirect
        if(!$franchise_id) return redirect('admin/franchises');
        
        $Franchise = Franchise::find($franchise_id);
        
        if(!$Franchise){
			return redirect('admin/franchises');
		}

        $data['Franchise'] = $Franchise;
 
		//return view('admin.franchises.tasklist.viewTasklist',$data);
		return view('admin.franchises.tasklist.editTask',$data);		
	}
	
	///////////////////
	// Add Task list
	//////////////////
	public function addtasklist(Request $request, $franchise_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Add Task list";
        $sub_title                      = "Add Task list";
        $menu                           = "franchise";
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
        
        $Franchise = Franchise::find($franchise_id);
        
        if(!$Franchise){
			return redirect('admin/franchises');
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

			$tasks = Franchise_tasklist::where('franchise_id', $franchise_id)->orderby('sort','asc')->get();
			if(!$tasks->isEmpty()){
				$sort = 1;
				foreach($tasks as $getTask){
					$U_task = Franchise_tasklist::find($getTask->id);
					$U_task->sort = $sort;
					$U_task->save();
					$sort++;
				}
			}
			
			$messgeEmail = 'Hello! ('.$Franchise->location.'), New tasks are assinged by Super Admin, <br/><br/>';
			$EmailTest = false;
			if(!empty($request->task)){
				foreach($request->task as $task){
					if($task == '') continue;

					$fTask = new Franchise_tasklist();
					$fTask->task = $task;
					$fTask->franchise_id = $franchise_id;
					$fTask->status = 'Incomplete';
					$fTask->save();
					
					$EmailTest = true;
					$messgeEmail .= '<strong>Task: </strong>'.$fTask->task.' <br/>';
				}
			}

			//if($EmailTest){
		    if($EmailTest && !empty($Franchise->email)){ 
			    $data = array("name" => $Franchise->location, "email" => $Franchise->email, "messages" => $messgeEmail);
		        \Mail::send('email.email_template', ["name" => $Franchise->location, "email" => $Franchise->email, "link"=>url('franchise/login'), 'messages' => $messgeEmail], function ($message) use ($data) {
		            $message->from('swhouston@successonthespectrum.com', 'SOS');
		            $message->to($data['email'])->subject("Franchise New Task Assigned By Super Admin");
		        });						
			}
			
			Session::flash('Success','<div class="alert alert-success">Task added successfully.</div>');
			return redirect('admin/franchise/viewtasklist/'.$franchise_id);
		}
		
        $data['Franchise'] = $Franchise;

		return view('admin.franchises.tasklist.addTask',$data);
	}
	
	///////////////////
	// Edit Task list
	//////////////////
	public function edittasklist(Request $request, $franchise_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Task list";
        $sub_title                      = "Edit Task list";
        $menu                           = "franchise";
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
        
        $Franchise = Franchise::find($franchise_id);
        
        if(!$Franchise){
			return redirect('admin/franchises');
		}
		
		if($request->isMethod('post')){
			
			$messgeEmail = 'These tasks status are changed by Super Admin, <br/><br/>';
			$EmailTest = false;
			if(!empty($request->task)){
				foreach($request->task as $task){
					
					$F_Tasks = Franchise_tasklist::where('franchise_id',$Franchise->id)->where('id',$task['task_id'])->get();
					if(!$F_Tasks->isEmpty()){
						foreach($F_Tasks as $getTask){
							if($getTask->id == $task['task_id']){
								if($task['status'] != $getTask['status']){
									$EmailTest = true;
									$messgeEmail .= '<strong>Task:</strong> '.$task['task_description'].'. <strong>Status Changed:</strong> '.$getTask['status']. ' To '. $task['status'].'<br/>';
								}
							}
						}
					}
					
					Franchise_tasklist::where('franchise_id',$Franchise->id)->where('id',$task['task_id'])
					->update(['sort' => $task['sort'], 'task' => $task['task_description'], 'status' => $task['status'] ]);

				}
			}
			
			//if($EmailTest){
			if($EmailTest && !empty($Franchise->email)){ 
				$Admin = Admin::where('type','Super Admin')->first();
		        $data = array("name" => $Franchise->location, "email" => $Franchise->email, "messages" => $messgeEmail);
		        \Mail::send('email.email_template', ["name" => $Franchise->location, "email" => $Franchise->email, "link"=>url('franchise/login'), 'messages' => $messgeEmail], function ($message) use ($data) {
		            $message->from('swhouston@successonthespectrum.com', 'SOS');
		            $message->to($data['email'])->subject("Franchise Task List Updated");
		        });					
			}
			
			Session::flash('Success','<div class="alert alert-success">Task list updated successfully.</div>');
			return redirect('admin/franchise/viewtasklist/'.$Franchise->id);
		}
        $data['Franchise'] = $Franchise;

		return view('admin.franchises.tasklist.editTask',$data);
	}	

	/////////////////
	//	DELETE TASK
	/////////////////
	public function deletetask($franchise_id, $task_id){

		$Franchise = Franchise::find($franchise_id);
        if(!$Franchise){
			return redirect('admin/franchises');
		}
		
		$F_task = Franchise_tasklist::where('franchise_id',$franchise_id)->where('id',$task_id);
		if(!$F_task) return redirect('admin/franchises');
		$F_task->delete();
		
		Session::flash('Success','<div class="alert alert-success">Task deleted successfully.</div>');
		//return redirect('admin/franchise/edittasklist/'.$franchise_id);
		return redirect('admin/franchise/viewtasklist/'.$franchise_id);
	}	
	
	////////////////
	//	Add OWNER
	////////////////
	public function addowner(Request $request, $franchise_id){
		
       /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Add Owner";
        $sub_title                      = "Add Owner";
        $menu                           = "franchise";
        $sub_menu                       = "";
        $breadcrumb                     = "Add Owner";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "breadcrumb"                            => $breadcrumb,
        );
		
		$Franchise = Franchise::find($franchise_id);
        if(!$Franchise){
			return redirect('admin/franchises');
		}

        $data['Franchise'] = $Franchise;
        $data['fullname'] = '';
        $data['fullname'] = '';
        $data['phone'] = '';
        $data['email'] = '';
        
		if($request->isMethod('post')){
			$validator = Validator::make($request->all(), [
			    'fullname' => 'required',
			    'phone' => 'required',
			    'email' => 'required|email',
			]);
			
			if ($validator->fails()) {
				return response()->json(['errors'=>$validator->errors()]);
			}
			
			$f_owner = new Franchise_owners();
			$f_owner->fullname = $request->fullname;
			$f_owner->franchise_id = $franchise_id;
			$f_owner->email = $request->email;
			$f_owner->phone = $request->phone;
			$f_owner->save();
			
			Session::flash('Success','<div class="alert alert-success">Owner successfully added</div>');
			return redirect('/admin/franchise/view/'.$franchise_id);
		}
        
        return view('admin.franchises.owner.form',$data);
	}

	////////////////
	//	EDIT OWNER
	////////////////
	public function editowner(Request $request, $franchise_id, $owner_id){
		
       /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Owner";
        $sub_title                      = "Edit Owner";
        $menu                           = "franchise";
        $sub_menu                       = "";
        $breadcrumb                     = "Edit Owner";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "breadcrumb"                            => $breadcrumb,
        );

		$Franchise = Franchise::find($franchise_id);
        if(!$Franchise){
			return redirect('admin/franchises');
		}
        
        $owner = Franchise_owners::find($owner_id);
        if(!$owner) return redirect('/admin/franchise/view/'.$franchise_id);
        
        $data['Franchise'] = $Franchise;
        $data['fullname'] = $owner->fullname;
        $data['phone'] = $owner->phone;
        $data['email'] = $owner->email;
        
		if($request->isMethod('post')){

			$validator = Validator::make($request->all(), [
			    'fullname' => 'required',
			    'phone' => 'required',
			    'email' => 'required|email',
			]);
			
			if ($validator->fails()) {
				return response()->json(['errors'=>$validator->errors()]);
			}
			
			$f_owner = Franchise_owners::find($owner_id);
			$f_owner->fullname = $request->fullname;
			$f_owner->email = $request->email;
			$f_owner->phone = $request->phone;
			$f_owner->save();
			
			Session::flash('Success','<div class="alert alert-success">Owner successfully Updated.</div>');
			return redirect('/admin/franchise/view/'.$franchise_id);
		}
		
		return view('admin.franchises.owner.form',$data);
	}

	/////////////////
	//	DELETE Owner
	/////////////////
	public function deleteowner($franchise_id, $owner_id){

		$Franchise = Franchise::find($franchise_id);
        if(!$Franchise){
			return redirect('admin/franchises');
		}
		
		$F_owner = Franchise_owners::where('franchise_id',$franchise_id)->where('id',$owner_id);
		if(!$F_owner) return redirect('admin/franchises');
		$F_owner->delete();
		
		Session::flash('Success','<div class="alert alert-success">Owner deleted successfully.</div>');
		return redirect('admin/franchise/view/'.$franchise_id);
		
	}	
	
	////////////////
	//	EDIT FEE
	////////////////
	public function editfee(EditFeeRequest $request, $franchise_id){

        //Checking if franchise not find then redirect
        $Franchise = Franchise::find($franchise_id);

        if(!$Franchise) return redirect('admin/franchises');
        
        if(!$Franchise->franchise_fees) return redirect('/admin/franchise/view/'.$franchise_id);		
        
       /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Fee";
        $sub_title                      = "Edit Fee";
        $menu                           = "franchise";
        $sub_menu                       = "";
        $breadcrumb                     = "Edit Fee";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "breadcrumb"                            => $breadcrumb,
        );

        if($request->isMethod('post')){
		
			/*$d1 = strtotime($request->contract_startdate);
			$d2 = strtotime($request->contract_enddate);

			$diff = abs($d2 - $d1);  
			$years = floor($diff / (365*60*60*24));
			
			if($years > 1){
				$years = $years.' Years';
			}else{
				$years = '1 Year';
			}*/

			$F_fee = Franchise_fees::find($Franchise->franchise_fees->id);
			//$F_fee->contract_duration 		= $years;
			$F_fee->fee_due_date 			= $request->fee_due_date;
			$F_fee->initial_fee 			= $request->initial_fee;
			$F_fee->monthly_royalty_fee 	= $request->monthly_royalty_fee;
			$F_fee->monthly_advertising_fee = $request->monthly_advertising_fee;
			$F_fee->monthly_royalty_fee_second_year = $request->monthly_royalty_fee_second_year;
			$F_fee->monthly_royalty_fee_subsequent_years = $request->monthly_royalty_fee_subsequent_years;
			$F_fee->renewal_fee 			= $request->renewal_fee;
			$F_fee->save();
			
			//$Franchise->contract_startdate = date('Y-m-d',strtotime($request->contract_startdate));
			//$Franchise->contract_enddate = date('Y-m-d',strtotime($request->contract_enddate));
			//$Franchise->save();
			
			Session::flash('Success','<div class="alert alert-success">Fees updated successfully.</div>');
			return redirect('admin/franchise/view/'.$franchise_id);
		}
        
        $data['Franchise'] = $Franchise;
        $data['F_fees'] = $Franchise->franchise_fees;
        
        return view('admin.franchises.editFee',$data);
	}
	
	/////////////////
	//EDIT PAYMENT
	/////////////////
	public function editpayment(Request $request, $franchise_id){
       /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Payment";
        $sub_title                      = "Edit Payment";
        $menu                           = "franchise";
        $sub_menu                       = "";
        $breadcrumb                     = "Edit Payment";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "breadcrumb"                            => $breadcrumb,
        );	
 
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
		
         //If id null then redirect
        if(!$franchise_id) return redirect('admin/franchises');
        
        $Franchise = Franchise::find($franchise_id);
        
        if(!$Franchise){
			return redirect('admin/franchises');
		}
			
		$payment = Franchise::find($franchise_id)->payments()->paginate(10);
		
        $data['Franchise'] = $Franchise;
        $data['Payments'] = $payment;
        
        return view('admin.franchises.payment.editPayment',$data);	
	}
	
	//UPDATE PAYMENT
	public function updateRecievedOn(Request $request, $franchise_id){
		if(Auth::check('admin')){
			$f_payment = Franchise_payments::find($request->payment_id);
			$f_payment->payment_recieved_on = date('Y-m-d',strtotime($request->date));
			$f_payment->save();
			
			return response()->json('success');
		}
	}

	//Update Payment Fields
	public function updatePaymentFields(Request $request, $franchise_id){
		if(Auth::check('admin')){
			$f_payment = Franchise_payments::find($request->payment_id);
			$f_payment->{$request->field_type} = $request->action;
			$f_payment->save();
			return response()->json('success');
		}
	}
	
	//Update Payment Details
	public function updatePaymentDetails(Request $request, $franchise_id){
		if(Auth::check('admin')){

			$f_payment = Franchise_payments::find($request->payment_id);
			if($f_payment->amount != $request->amount)$f_payment->amount = $request->amount;
			if($f_payment->status != $request->status)$f_payment->status = $request->status;
			if($f_payment->month != $request->month)$f_payment->month = $request->month;
			if($f_payment->late_fee != $request->late_fee)$f_payment->late_fee = $request->late_fee;
			if($f_payment->comment != $request->comment)$f_payment->comment = $request->comment;
			if($f_payment->payment_recieved_on != $request->payment_recieved_on)$f_payment->payment_recieved_on = date('Y-m-d', strtotime($request->payment_recieved_on));
			if($f_payment->action != $request->action)$f_payment->action = $request->action;
			$f_payment->save();
			
			return response()->json('success');
		}
	}
	
	//UPDATE PAYMENTS THROUGH POST MOTHOD
	public function UpdatePayments(Request $request, $franchise_id){

		if(!empty($request->payment)){
			foreach($request->payment as $payment){
				$F_payment 						 = Franchise_payments::find($payment['payment_id']);
				//$F_payment->status 				 = $payment['status'];
				$F_payment->amount 				 = $payment['amount'];
				$F_payment->year 				   = $payment['year'];
				$F_payment->month 				  = $payment['month'];
				$F_payment->late_fee 			   = $payment['late_fee'];
				$F_payment->comment 				= $payment['comment'];
				$F_payment->payment_recieved_on 	= ($payment['payment_recieved_on'] != '') ? date('Y-m-d', strtotime($payment['payment_recieved_on'])) : '0000-00-00';
				$F_payment->action 				 = $payment['action'];
				$F_payment->save();
			}
		}

		Session::flash('Success','<div class="alert alert-success">Payments updated successfully.</div>');
		return redirect('/admin/franchise/viewpayment/'.$franchise_id);
		
	}

	//Payment Print Report
	public function PaymentPrintReport(Request $request, $franchise_id){
		
		$starDate = date('Y-m-d',strtotime($request->startReport));
		$endDate = date('Y-m-d',strtotime($request->endReport));
		//$report = Franchise_payments::whereBetween('created_at', [$starDate, $endDate])
		$report = Franchise_payments::whereBetween('payment_recieved_on', [$starDate, $endDate])
		->when($request->action, function ($query, $action) {
        	return $query->where('action',$action);
        })->where('franchise_id',$franchise_id)->orderby('created_at','asc')->get();
		
		$data['report'] = $report;
		$data['franchise_id'] = $franchise_id;
		
		return view('admin.franchises.report',$data);
		
	}
	
	//////////////
	//Email Exist
	//////////////
	public function EmailExist(Request $request){
		$messages = [
		    'employee_email.required' => 'Email Already exit.',
		];
		
		$validator = Validator::make($request->all(), [
		    'email' => 'email|unique:franchises,email',
		], $messages);
		
		if ($validator->fails()) {
            return response()->json([ 'errors' => $validator->customMessages ]);
		}
		
		return response()->json(['success' => 'Done']);
	}
	
	////////////////////////////////
	//Email Exist for Franchise Edit
	////////////////////////////////
	public function EmailExistForFranchise(Request $request){
		$messages = [
		    'email.required' => 'Email Already exit.',
		];
		
		$validator = Validator::make($request->all(), [
		    'email' => 'email|unique:franchises,email,'.$request->franchise_id,
		], $messages);
		
		if ($validator->fails()) {
            return response()->json([ 'errors' => $validator->customMessages ]);
		}
		
		return response()->json(['success' => 'Done']);
	}
	
	//////////////////////////////////////
	//Email Exist for Franchise Owner Edit
	//////////////////////////////////////
	public function OwnerEmailExist(Request $request){
		$messages = [
		    'email.required' => 'Email Already exit.',
		];
		
		$validator = Validator::make($request->all(), [
		    'email' => 'email|unique:fusers,email,'.$request->employee_id,
		], $messages);
		
		if ($validator->fails()) {
            return response()->json([ 'errors' => $validator->customMessages ]);
		}
		
		return response()->json(['success' => 'Done']);
	}

	/////////////////
	//Invite Employee
	/////////////////
	public function inviteEmployee(REQUEST $request, $franchise_id, $employee_id){
		$Employee = Fuser::find($employee_id);
		/*$franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Employee->franchise_id != $franchise_id){
			echo "You can't access another franchise of Employee";exit;
		}*/
		
		$Employee->email 	= $request->login_email;
		$Employee->password = bcrypt($request->emp_password);
		$Employee->save();
		
        if(!empty($Employee->email)){ 
			$data = array( "name" => $Employee->fullname, "email" => $Employee->email, "password" => $request->emp_password);
			\Mail::send('email.invite_email', ["name" => $data['name'], "email" => $data['email'], "password" => $data['password'], "link"=>url('franchise/login')], function ($message) use ($data) {
				$message->from('swhouston@successonthespectrum.com', 'SOS');
				$message->to($data['email'])->subject("INVITATION OF SOS");
			});
		}
        
		Session::flash('Success','<div class="alert alert-success">Invitation successfully sent to Franchise Owner.</div>');
		return redirect('/admin/franchise/edit/'.$employee_id);
		
	}
	
	///////////////////////////
	//Update Required Insurance
	///////////////////////////
	public function updateRequiredInsurance(REQUEST $request)
	{
		$id = $request->id;
		$file = $request->file;
		$status = $request->status;
		$franchise_id = $request->franchise_id;
		$insurance_type = $request->insurance_type;
		$expiration_date = $request->expiration_date;
		
		$Franchise		     				 = Franchise::find($franchise_id);
		$Franchise_insurance 				   = Franchise_insurance::find($id);
		if(strtotime($expiration_date) > strtotime(date("Y-m-d")))
		$Franchise_insurance->status 		   = "Active";
		else
		$Franchise_insurance->status 		   = $status;
		$Franchise_insurance->expiration_date  = ($expiration_date != '') ? date('Y-m-d', strtotime($expiration_date)) : '0000-00-00';
		
	    $cargohold                              = new Cargohold();
		$cargohold->franchise_id                = $franchise_id;
		$cargohold->title                       = $insurance_type."-".$expiration_date;
		$cargohold->category                    = 'Completed Franchisee Forms';
		$cargohold->user_type                   = 'Admin';
        $cargohold->user_id                     = Auth::user()->id;
        $cargohold->shared_with_everyone        = 0;
        $cargohold->shared_with_franchise_admin = 0;
        $cargohold->shared_with_employees       = 0;
        $cargohold->shared_with_clients         = 0;
        $cargohold->shared_with_self            = 0;
        $cargohold->shared_with_admin           = 0;
		$cargohold->expiration_date             = $expiration_date;
		$cargohold->save();

		//Document Upload
		if ($request->hasFile('file')){

	        $file = $request->file('file');
			if (!file_exists(storage_path().'/app/public/cargohold')) {
			    mkdir(storage_path().'/app/public/cargohold', 0777, true);
			}
			//$destinationPath 	= storage_path().'/app/public/cargohold';
			$Cargohold_folders = Cargohold_folders::where("name",$Franchise->name)->first();
    		$destinationPath 	= storage_path().'/app/public/cargohold/'.$Franchise->name;
			$file_name 	      = $cargohold->id.'_cargohold_'.time().'.'.$file->getClientOriginalExtension();
    		$file->move($destinationPath,$file_name);
    		//$cargohold->file = '/app/public/cargohold/'.$file_name;
    		$cargohold->file = '/app/public/cargohold/'.$Franchise->name.'/'.$file_name;
			$cargohold->folder_id = $Cargohold_folders->id;
			$cargohold->save();
    		
			$messages = 'New Document added into Cargo Hold, <br/> <b>Document Name:</b> '.$cargohold->title;
			if($request->category != 'Personal Documents'){
				$franchise = Franchise::find($franchise_id);
		        if(!empty($franchise->email))
				{
					$data = array("name" => $franchise->location, "email" => $franchise->email, "messages" => $messages);
					\Mail::send('email.email_template', ["name" => $franchise->location, "email" => $franchise->email, "link"=>url('franchise/login'), 'messages' => $messages], function ($message) use ($data) {
						$message->from('swhouston@successonthespectrum.com', 'SOS');
						$message->to($data['email'])->subject("Cargo Hold Uploaded");
					});
				}
			}

	        $Employee = Admin::find(Auth::user()->id);
	        $Notification = new Notifications();
	        $Notification->title = 'Cargo Hold Uploaded';
	        $Notification->description = 'New cargo hold uploaded by '.$Employee->fullname;
	        $Notification->type = 'Activity';
	        $Notification->send_to_admin = '1';
	        $Notification->user_id = Auth::guard('admin')->user()->id;
	        $Notification->franchise_id = 0;
	        $Notification->user_type = 'Administration';
	        $Notification->send_to_type = 'Director of Administration';
	        $Notification->save();
			
			$Franchise_insurance->file = $cargohold->file;
			
		}
		$Franchise_insurance->save();
		
		Session::flash('Success','<div class="alert alert-success">Insurance updated successfully.</div>');
		return redirect('/admin/franchise/view/'.$franchise_id);
	}
	
	////////////////////////////
	//Update Local Advertisement
	////////////////////////////
	public function updateLocalAdvertisement(REQUEST $request)
	{
		$id = $request->id;
		$status = $request->status;
		$franchise_id = $request->franchise_id;
		$completion_date = $request->completion_date;
		
		$Franchise_local_advertisements 				   = Franchise_local_advertisements::find($id);
		$Franchise_local_advertisements->status 		   = $status;
		$Franchise_local_advertisements->completion_date  = ($completion_date != '') ? date('Y-m-d', strtotime($completion_date)) : '0000-00-00';
		$Franchise_local_advertisements->save();
		return response()->json(['success' => 'Done']);
	}
	/////////////////////////////////////
	//Upload Local Advertisement Document
	/////////////////////////////////////
	public function uploadLocalAdvertisementsDocument(REQUEST $request)
	{
		$id = $request->id;
		$file = $request->file;
		$franchise_id = $request->franchise_id;
		
		$cargohold                              = new Cargohold();
		$cargohold->franchise_id                = $franchise_id;
		$cargohold->title                       = "Local Advertising Document - ".date("m/d/Y");
		$cargohold->category                    = 'Completed Franchisee Forms';
		$cargohold->user_type                   = 'Admin';
        $cargohold->user_id                     = Auth::user()->id;
        $cargohold->shared_with_everyone        = 0;
        $cargohold->shared_with_franchise_admin = 0;
        $cargohold->shared_with_employees       = 0;
        $cargohold->shared_with_clients         = 0;
        $cargohold->shared_with_self            = 0;
        $cargohold->shared_with_admin           = 0;
		$cargohold->save();
		
		$Franchise = Franchise::find($franchise_id);
		$Franchise_local_advertisements = Franchise_local_advertisements::find($id);
		//Document Upload
		if ($request->hasFile('file')){

	        $file = $request->file('file');
			if (!file_exists(storage_path().'/app/public/cargohold')) {
			    mkdir(storage_path().'/app/public/cargohold', 0777, true);
			}
			//$destinationPath 	= storage_path().'/app/public/cargohold';
			$Cargohold_folders = Cargohold_folders::where("name",$Franchise->name)->first();
    		$destinationPath 	= storage_path().'/app/public/cargohold/'.$Franchise->name;
    		$file_name 	      = $cargohold->id.'_cargohold_'.time().'.'.$file->getClientOriginalExtension();
    		$file->move($destinationPath,$file_name);
    		//$cargohold->file = '/app/public/cargohold/'.$file_name;
    		$cargohold->file = '/app/public/cargohold/'.$Franchise->name.'/'.$file_name;
			$cargohold->folder_id = $Cargohold_folders->id;
			$cargohold->save();
    		
			$messages = 'New Document added into Cargo Hold, <br/> <b>Document Name:</b> '.$cargohold->title;
			if($request->category != 'Personal Documents'){
				$franchise = Franchise::find($franchise_id);
				if(!empty($franchise->email))
				{
					$data = array("name" => $franchise->location, "email" => $franchise->email, "messages" => $messages);
					\Mail::send('email.email_template', ["name" => $franchise->location, "email" => $franchise->email, "link"=>url('franchise/login'), 'messages' => $messages], function ($message) use ($data) {
						$message->from('swhouston@successonthespectrum.com', 'SOS');
						$message->to($data['email'])->subject("Cargo Hold Uploaded");
					});
				}
			}

	        $Employee = Admin::find(Auth::user()->id);
	        $Notification = new Notifications();
	        $Notification->title = 'Cargo Hold Uploaded';
	        $Notification->description = 'New cargo hold uploaded by '.$Employee->fullname;
	        $Notification->type = 'Activity';
	        $Notification->send_to_admin = '1';
	        $Notification->user_id = Auth::guard('admin')->user()->id;
	        $Notification->franchise_id = 0;
	        $Notification->user_type = 'Administration';
	        $Notification->send_to_type = 'Director of Administration';
	        $Notification->save();
			
			$Franchise_local_advertisements->file = $cargohold->file;
			
		}
		$Franchise_local_advertisements->save();
		
		Session::flash('Success','<div class="alert alert-success">Document uploaded successfully.</div>');
		return redirect('/admin/franchise/view/'.$franchise_id);
	}
	
	public function addLocalAdvertisementsQuartersData($franchise){
		$years = [];
		$quarter_limit = 4;
		$objFranchise = new Franchise();
		$franchise_id = $franchise->id;
		$fdd_signed_date = $franchise->fdd_signed_date;
		if(!empty($fdd_signed_date) && $fdd_signed_date != "0000-00-00")
		{
			$fdd_signed_date_day = date('d',strtotime($fdd_signed_date));
			$fdd_signed_date_year = date('Y',strtotime($fdd_signed_date));
			$fdd_signed_date_month = date('m',strtotime($fdd_signed_date));
			$current_date = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::today());
			$fdd_signed_year_last_date = Carbon::parse($fdd_signed_date)->endOfYear()->toDateString();
			$fdd_signed_year_number_days = Carbon::parse($fdd_signed_date)->diffInDays( $fdd_signed_year_last_date );
			$fdd_signed_year_number_months = Carbon::parse($fdd_signed_date)->diffInMonths( $fdd_signed_year_last_date );
			$local_advertisements_not_applicable_quarters = (int)(($quarter_limit)-ceil($fdd_signed_year_number_months/3));
			for ($year = $fdd_signed_date_year;$year<=$current_date->year;$year++) {
				if($objFranchise->check_franchise_local_advertisements($franchise_id,$year))
				{
					if($year == $fdd_signed_date_year)
					{
						if($fdd_signed_year_number_days > 60)
						{
							for ($quarter = 1;$quarter<=$quarter_limit;$quarter++) {
								$status = NULL;
								if($quarter <= $local_advertisements_not_applicable_quarters)
								{
									$status = 'Not Applicable';
								}
								$required_local_advertisements_data[$quarter] = [
																				'franchise_id'=>$franchise_id, 
																				'quarter'=> $quarter, 
																				'year'=> $year,
																				'status'=> $status
																				];
							}
							Franchise_local_advertisements::insert($required_local_advertisements_data);
						}
					}
					else
					{
						$objFranchise->add_franchise_local_advertisements($franchise_id,$year);
					}
				}
				$years[] = $year;
			}
		}
		return $years;
	}
	
	//////////////
	//Update Audit
	//////////////
	public function updateAudit(REQUEST $request)
	{
		$id = $request->id;
		$status = $request->status;
		$franchise_id = $request->franchise_id;
		$conducted_date = $request->conducted_date;
		
		$Franchise_audit 				   = Franchise_audit::find($id);
		$Franchise_audit->status 		   = $status;
		$Franchise_audit->conducted_date   = ($conducted_date != '') ? date('Y-m-d', strtotime($conducted_date)) : '0000-00-00';
		$Franchise_audit->save();
		return response()->json(['success' => 'Done']);
	}
	
	//////////////////
	//Franchise Delete
	//////////////////
	public function delete(Request $request){
		if(Auth::check('admin')){
			//if($request->isMethod('post')){
			{
				$franchise_id = $request->id;
				if(!empty($franchise_id))
				{
					$franchise = Franchise::find($franchise_id);
					if(!empty($franchise))
					{
						/*Delete Fusers*/
						$getFusers = DB::table('fusers')->where('franchise_id', $franchise_id)->get();
						if(!$getFusers->isEmpty())
						{
							echo "Delete Fusers<br>";
							DB::table('fusers')->where('franchise_id', $franchise_id)->delete();
						}
						
						/*Delete Cargoholds*/
						$getCargoholds = DB::table('cargohold')->where('franchise_id', $franchise_id)->get();
						if(!$getCargoholds->isEmpty())
						{
							echo "Delete Cargoholds<br>";
							DB::table('cargohold')->where('franchise_id', $franchise_id)->delete();
						}
						
						/*Delete Franchises Events*/
						$getFranchisesEvents = DB::table('franchises_events')->where('franchise_id', $franchise_id)->get();
						if(!$getFranchisesEvents->isEmpty())
						{
							echo "Delete Franchises Events<br>";
							DB::table('franchises_events')->where('franchise_id', $franchise_id)->delete();
						}
						
						/*Delete Franchises Trip Itenary*/
						$getFranchisesTripItenary = DB::table('franchises_trip_itenary')->where('franchise_id', $franchise_id)->get();
						if(!$getFranchisesTripItenary->isEmpty())
						{
							echo "Delete Franchises Trip Itenary<br>";
							DB::table('franchises_trip_itenary')->where('franchise_id', $franchise_id)->delete();
						}
						
						/*Delete Franchises Fees*/
						$getFranchisesFees = DB::table('franchise_fees')->where('franchise_id', $franchise_id)->get();
						if(!$getFranchisesFees->isEmpty())
						{
							echo "Delete Franchises Fees<br>";
							DB::table('franchise_fees')->where('franchise_id', $franchise_id)->delete();
						}
						
						/*Delete Franchises Owners*/
						$getFranchisesOwners = DB::table('franchise_owners')->where('franchise_id', $franchise_id)->get();
						if(!$getFranchisesOwners->isEmpty())
						{
							echo "Delete Franchises Owners<br>";
							DB::table('franchise_owners')->where('franchise_id', $franchise_id)->delete();
						}
						
						$getFranchisesPasswordResets = DB::table('franchise_password_resets')->where('email', $franchise->email)->get();
						if(!$getFranchisesPasswordResets->isEmpty())
						{
							echo "Delete Franchise Password Resets<br>";
							DB::table('franchise_password_resets')->where('email', $franchise->email)->delete();
						}
						
						/*Delete Franchises Payments*/
						$getFranchisesPayments = DB::table('franchise_payments')->where('franchise_id', $franchise_id)->get();
						if(!$getFranchisesPayments->isEmpty())
						{
							echo "Delete Franchises Payments<br>";
							DB::table('franchise_payments')->where('franchise_id', $franchise_id)->delete();
						}
						
						/*Delete Franchises Tasklist*/
						$getFranchisesTasklist = DB::table('franchise_tasklist')->where('franchise_id', $franchise_id)->get();
						if(!$getFranchisesTasklist->isEmpty())
						{
							echo "Delete Franchises Tasklist<br>";
							DB::table('franchise_tasklist')->where('franchise_id', $franchise_id)->delete();
						}
						
						/*Delete Franchises Insurance*/
						$getFranchisesInsurance = DB::table('franchise_insurance')->where('franchise_id', $franchise_id)->get();
						if(!$getFranchisesInsurance->isEmpty())
						{
							echo "Delete Franchises Insurance<br>";
							DB::table('franchise_insurance')->where('franchise_id', $franchise_id)->delete();
						}
						
						/*Delete Franchises Audit*/
						$getFranchisesAudit = DB::table('franchise_audit')->where('franchise_id', $franchise_id)->get();
						if(!$getFranchisesAudit->isEmpty())
						{
							echo "Delete Franchises Audit<br>";
							DB::table('franchise_audit')->where('franchise_id', $franchise_id)->delete();
						}
						
						/*Delete Franchises Advertisements*/
						$getFranchisesAdvertisements = DB::table('franchise_local_advertisements')->where('franchise_id', $franchise_id)->get();
						if(!$getFranchisesAdvertisements->isEmpty())
						{
							echo "Delete Franchises Advertisements<br>";
							DB::table('franchise_local_advertisements')->where('franchise_id', $franchise_id)->delete();
						}
						
						/*Delete Clients/Parents*/
						$getClients = DB::table('admission_form')->where('franchise_id', $franchise_id)->get();
						if(!$getClients->isEmpty())
						{
							foreach($getClients as $client)
							{
								$client_tasklists = DB::table('parent_tasklist')->where('client_id', $client->id)->get();
								if(!$client_tasklists->isEmpty())
								{
									echo "Delete Parent Task Lists<br>";
									DB::table('parent_tasklist')->where('client_id', $client->id)->delete();
								}
								
								$client_documents = DB::table('admission_form_documents')->where('client_id', $client->id)->get();
								if(!$client_documents->isEmpty())
								{
									echo "Delete Client Documents<br>";
									DB::table('admission_form_documents')->where('client_id', $client->id)->delete();
								}
								
								$client_password_resets = DB::table('parent_password_resets')->where('email', $client->email)->get();
								if(!$client_password_resets->isEmpty())
								{
									echo "Delete Parent Password Resets<br>";
									DB::table('parent_password_resets')->where('email', $client->email)->delete();
								}
								
								if(!empty($client->client_profilepicture))
								{
									$exists = Storage::exists($client->client_profilepicture);
									if($exists)
									{
										Storage::delete($client->client_profilepicture);
									}
								}
							}
							echo "Delete Clients";
							DB::table('admission_form')->where('franchise_id', $franchise_id)->delete();
						}
						
						/*Delete Employees*/
						$getEmployees = DB::table('employment_form')->where('franchise_id', $franchise_id)->get();
						if(!$getEmployees->isEmpty())
						{
							foreach($getEmployees as $employee)
							{
								$femployees_aba_experience_reference = DB::table('femployees_aba_experience_reference')->where('admin_employee_id', $employee->id)->get();
								if(!$femployees_aba_experience_reference->isEmpty())
								{
									echo "Delete Femployees Aba Experience Reference<br>";
									DB::table('femployees_aba_experience_reference')->where('admin_employee_id', $employee->id)->delete();
								}
								
								$femployees_certifications = DB::table('femployees_certifications')->where('admin_employee_id', $employee->id)->get();
								if(!$femployees_certifications->isEmpty())
								{
									echo "Delete Femployees Certifications<br>";
									DB::table('femployees_certifications')->where('admin_employee_id', $employee->id)->delete();
								}
								
								$femployees_emergency_contacts = DB::table('femployees_emergency_contacts')->where('admin_employee_id', $employee->id)->get();
								if(!$femployees_emergency_contacts->isEmpty())
								{
									echo "Delete Femployees Emergency Contacts<br>";
									DB::table('femployees_emergency_contacts')->where('admin_employee_id', $employee->id)->delete();
								}
								
								$femployees_login_credentials = DB::table('femployees_login_credentials')->where('admin_employee_id', $employee->id)->get();
								if(!$femployees_login_credentials->isEmpty())
								{
									echo "Delete Femployees Login Credentials<br>";
									DB::table('femployees_login_credentials')->where('admin_employee_id', $employee->id)->delete();
								}
								
								$femployees_performance_log = DB::table('femployees_performance_log')->where('admin_employee_id', $employee->id)->get();
								if(!$femployees_performance_log->isEmpty())
								{
									echo "Delete Femployees Performance Log<br>";
									DB::table('femployees_performance_log')->where('admin_employee_id', $employee->id)->delete();
								}
								
								$femployees_schedules = DB::table('femployees_schedules')->where('admin_employee_id', $employee->id)->get();
								if(!$femployees_schedules->isEmpty())
								{
									echo "Delete Femployees Schedules<br>";
									DB::table('femployees_schedules')->where('admin_employee_id', $employee->id)->delete();
								}
								
								$femployees_tasklist = DB::table('femployees_tasklist')->where('employee_id', $employee->id)->get();
								if(!$femployees_tasklist->isEmpty())
								{
									echo "Delete Femployees Tasklist<br>";
									DB::table('femployees_tasklist')->where('employee_id', $employee->id)->delete();
								}
								
								$femployees_time_punch = DB::table('femployees_time_punch')->where('admin_employee_id', $employee->id)->get();
								if(!$femployees_time_punch->isEmpty())
								{
									echo "Delete Femployees Time Punch<br>";
									DB::table('femployees_time_punch')->where('admin_employee_id', $employee->id)->delete();
								}
								
								$femployee_password_resets = DB::table('femployee_password_resets')->where('email', $employee->personal_email)->get();
								if(!$femployee_password_resets->isEmpty())
								{
									echo "Delete Parent Password Resets<br>";
									DB::table('femployee_password_resets')->where('email', $employee->personal_email)->delete();
								}
								
								if(!empty($employee->personal_picture))
								{
									$exists = Storage::exists($employee->personal_picture);
									if($exists)
									{
										Storage::delete($employee->personal_picture);
									}
								}
							}
							echo "Delete Employees<br>";
							DB::table('employment_form')->where('franchise_id', $franchise_id)->delete();
						}
					}
					echo "Delete Franchise<br>";
					if(!empty($franchise->profile_picture))
					{
						$exists = Storage::exists($franchise->profile_picture);
						if($exists)
						{
							Storage::delete($franchise->profile_picture);
						}
					}
					$franchise->delete($franchise_id);
				}
			}//
		}//
	}	
	
	///////////////////////
	// LOGIN AS A FRANCHISE
	///////////////////////
    public function impersonate(REQUEST $request, $franchise_id){
    	
    	$Fuser = Fuser::where('franchise_id',$franchise_id)->orderby('created_at','asc')->first();
		Auth::guard('franchise')->loginUsingId($Fuser->id);
		$request->session()->put('impersonate','1');
		return redirect('franchise/dashboard');
		
	}	
	
	public function testcron()
	{
		$Franchises = Franchise::get();
        if(!$Franchises->isEmpty()){
			$current_date = \Carbon\Carbon::today()->format('Y-m-d');
			$expiration_upcoming_date = \Carbon\Carbon::createFromFormat('Y-m-d', $current_date)->addMonth()->format('Y-m-d');
			foreach($Franchises as $Franchise){
				//echo "<pre>";print_r($Franchise->franchise_insurance()->get()->toArray());
				//$Franchise_insurances = $Franchise->franchise_insurance()->get();
				$Franchise_insurances = Franchise_insurance::where('status','!=','Active')->where('franchise_id',$Franchise->id)->whereBetween('expiration_date',[$current_date, $expiration_upcoming_date])->get();
				//echo "<pre>";print_r($Franchise_insurances->toArray());
				if(!$Franchise_insurances->isEmpty()){
					foreach($Franchise_insurances as $Franchise_insurance){
						$insurance_type = $Franchise_insurance->insurance_type;
						$date_difference = strtotime($Franchise_insurance->expiration_date) - strtotime($current_date);
						$message = $insurance_type;
						$days = round($date_difference / (60 * 60 * 24));	
						if($days > 0)
						{
							$message = ' will be expire with in '.($days > 1 ? $days.' days.' : $days.' day.');
		
						}elseif($days == 0)
						{
							$message = ' will be expire today.';
						
						}else
						{
							$message = ' is expired.';
							$Franchise_insurance_update 		 = Franchise_insurance::find($Franchise_insurance->id);
							$Franchise_insurance_update->status = "Expired";
							$Franchise_insurance_update->save();
						}
						
						$data = array("name" => $Franchise->Location, "email" => $Franchise->email, "Message" => $message);
						/*\Mail::send('email.email_template', ["name" => $Franchise->Location, "email" => $Franchise->email, "link"=>url('franchise/login'), 'Message' => $message], function ($message) use ($data) {
							$message->from(['address' => 'swhouston@successonthespectrum.com', 'name' => 'SOS']);
							$message->to($data['email'])->subject("Your Insurance Expiration Notice");
						});*/
						
						$message = $Franchise->Location." ".$message;
						$Admin = Admin::where(array('type'=>'Super Admin'))->first();
						$data = array("name" => $Admin->fullname, "email" => $Admin->email, "Message" => $message);
						/*\Mail::send('email.email_template', ["name" => $Admin->fullname, "email" => $Admin->email, "link"=>url('admin/login'), 'Message' => Message], function ($message) use ($data) {
							$message->from('swhouston@successonthespectrum.com', 'SOS');
							$message->to($data['email'])->subject("Franchise Insurance Expiration Notice");
						});*/
						
						\Log::info($Franchise->Location." Franchise Insurance Expiration Cron Running.");
					}
				}
			}
		}
	}
}