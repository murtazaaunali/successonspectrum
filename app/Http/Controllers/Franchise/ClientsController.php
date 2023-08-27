<?php

namespace App\Http\Controllers\Franchise;

use Session;
use DateTime;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

//Models
use App\Models\Franchise;
use App\Models\Franchise\Client;
use App\Models\Franchise\Femployee;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Frontend\Employmentform;
use App\Models\Franchise\Client_tasklist;
use App\Models\Franchise\Client_documents;
use App\Models\Franchise\Client_schedules;
use App\Models\Franchise\Client_insurance_policy;
use App\Models\Franchise\Client_insurance_policy_idcards;
use App\Models\Franchise\Client_insurance_policy_authorizations;

class ClientsController extends Controller
{
	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard('franchise')->user();
		$users[] = Auth::guard('franchise')->user();
		//exit();
	}
	
	public function index(Request $request){

        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Clients";
        $sub_title                      = "Clients";
        $menu                           = "clients";
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
 
		$franchise_id = Auth::guard('franchise')->user()->franchise_id;

		/*$Emps = array();
		if(isset($request->client_crew)){
			$getIds = Femployee::where(array('crew_type'=>$request->client_crew, 'franchise_id'=>$franchise_id))->select('id')->get();
			if(!$getIds->isEmpty()){
				foreach($getIds as $ids){
					$Emps[] = $ids->id;
				}
			}
		}*/
		//echo '<pre>';print_r($Emps);exit;
		
		/*$getClients = Client::where('franchise_id',$franchise_id)
		->when($request->client_status, function ($query, $client_status) {
            return $query->where('client_status', $client_status);
        })
		->when($request->client_name, function ($query, $client_name) {
            return $query->where('client_childfullname', 'LIKE', "%".$client_name."%");
        })
		->when($request->client_location, function ($query, $client_location) {
            return $query->where('chooselocation_interest', 'LIKE', "%".$client_location."%");
        })
		//->when($request->client_crew, function ($query, $client_crew) use ($Emps) {
		->when($request->client_crew, function ($query, $client_crew) {	
            return $query->where('client_crew', 'LIKE', "%".$client_crew."%");
            //return $query->whereIn('client_crew',$Emps);
        })
        ->orderby('created_at','desc')->paginate($this->pagelimit);*/
		$getClients = Client::where('franchise_id',$franchise_id)
		->when($request->client_status, function ($query, $client_status) {
            return $query->where('client_status', $client_status);
        })
		->when($request->client_name, function ($query, $client_name) {
            return $query->where('client_childfullname', 'LIKE', "%".$client_name."%");
        })
		->when($request->client_location, function ($query, $client_location) {
            return $query->where('chooselocation_interest', 'LIKE', "%".$client_location."%");
        })
		->when($request->client_crew, function ($query, $client_crew) {	
            return $query->where('client_crew', 'LIKE', "%".$client_crew."%");
        });
		
		$getClients = $getClients->join('parent_insurance_policy', function ($join) {
            $join->on('admission_form.id', '=', 'parent_insurance_policy.client_id')->where('parent_insurance_policy.client_insurance_primary', 1);
        })->leftJoin('parent_insurance_policy_authorizations', function ($join) {
			$join->on('parent_insurance_policy.id', '=', 'parent_insurance_policy_authorizations.client_insurance_id')->where('parent_insurance_policy_authorizations.isactive', 1);
		})->select('admission_form.id','admission_form.client_status','admission_form.client_childfullname','admission_form.chooselocation_location','admission_form.client_crew','parent_insurance_policy_authorizations.client_authorizationseenddate');
		$data['order'] = '';
		$data['sorting'] = '';
		if(isset($request->sorting) && isset($request->order))
		{
			if($request->sorting == 'name')
			$sorting = "admission_form.client_childfullname";
			elseif($request->sorting == 'status')
			$sorting = "admission_form.client_status";
			elseif($request->sorting == 'location')
			$sorting = "admission_form.chooselocation_location";
			elseif($request->sorting == 'crew')
			$sorting = "admission_form.client_crew";
			elseif($request->sorting == 'auth_expiration')
			$sorting = "parent_insurance_policy_authorizations.client_authorizationseenddate";
			else
			$sorting = "admission_form.created_at";
			
			$data['sorting'] = $request->sorting;
			$order = $data['order'] = $request->order;
			$getClients = $getClients->orderby($sorting,$order);
		}
		else
		{
			//$getClients = $getClients->orderby('admission_form.created_at','desc');
			$getClients = $getClients->orderby('parent_insurance_policy_authorizations.client_authorizationseenddate','asc');
		}
		$getClients = $getClients->paginate($this->pagelimit);
		//echo "<pre>";print_r($getClients);
		$data['getClients'] = $getClients;
		
		$getFranchises = Franchise::when('Active', function ($query, $status) {
            return $query->where('status', $status);
        })->orderby('created_at','desc')->paginate(0);
		$data['franchises'] = array();
		if($getFranchises){
			foreach($getFranchises as $franchise){
				$data['franchises'][] = $franchise;
			}
		}
		
		$Active_Clients 	= Client::where(array('client_status'=>'Active', 'franchise_id'=>$franchise_id))->count();
		$Total_Ocean_Clients 	= Client::where(array('client_crew'=>'Ocean', 'franchise_id'=>$franchise_id))->count();
		$Total_Voyager_Clients 	= Client::where(array('client_crew'=>'Voyager', 'franchise_id'=>$franchise_id))->count();
		$Total_Sailor_Clients 	= Client::where(array('client_crew'=>'Sailor', 'franchise_id'=>$franchise_id))->count();
		$data['Active_Clients'] = $Active_Clients;
		$data['Total_Ocean_Clients'] = $Total_Ocean_Clients;
		$data['Total_Voyager_Clients'] = $Total_Voyager_Clients;
		$data['Total_Sailor_Clients'] = $Total_Sailor_Clients;

	    return view('franchise.clients.list',$data);
	}
	
	/////////////////
	// View Client
	/////////////////
	public function view(Request $request, $client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Clients";
        $sub_title                      = "Clients";
        $menu                           = "clients";
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
        if(!$client_id) return redirect('franchise/clients');
        
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('franchise/clients');
		}
		
		$franchise_id = Auth::guard('franchise')->user()->franchise_id;
		
		if($Client->franchise_id != $franchise_id){
			echo "You can't view other franchises clients";exit;
		}
        
        $data['Client'] = $Client;
		
		$getClients = Client::where('franchise_id',$franchise_id) ->orderby('created_at','desc')->paginate(0);
		$data['clients'] = array();
		if($getClients){
			foreach($getClients as $client){
				$data['clients'][] = $client;
			}
		}
		
		$data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(0);
		
		return view('franchise.clients.view',$data);
	}
	
	///////////////////
	//	Edit Client
	///////////////////	
	public function edit(Request $request, $client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Client";
        $sub_title                      = "Edit Client";
        $menu                           = "clients";
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
        
        $Client = Client::find($client_id);
        $data['Client'] = $Client;
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients.";exit;
		}
		
		if($request->isMethod('post')){

			$client = Client::find($client_id);
			$client->client_status 						= $request->client_status;
			$client->client_childfullname 				= $request->client_childfullname;
			$client->client_childdateofbirth 			= date('Y-m-d',strtotime($request->client_childdateofbirth));
			$client->client_custodialparent 			= $request->client_custodialparent;
			$client->chooselocation_interest 			= $request->chooselocation_interest;
			$client->client_schoolname 					= $request->client_schoolname;
		    $client->client_crew 						= $request->client_crew;
			$client->client_momsname 					= $request->client_momsname;
			$client->client_momsemail 					= $request->client_momsemail;
			$client->client_momscell	 				= $request->client_momscell;
			$client->client_custodialparentsaddress	 	= $request->client_custodialparentsaddress;
			$client->client_dadsname 					= $request->client_dadsname;
			$client->client_dadsemail 					= $request->client_dadsemail;
			$client->client_dadscell	 				= $request->client_dadscell;
			$client->client_emergencycontactname	 	= $request->client_emergencycontactname;
			$client->client_emergencycontactphone       = $request->client_emergencycontactphone;
			/*$client->email           				   	= $request->client_email;
			if($request->client_password) $client->password    = bcrypt($request->client_password);*/
			
			$client->save();

			Session::flash('Success','<div class="alert alert-success">Client successfully updated</div>');
			//return redirect()->back();
			return redirect('/franchise/client/view/'.$client_id);

		}
        
        $crews = Employmentform::where('franchise_id',$franchise_id)->where('personal_status','Active')->get();
        $data['crews'] 	= $crews;

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
		
		return view('franchise.clients.editClient',$data);
	}
	
	//////////////////////
	//	Check Client Email
	//////////////////////	
	public function clientEmailExist(Request $request){
		$messages = [
		    'client_email.required' => 'Email Already exit.',
		];
		
		$validator = Validator::make($request->all(), [
		    'email' => 'email|unique:admission_form,email,'.$request->client_id,
		], $messages);
		
		if ($validator->fails()) {
            return response()->json([ 'errors' => $validator->customMessages ]);
		}
		
		return response()->json(['success' => 'Done']);
	}
	
	///////////////////
	//	Delete Client
	//////////////////
	public function deleteClient($client_id){
		$Client = Client::find($client_id);
		if(!$Client){
			return redirect('franchise/clients');
		}
		
		$franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id) {
			echo "You can't delete another franchises of clients.";exit;
		}
		
		$Document = Client_documents::where('client_id',$client_id)->get();
		if(!$Document->isEmpty()){
			foreach($Document as $doc){
				
				$directory = 'medical-report-other';
				if($doc->document == 'Childs Dignostic') $directory = 'client-child-diagnostic-report';
				if($doc->document == 'Childs IEP') $directory = 'client-child-iep';
				
				$exists = Storage::exists('public/admissionforms/'.$directory.'/'.basename($doc->document_file));
				if($exists){
					Storage::delete('public/admissionforms/'.$directory.'/'.basename($doc->document_file));
				}
				
				$getDoc = Client_documents::find($doc->id);
				$getDoc->delete();
			}
		}
		
		$Client->delete();

		Session::flash('Success','<div class="alert alert-success">Client successfully deleted</div>');
		return redirect('/franchise/clients');
	}
	
	//////////////////
	//	View Insurance
	//////////////////
	//public function viewInsurance(Request $request, $client_id){
	public function viewInsurance(Request $request, $client_id, $client_insurance_id=""){	
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Clients";
        $sub_title                      = "Clients";
        $menu                           = "clients";
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
        if(!$client_id) return redirect('franchise/clients');
        
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('franchise/clients');
		}

        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}

        $data['Client'] = $Client;
		
		$franchise_id = Auth::guard('franchise')->user()->franchise_id;
		$getClients = Client::where('franchise_id',$franchise_id) ->orderby('created_at','desc')->paginate(0);
		$data['clients'] = array();
		if($getClients){
			foreach($getClients as $client){
				$data['clients'][] = $client;
			}
		}
		
		$data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(0);
		
		if(!empty($client_insurance_id))
		{
			$data['client_related_insurance'] = $client_insurance_id;
			$ClientInsurancePolicy = $Client->insurance_policies()->where('id',$client_insurance_id)->get();
			$ClientInsurancePolicies = $Client->insurance_policies()->where('client_insurance_primary',"!=","-1");
		}
		else
		{
			$data['client_related_insurance'] = "";
			$ClientInsurancePolicies = $Client->insurance_policies()->where('client_insurance_primary',"0");
			$ClientInsurancePolicy = $Client->insurance_policies()->where('client_id',$client_id)->where('client_insurance_primary',1)->get();
		}
		
		if($ClientInsurancePolicy->isEmpty()){
			/*Save Data in Client Insurance Policy*/
			$Client_insurance_policy = new Client_insurance_policy();
			$Client_insurance_policy->client_id = $Client->id;
			$Client_insurance_policy->client_insurancecompanyname = $Client->client_insurancecompanyname;
			$Client_insurance_policy->client_memberid = $Client->client_memberid;
			$Client_insurance_policy->client_groupid = $Client->client_groupid;
			$Client_insurance_policy->client_policyholdersname = $Client->client_policyholdersname;
			if($request->client_policyholdersdateofbirth)
			$Client_insurance_policy->client_policyholdersdateofbirth = date('Y-m-d',strtotime($Client->client_policyholdersdateofbirth));
			$Client_insurance_policy->client_insurance_primary = 1;
			//Benefits
			$Client_insurance_policy->client_benefiteffectivedate     	= date('Y-m-d',strtotime($Client->client_benefiteffectivedate));
			$Client_insurance_policy->client_benefitexpirationdate       = date('Y-m-d',strtotime($Client->client_benefitexpirationdate));
			$Client_insurance_policy->client_benefitcopay 		     	= $Client->client_benefitcopay;
			$Client_insurance_policy->client_benefitoopm 		      	 = $Client->client_benefitoopm;
			$Client_insurance_policy->client_benefitannualbenefit     	= $Client->client_benefitannualbenefit;
			$Client_insurance_policy->client_benefitclaimaddress      	 = $Client->client_benefitclaimaddress;
			$Client_insurance_policy->client_benefitdateverified      	 = date('Y-m-d',strtotime($Client->client_benefitdateverified));
			$Client_insurance_policy->client_benefitinsuranceemployee 	= $Client->client_benefitinsuranceemployee;
			$Client_insurance_policy->client_benefitreferencenumber      = $Client->client_benefitreferencenumber;
			$Client_insurance_policy->save();
			
			/*Save Data in Client_insurance_policy_idcards*/
			if (!empty($Client->client_insurancecompanyidcard)){
				$Client_insurance_policy_idcards = new Client_insurance_policy_idcards();
				$Client_insurance_policy_idcards->client_insurance_id  = $Client_insurance_policy->id;
				$Client_insurance_policy_idcards->client_insurancecompanyidcard = $Client->client_insurancecompanyidcard;
				$Client_insurance_policy_idcards->save();
				
				/*Save Data in Client_insurance_policy_idcards_authorizations*/
				$Client_insurance_policy_authorizations = new Client_insurance_policy_authorizations();
				$Client_insurance_policy_authorizations->isactive 							  = 1;
				$Client_insurance_policy_authorizations->client_insurance_id           	       = $Client_insurance_policy->id;
				$Client_insurance_policy_authorizations->client_authorizationsstartdate      	= date('Y-m-d',strtotime($Client->client_authorizationsstartdate));
				$Client_insurance_policy_authorizations->client_authorizationseenddate       	 = date('Y-m-d',strtotime($Client->client_authorizationseenddate));
				$Client_insurance_policy_authorizations->client_authorizationsaba 		      = $Client->client_authorizationsaba;
				$Client_insurance_policy_authorizations->client_authorizationssupervision 	  = $Client->client_authorizationssupervision;
				/*$Client_insurance_policy_authorizations->client_authorizationsparenttraining   = date('Y-m-d',strtotime($Client->client_authorizationsparenttraining));
				$Client_insurance_policy_authorizations->client_authorizationsreassessment   	 = date('Y-m-d',strtotime($Client->client_authorizationsreassessment));*/
				$Client_insurance_policy_authorizations->client_authorizationsparenttraining   = $Client->client_authorizationsparenttraining;
				$Client_insurance_policy_authorizations->client_authorizationsreassessment   	 = $Client->client_authorizationsreassessment;
				$Client_insurance_policy_authorizations->save();
			}
			
			//return redirect('/franchise/client/addinsurance/'.$client_id);
			$ClientInsurancePolicy = $Client_insurance_policy;
		}
		else
		{
			$ClientInsurancePolicy = $ClientInsurancePolicy->first();
		}
		$data['ClientInsurancePolicy'] = $ClientInsurancePolicy;
		$data['ClientInsurancePolicies'] = $ClientInsurancePolicies->where('client_id',$client_id)->orderby('client_insurance_primary','desc')->orderby('created_at','desc')->paginate(0);
		$data['ClientInsurancePolicyIDCards'] = Client_insurance_policy_idcards::where('client_insurance_id',$ClientInsurancePolicy->id)->orderby('created_at','desc')->paginate(0);
		$data['ClientInsurancePolicyAuthorizations'] = Client_insurance_policy_authorizations::where('client_insurance_id',$ClientInsurancePolicy->id)->where('isdelete',0)->orderby('created_at','desc')->paginate(0);
		//print_r($data['ClientInsurancePolicyAuthorizations']);exit();
		return view('franchise.clients.insurance.viewInsurance',$data);
	}
	
	///////////////////
	//	Add Insurance
	///////////////////
	public function addInsurance(Request $request, $client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Add Insurance";
        $sub_title                      = "Add Insurance";
        $menu                           = "clients";
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

        $Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}
        
        $data['Client'] = Client::find($client_id);
		
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
		return view('franchise.clients.insurance.addInsurance',$data);
	}
	
	///////////////////
	//	Store Insurance
	///////////////////
	public function storeInsurance(Request $request, $client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Add Insurance";
        $sub_title                      = "Add Insurance";
        $menu                           = "clients";
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

        $Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}
		
		if($request->isMethod('post')){

			$client = Client::find($client_id);
			$client_insurance_policy = new Client_insurance_policy();
			$client_insurance_policy->client_id  	  					  = $client->id;
			$client_insurance_policy->client_insurancename 	  		   = $request->client_insurancename;
			$client_insurance_policy->client_insurancepayerid 	  	    = $request->client_insurancepayerid;
			//$client_insurance_policy->client_insurancecompanyname 	  	= $request->client_insurancecompanyname;
			$client_insurance_policy->client_insurancephone_number 	   = $request->client_insurancephone_number;
			$client_insurance_policy->client_memberid 				  	= $request->client_memberid;
			$client_insurance_policy->client_groupid 				   	 = $request->client_groupid;
			$client_insurance_policy->client_policyholdersname 		   = $request->client_policyholdersname;
			$client_insurance_policy->client_policyholdersdateofbirth  	= date('Y-m-d',strtotime($request->client_policyholdersdateofbirth));
			//$client_insurance_policy->client_subscribername 			= $request->client_subscribername;
			//$client_insurance_policy->client_subscriberdateofbirth  	= date('Y-m-d',strtotime($request->client_subscriberdateofbirth));
			//Benefits
			$client_insurance_policy->client_benefiteffectivedate     	= date('Y-m-d',strtotime($request->client_benefiteffectivedate));
			$client_insurance_policy->client_benefitexpirationdate       = date('Y-m-d',strtotime($request->client_benefitexpirationdate));
			$client_insurance_policy->client_benefitcopay 		     	= $request->copay_type.$request->client_benefitcopay;
			$client_insurance_policy->client_benefitoopm 		      	 = $request->client_benefitoopm;
			$client_insurance_policy->client_benefitannualbenefit     	= $request->benefit_type.$request->client_benefitannualbenefit;
			$client_insurance_policy->client_benefitclaimaddress      	 = $request->client_benefitclaimaddress;
			$client_insurance_policy->client_benefitdateverified      	 = date('Y-m-d',strtotime($request->client_benefitdateverified));
			$client_insurance_policy->client_benefitinsuranceemployee 	= $request->client_benefitinsuranceemployee;
			$client_insurance_policy->client_benefitreferencenumber      = $request->client_benefitreferencenumber;
			$client_insurance_policy->save();
			//Authorizations
			$client_insurance_policy_authorizations = new Client_insurance_policy_authorizations();
			$client_insurance_policy_authorizations->client_insurance_id           	       = $client_insurance_policy->id;
			$client_insurance_policy_authorizations->client_authorizationsstartdate      	= date('Y-m-d',strtotime($request->client_authorizationsstartdate));
			$client_insurance_policy_authorizations->client_authorizationseenddate       	 = date('Y-m-d',strtotime($request->client_authorizationseenddate));
			$client_insurance_policy_authorizations->client_authorizationsaba 		      = $request->client_authorizationsaba;
			$client_insurance_policy_authorizations->client_authorizationssupervision 	  = $request->client_authorizationssupervision;
			/*$client_insurance_policy_authorizations->client_authorizationsparenttraining   = date('Y-m-d',strtotime($request->client_authorizationsparenttraining));
			$client_insurance_policy_authorizations->client_authorizationsreassessment   	 = date('Y-m-d',strtotime($request->client_authorizationsreassessment));*/
			$client_insurance_policy_authorizations->client_authorizationsparenttraining   = $request->client_authorizationsparenttraining;
			$client_insurance_policy_authorizations->client_authorizationsreassessment   	 = $request->client_authorizationsreassessment;
			$client_insurance_policy_authorizations->save();
			
			if ($request->hasFile('client_insurancecompanyidcard')){
				$client_insurance_policy_idcards = new Client_insurance_policy_idcards();
				$client_insurance_policy_idcards->client_insurance_id  = $client_insurance_policy->id;
				$client_insurance_policy_idcards->save();
				
				if(!empty($client_insurance_policy_idcards->client_insurancecompanyidcard))
				{
					$exists = Storage::exists('public/admissionforms/insurance-company-id-card/'.basename($client_insurance_policy_idcards->client_insurancecompanyidcard));
					if($exists){
						Storage::delete('public/admissionforms/insurance-company-id-card/'.basename($client_insurance_policy_idcards->client_insurancecompanyidcard));
					}
				}
				//exit;
				$file = $request->file('client_insurancecompanyidcard');
				$customName = str_replace('.'.$file->getClientOriginalExtension(),'',$file->getClientOriginalName());
				$file_name = $customName.'_'.$client->id.'_'.$client_insurance_policy->id.'_'.$client_insurance_policy_idcards->id.'.'.$file->getClientOriginalExtension();

				$file_storage  = 'public/admissionforms/insurance-company-id-card';
				$put_data      = Storage::putFileAs($file_storage, $file, $file_name);
				$full_path     = Storage::url($put_data);
				$client_insurance_policy_idcards->client_insurancecompanyidcard = $full_path;
				$client_insurance_policy_idcards->client_insurancecompanyidcard_name = $customName;
				$client_insurance_policy_idcards->save();
			}
			//exit();

			Session::flash('Success','<div class="alert alert-success">Insurance successfully added</div>');
		}
		return redirect('/franchise/client/viewinsurance/'.$client_id);
	}
	
	///////////////////
	//	Edit Insurance
	///////////////////	
	//public function editInsurance(Request $request, $type, $client_id){
	public function editInsurance(Request $request, $type, $client_id, $client_insurance_id){	
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Insurance";
        $sub_title                      = "Edit Insurance";
        $menu                           = "clients";
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

        $Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}
		
		if($request->isMethod('post')){

			$client = Client::find($client_id);
			$client_insurance_policy = Client_insurance_policy::find($client_insurance_id);
			if($type == 'primarypolicy'){
				/*$client->client_insurancecompanyname 	  	= $request->client_insurancecompanyname;
				$client->client_memberid 				  	= $request->client_memberid;
				$client->client_groupid 				   	= $request->client_groupid;
				$client->client_policyholdersname 		 	= $request->client_policyholdersname;
				$client->client_policyholdersdateofbirth  	= date('Y-m-d',strtotime($request->client_policyholdersdateofbirth));*/
				/*$client->client_childfullname 				= $request->client_childfullname;
				$client->client_custodialparentsaddress 	= $request->client_custodialparentsaddress;
				$client->client_childdateofbirth 		  	= date('Y-m-d',strtotime($request->client_childdateofbirth));
				$client->save();*/
				/*$client->client_subscribername 				= $request->client_subscribername;
				$client->client_subscriberdateofbirth 	 	= date('Y-m-d',strtotime($request->client_subscriberdateofbirth));*/
				$client_insurance_policy->client_insurancename 	  	      = $request->client_insurancename;
				$client_insurance_policy->client_insurancepayerid 	  	   = $request->client_insurancepayerid;
				//$client_insurance_policy->client_insurancecompanyname 	   = $request->client_insurancecompanyname;
				$client_insurance_policy->client_insurancephone_number 	  = $request->client_insurancephone_number;
				$client_insurance_policy->client_memberid 				   = $request->client_memberid;
				$client_insurance_policy->client_groupid 				   	= $request->client_groupid;
				$client_insurance_policy->client_policyholdersname 		  = $request->client_policyholdersname;
				$client_insurance_policy->client_policyholdersdateofbirth   = date('Y-m-d',strtotime($request->client_policyholdersdateofbirth));
			}
			
			if($type == 'benefits'){
				/*$client->client_benefiteffectivedate     	= date('Y-m-d',strtotime($request->client_benefiteffectivedate));
				$client->client_benefitexpirationdate    	= date('Y-m-d',strtotime($request->client_benefitexpirationdate));
				$client->client_benefitcopay 		     	= $request->copay_type.$request->client_benefitcopay;
				$client->client_benefitoopm 		      	= $request->client_benefitoopm;
				$client->client_benefitannualbenefit     	= $request->benefit_type.$request->client_benefitannualbenefit;
				$client->client_benefitclaimaddress      	= $request->client_benefitclaimaddress;
				$client->client_benefitdateverified      	= date('Y-m-d',strtotime($request->client_benefitdateverified));
				$client->client_benefitinsuranceemployee 	= $request->client_benefitinsuranceemployee;
				$client->client_benefitreferencenumber   	= $request->client_benefitreferencenumber;*/
				$client_insurance_policy->client_benefiteffectivedate     	= date('Y-m-d',strtotime($request->client_benefiteffectivedate));
				$client_insurance_policy->client_benefitexpirationdate       = date('Y-m-d',strtotime($request->client_benefitexpirationdate));
				$client_insurance_policy->client_benefitcopay 		     	= $request->copay_type.$request->client_benefitcopay;
				$client_insurance_policy->client_benefitoopm 		      	 = $request->client_benefitoopm;
				$client_insurance_policy->client_benefitannualbenefit     	= $request->benefit_type.$request->client_benefitannualbenefit;
				$client_insurance_policy->client_benefitclaimaddress      	 = $request->client_benefitclaimaddress;
				$client_insurance_policy->client_benefitdateverified      	 = date('Y-m-d',strtotime($request->client_benefitdateverified));
				$client_insurance_policy->client_benefitinsuranceemployee 	= $request->client_benefitinsuranceemployee;
				$client_insurance_policy->client_benefitreferencenumber   	  = $request->client_benefitreferencenumber;
			}
			
			/*if($type == 'authorizations'){
				$client->client_authorizationsstartdate      	= date('Y-m-d',strtotime($request->client_authorizationsstartdate));
				$client->client_authorizationseenddate       	= date('Y-m-d',strtotime($request->client_authorizationseenddate));
				$client->client_authorizationsaba 		    	= $request->client_authorizationsaba;
				$client->client_authorizationssupervision 		= $request->client_authorizationssupervision;
				$client->client_authorizationsparenttraining 	= date('Y-m-d',strtotime($request->client_authorizationsparenttraining));
				$client->client_authorizationsreassessment   	= date('Y-m-d',strtotime($request->client_authorizationsreassessment));
			}*/
			
			/*if($type == 'uploadinsurancecompanyidcard'){
				if ($request->hasFile('client_insurancecompanyidcard')){

					
					if(!empty($client->client_insurancecompanyidcard))
					{
						$exists = Storage::exists('public/admissionforms/insurance-company-id-card/'.basename($client->client_insurancecompanyidcard));
						if($exists){
							Storage::delete('public/admissionforms/insurance-company-id-card/'.basename($client->client_insurancecompanyidcard));
						}
					}
					//exit;
					$file = $request->file('client_insurancecompanyidcard');
					$customName 		= str_replace('.'.$file->getClientOriginalExtension(),'',$file->getClientOriginalName());
					$file_name 			= $customName.'_'.$client->id.'.'.$file->getClientOriginalExtension();

		            $file_storage  = 'public/admissionforms/insurance-company-id-card';
		            $put_data      = Storage::putFileAs($file_storage, $file, $file_name);
		            $full_path     = Storage::url($put_data);
		            $client->client_insurancecompanyidcard = $full_path;

					$client->save();
				}
				
				Session::flash('Success','<div class="alert alert-success">Insurance Company ID Card Uploaded successfully</div>');
				return redirect('/franchise/client/viewinsurance/'.$client_id);
				exit();
			}
			
			if($type == 'deleteinsurancecompanyidcard'){
				if(!empty($client->client_insurancecompanyidcard))
				{
					$exists = Storage::exists('public/admissionforms/insurance-company-id-card/'.basename($client->client_insurancecompanyidcard));
					if($exists){
						Storage::delete('public/admissionforms/insurance-company-id-card/'.basename($client->client_insurancecompanyidcard));
					}
					$client->client_insurancecompanyidcard = null;
					$client->save();
				}
				Session::flash('Success','<div class="alert alert-success">Insurance Company ID Card Deleted successfully</div>');
				return redirect('/franchise/client/viewinsurance/'.$client_id);
				exit();
			}*/
			
			//$client->save();
			$client_insurance_policy->save();
			//exit();

			Session::flash('Success','<div class="alert alert-success">Insurance successfully updated</div>');
			return redirect('/franchise/client/viewinsurance/'.$client_id.'/'.$client_insurance_id);

		}
        
        $data['Client'] = Client::find($client_id);
		$data['ClientInsurancePolicy'] = Client_insurance_policy::find($client_insurance_id);
		
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
		$data['type'] = $type;
		return view('franchise.clients.insurance.editInsurance',$data);
	}
	
	///////////////////
	//	Set as Primary
	///////////////////	
	public function setInsurance(Request $request, $client_id, $client_insurance_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Insurance";
        $sub_title                      = "Edit Insurance";
        $menu                           = "clients";
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

        $Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}
	
        if(!empty($client_insurance_id)){
			Client_insurance_policy::where('client_id',$Client->id)->where('client_insurance_primary',1)->update(['client_insurance_primary' => 0]);
			Client_insurance_policy::where('client_id',$Client->id)->where('id',$client_insurance_id)->where('client_insurance_primary',0)->update(['client_insurance_primary' => 1]);
			Session::flash('Success','<div class="alert alert-success">Insurance successfully updated</div>');	
		}
		return redirect('/franchise/client/viewinsurance/'.$Client->id);
	}

	/////////////////////
	//	Add Authorization
	/////////////////////
	public function addAuthorization(Request $request, $client_id, $client_insurance_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Add Authorization";
        $sub_title                      = "Add Authorization";
        $menu                           = "clients";
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

        $Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}
        
        $data['Client'] = Client::find($client_id);
		
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
		
		$data['ClientInsurancePolicy'] = Client_insurance_policy::find($client_insurance_id);
		
		return view('franchise.clients.insurance.addAuthorization',$data);
	}
	
	///////////////////////
	//	Store Authorization
	///////////////////////
	public function storeAuthorization(Request $request, $client_id, $client_insurance_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Add Authorization";
        $sub_title                      = "Add Authorization";
        $menu                           = "clients";
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

        $Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}
		
		$Client_insurance_policy = Client_insurance_policy::find($client_insurance_id);
		if(!$Client_insurance_policy){
			return redirect('franchise/client/viewinsurance/'.$client_id);
		}
		
		if($request->isMethod('post')){
			Client_insurance_policy_authorizations::where('client_insurance_id',$client_insurance_id)->where('isactive',1)->update(['isactive' => 0]);
			
			//Authorizations
			$client_insurance_policy_authorizations = new Client_insurance_policy_authorizations();
			$client_insurance_policy_authorizations->isactive           	       			  = 1;
			$client_insurance_policy_authorizations->client_insurance_id           	       = $client_insurance_id;
			$client_insurance_policy_authorizations->client_authorizationsstartdate      	= date('Y-m-d',strtotime($request->client_authorizationsstartdate));
			$client_insurance_policy_authorizations->client_authorizationseenddate       	 = date('Y-m-d',strtotime($request->client_authorizationseenddate));
			$client_insurance_policy_authorizations->client_authorizationsaba 		      = $request->client_authorizationsaba;
			$client_insurance_policy_authorizations->client_authorizationssupervision 	  = $request->client_authorizationssupervision;
			/*$client_insurance_policy_authorizations->client_authorizationsparenttraining   = date('Y-m-d',strtotime($request->client_authorizationsparenttraining));
			$client_insurance_policy_authorizations->client_authorizationsreassessment   	 = date('Y-m-d',strtotime($request->client_authorizationsreassessment));*/
			$client_insurance_policy_authorizations->client_authorizationsparenttraining   = $request->client_authorizationsparenttraining;
			$client_insurance_policy_authorizations->client_authorizationsreassessment   	 = $request->client_authorizationsreassessment;
			$client_insurance_policy_authorizations->save();

			Session::flash('Success','<div class="alert alert-success">Authorization successfully added</div>');
		}
		return redirect('/franchise/client/viewinsurance/'.$client_id.'/'.$client_insurance_id);
	}
	
	//////////////////////
	//	Edit Authorization
	//////////////////////	
	public function editAuthorization(Request $request, $client_id, $client_insurance_id,$client_insurance_authorization_id){	
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Authorization";
        $sub_title                      = "Edit Authorization";
        $menu                           = "clients";
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

        $Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}
		
		$Client_insurance_policy = Client_insurance_policy::find($client_insurance_id);
		if(!$Client_insurance_policy){
			return redirect('franchise/client/viewinsurance/'.$client_id);
		}
		
		$Client_insurance_policy_authorizations = Client_insurance_policy_authorizations::find($client_insurance_authorization_id);
		if(!$Client_insurance_policy_authorizations){
			return redirect('franchise/client/viewinsurance/'.$client_id.'/'.$client_insurance_id);
		}
		
		if($request->isMethod('post')){

			$client_insurance_policy_authorization = Client_insurance_policy_authorizations::find($client_insurance_authorization_id);
			$client_insurance_policy_authorization->client_authorizationsstartdate      	= date('Y-m-d',strtotime($request->client_authorizationsstartdate));
			$client_insurance_policy_authorization->client_authorizationseenddate       	= date('Y-m-d',strtotime($request->client_authorizationseenddate));
			$client_insurance_policy_authorization->client_authorizationsaba 		    	= $request->client_authorizationsaba;
			$client_insurance_policy_authorization->client_authorizationssupervision 		= $request->client_authorizationssupervision;
			/*$client_insurance_policy_authorization->client_authorizationsparenttraining 	= date('Y-m-d',strtotime($request->client_authorizationsparenttraining));
			$client_insurance_policy_authorization->client_authorizationsreassessment   	= date('Y-m-d',strtotime($request->client_authorizationsreassessment));*/
			$client_insurance_policy_authorization->client_authorizationsparenttraining 	= $request->client_authorizationsparenttraining;
			$client_insurance_policy_authorization->client_authorizationsreassessment   	= $request->client_authorizationsreassessment;
			$client_insurance_policy_authorization->save();

			Session::flash('Success','<div class="alert alert-success">Authorization successfully updated</div>');
			return redirect('/franchise/client/viewinsurance/'.$client_id.'/'.$client_insurance_id);

		}
        
        $data['Client'] = $Client;
		$data['ClientInsurancePolicy'] = $Client_insurance_policy;
		$data['ClientInsurancePolicyAuthorization'] = $Client_insurance_policy_authorizations;
		
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
		
		return view('franchise.clients.insurance.editAuthorization',$data);
	}
	
	/////////////////////////
	//	Archive Authorization
	/////////////////////////	
	public function archiveAuthorization(Request $request, $client_id, $client_insurance_id,$client_insurance_authorization_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Authorization";
        $sub_title                      = "Edit Authorization";
        $menu                           = "clients";
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

        $Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}
		
		$Client_insurance_policy = Client_insurance_policy::find($client_insurance_id);
		if(!$Client_insurance_policy){
			return redirect('franchise/client/viewinsurance/'.$client_id);
		}
		
		$Client_insurance_policy_authorizations = Client_insurance_policy_authorizations::find($client_insurance_authorization_id);
		if(!$Client_insurance_policy_authorizations){
			return redirect('franchise/client/viewinsurance/'.$client_id.'/'.$client_insurance_id);
		}
		else
		{
			$Client_insurance_policy_authorizations->archive   	= 1;
			$Client_insurance_policy_authorizations->save();

			Session::flash('Success','<div class="alert alert-success">Authorization successfully activate</div>');
			return redirect('/franchise/client/viewinsurance/'.$client_id.'/'.$client_insurance_id);
		}
	}
	
	////////////////////////////
	//	UN-Archive Authorization
	////////////////////////////	
	public function unarchiveAuthorization(Request $request, $client_id, $client_insurance_id,$client_insurance_authorization_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Authorization";
        $sub_title                      = "Edit Authorization";
        $menu                           = "clients";
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

        $Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}
		
		$Client_insurance_policy = Client_insurance_policy::find($client_insurance_id);
		if(!$Client_insurance_policy){
			return redirect('franchise/client/viewinsurance/'.$client_id);
		}
		
		$Client_insurance_policy_authorizations = Client_insurance_policy_authorizations::find($client_insurance_authorization_id);
		if(!$Client_insurance_policy_authorizations){
			return redirect('franchise/client/viewinsurance/'.$client_id.'/'.$client_insurance_id);
		}
		else
		{
			$Client_insurance_policy_authorizations->archive   	= 0;
			$Client_insurance_policy_authorizations->save();

			Session::flash('Success','<div class="alert alert-success">Authorization successfully activate</div>');
			return redirect('/franchise/client/viewinsurance/'.$client_id.'/'.$client_insurance_id);
		}
	}
	
	////////////////////////////
	//	Trash Authorization
	////////////////////////////	
	public function trashAuthorization(Request $request, $client_id, $client_insurance_id,$client_insurance_authorization_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Authorization";
        $sub_title                      = "Edit Authorization";
        $menu                           = "clients";
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

        $Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}
		
		$Client_insurance_policy = Client_insurance_policy::find($client_insurance_id);
		if(!$Client_insurance_policy){
			return redirect('franchise/client/viewinsurance/'.$client_id);
		}
		
		$Client_insurance_policy_authorizations = Client_insurance_policy_authorizations::find($client_insurance_authorization_id);
		if(!$Client_insurance_policy_authorizations){
			return redirect('franchise/client/viewinsurance/'.$client_id.'/'.$client_insurance_id);
		}
		else
		{
			$Client_insurance_policy_authorizations->isdelete   	= 1;
			$Client_insurance_policy_authorizations->save();

			Session::flash('Success','<div class="alert alert-success">Authorization successfully deleted</div>');
			return redirect('/franchise/client/viewinsurance/'.$client_id.'/'.$client_insurance_id);
		}
	}
	
	////////////////////////////
	//	Upload Insurance ID Card
	////////////////////////////	
	public function uploadInsuranceIDCard(Request $request, $client_id, $client_insurance_id){
        $Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}
		
		$Client_insurance_policy = Client_insurance_policy::find($client_insurance_id);
		if(!$Client_insurance_policy){
			return redirect('franchise/client/viewinsurance/'.$client_id);
		}
		
		$client_insurancepolicycard_id = $request->input('client_insurancepolicycard_id');
		$Client_insurance_policy_idcards = Client_insurance_policy_idcards::find($client_insurancepolicycard_id);
		if(empty($client_insurancepolicycard_id) && !$Client_insurance_policy_idcards){
			$Client_insurance_policy_idcards = new Client_insurance_policy_idcards();
			$Client_insurance_policy_idcards->client_insurance_id  = $client_insurance_id;
			$Client_insurance_policy_idcards->save();
		}
		else
		{
			$exists = Storage::exists('public/admissionforms/insurance-company-id-card/'.basename($Client_insurance_policy_idcards->client_insurancecompanyidcard));
			if($exists){
				Storage::delete('public/admissionforms/insurance-company-id-card/'.basename($Client_insurance_policy_idcards->client_insurancecompanyidcard));
			}
		}
		
		if ($request->hasFile('client_insurancecompanyidcard')){
				
			$file = $request->file('client_insurancecompanyidcard');
			$customName = str_replace('.'.$file->getClientOriginalExtension(),'',$file->getClientOriginalName());
			$file_name = $customName.'_'.$Client->id.'_'.$Client_insurance_policy->id.'_'.$Client_insurance_policy_idcards->id.'.'.$file->getClientOriginalExtension();
  
			$file_storage  = 'public/admissionforms/insurance-company-id-card';
			$put_data = Storage::putFileAs($file_storage, $file, $file_name);
			$full_path = Storage::url($put_data);
			$Client_insurance_policy_idcards->client_insurancecompanyidcard = $full_path;
			$Client_insurance_policy_idcards->client_insurancecompanyidcard_name = $customName;
			$Client_insurance_policy_idcards->save();
  
			Session::flash('Success','<div class="alert alert-success">Insurance card successfully uploaded</div>');
		}
		return redirect('/franchise/client/viewinsurance/'.$client_id.'/'.$client_insurance_id);
	}
	
	////////////////////////////
	//	Delete Insurance ID Card
	////////////////////////////	
	public function deleteInsuranceIDCard(Request $request, $client_id, $client_insurance_id, $client_insurancepolicycard_id){
        $Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}
		
		$Client_insurance_policy = Client_insurance_policy::find($client_insurance_id);
		if(!$Client_insurance_policy){
			return redirect('franchise/client/viewinsurance/'.$client_id);
		}
		
		$Client_insurance_policy_idcards = Client_insurance_policy_idcards::find($client_insurancepolicycard_id);
		if($Client_insurance_policy_idcards){
			$exists = Storage::exists('public/admissionforms/insurance-company-id-card/'.basename($Client_insurance_policy_idcards->client_insurancecompanyidcard));
			if($exists){
				Storage::delete('public/admissionforms/insurance-company-id-card/'.basename($Client_insurance_policy_idcards->client_insurancecompanyidcard));
			}
			
			$Client_insurance_policy_idcards->delete();
			Session::flash('Success','<div class="alert alert-success">Insurance card successfully deleted</div>');
		}
		
		return redirect('/franchise/client/viewinsurance/'.$client_id.'/'.$client_insurance_id);
	}
	
	//////////////////////////////
	//	Download Insurance ID Card
	//////////////////////////////	
	/*public function downloadidcard($client_id){
		$Client = Client::find($client_id);
        if(!$Client){
			return redirect('franchise/clients');
		}

        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't delete tasks of other franchises clients.";exit;
		}
		
		return Storage::download('public/admissionforms/insurance-company-id-card/'.basename($Client->client_insurancecompanyidcard));
	}*/
	public function downloadInsuranceIDCard($client_id, $client_insurance_id, $client_insurancepolicycard_id){
		$Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}
		
		$Client_insurance_policy = Client_insurance_policy::find($client_insurance_id);
		if(!$Client_insurance_policy){
			return redirect('franchise/client/viewinsurance/'.$client_id);
		}
		
		$Client_insurance_policy_idcards = Client_insurance_policy_idcards::find($client_insurancepolicycard_id);
		if($Client_insurance_policy_idcards){
			return Storage::download('public/admissionforms/insurance-company-id-card/'.basename($Client_insurance_policy_idcards->client_insurancecompanyidcard));
		}
	}
	
	/////////////////
	// View Medical Information
	/////////////////
	public function viewMedicalInformation(Request $request, $client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Clients";
        $sub_title                      = "Clients";
        $menu                           = "clients";
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
        if(!$client_id) return redirect('franchise/clients');
        
        $Client = Client::find($client_id);
        
        if(!$Client) return redirect('franchise/clients');
		
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't view other franchises clients medical information.";exit;
		}
		
        $data['Client'] = $Client;
		
		$franchise_id = Auth::guard('franchise')->user()->franchise_id;
		$getClients = Client::where('franchise_id',$franchise_id) ->orderby('created_at','desc')->paginate(0);
		$data['clients'] = array();
		if($getClients){
			foreach($getClients as $client){
				$data['clients'][] = $client;
			}
		}
		
		$data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(0);
		
		return view('franchise.clients.medical_information.viewMedicalInformation',$data);
	}
	
	/////////////////////
	//	Add ABA History
	/////////////////////
	public function addABAHistory(Request $request, $client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Add ABA History";
        $sub_title                      = "Add ABA History";
        $menu                           = "clients";
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

        $Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}
        
        $data['Client'] = $Client;
		
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
		
		return view('franchise.clients.medical_information.addABAHistory',$data);
	}
	
	///////////////////////
	//	Store ABA History
	///////////////////////
	public function storeABAHistory(Request $request, $client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Add ABA History";
        $sub_title                      = "Add ABA History";
        $menu                           = "clients";
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

        $Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}
		
		if($request->isMethod('post')){
			
			if($Client->client_aba == "Yes" && $Client->client_aba_facilities != "")
			$client_aba_facilities = unserialize($Client->client_aba_facilities);
			
			$client_aba_facility['client_facility'] = $request->client_aba_facility;
			$client_aba_facility['client_start'] = $request->client_aba_start;
			$client_aba_facility['client_end'] = $request->client_aba_end;
			$client_aba_facility['client_hours'] = $request->client_aba_hours;
			$client_aba_facilities[] = $client_aba_facility;
			$Client->client_aba_facilities = serialize($client_aba_facilities);
			$Client->save();

			Session::flash('Success','<div class="alert alert-success">ABA History successfully added</div>');
		}
		return redirect('/franchise/client/viewmedicalinformation/'.$client_id);
	}
	
	//////////////////////
	//	Edit ABA History
	//////////////////////	
	public function editABAHistory(Request $request, $client_id){	
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit ABA History";
        $sub_title                      = "Edit ABA History";
        $menu                           = "clients";
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

        $Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}
		
		if($request->isMethod('post')){

			$Client->client_authorizationssupervision 		= $request->client_authorizationssupervision;
			$Client->save();

			Session::flash('Success','<div class="alert alert-success">Authorization successfully updated</div>');
			return redirect('/franchise/client/viewmedicalinformation/'.$client_id);

		}
        
        $data['Client'] = $Client;
		
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
		
		return view('franchise.clients.medical_information.editAuthorization',$data);
	}
	
	////////////////////////////
	//	Delete ABA History
	////////////////////////////	
	public function deleteABAHistory(Request $request, $client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Delete ABA History";
        $sub_title                      = "Delete ABA History";
        $menu                           = "clients";
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

        $Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients insurance.";exit;
		}
		
		if(!$Client){
			return redirect('franchise/client/viewmedicalinformation/'.$client_id);
		}
		else
		{
			$Client->isdelete   	= 1;
			$Client->save();

			Session::flash('Success','<div class="alert alert-success">ABA History successfully deleted</div>');
			return redirect('/franchise/client/viewmedicalinformation/'.$client_id);
		}
	}
	
	/////////////////
	// Edit Medical Information
	/////////////////
	public function editMedicalInformation(Request $request, $client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Medical Information";
        $sub_title                      = "Edit Medical Information";
        $menu                           = "clients";
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
        if(!$client_id) return redirect('franchise/clients');
        
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('franchise/clients');
		}

        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit other franchises clients medical information.";exit;
		}
		
		if($request->isMethod('post')){

			$client = Client::find($client_id);
			$client->client_ageandsymtoms 	  		= $request->client_ageandsymtoms;
			$client->client_dateofautism  			 = date('Y-m-d',strtotime($request->client_dateofautism));
			$client->client_diagnosingdoctor 		 = $request->client_diagnosingdoctor;
			$client->client_primarydiagnosis 		 = $request->client_primarydiagnosis;
			$client->client_secondarydiagnosis 	   = $request->client_secondarydiagnosis;
			$client->client_childcurrentmedications  = $request->client_childcurrentmedications;
			$client->client_allergies 			    = $request->client_allergies;
			$client->client_aba 			          = $request->client_aba;
			if($request->client_aba == 'Yes'){
				$client_aba_array = array();
				foreach($request->client_aba_data as $aba){
					$client_aba_array[] = array(
						'client_facility' => $aba['client_facility'],
						'client_start' => $aba['client_start'],
						'client_end' => $aba['client_end'],
						'client_hours' => $aba['client_hours'],
					);
				}
				$client->client_aba_facilities = serialize($client_aba_array);
			}
			$client->client_speechtherapy 				= $request->client_speechtherapy;
			$client->client_speechinstitution 			= $request->client_speechinstitution;
			$client->client_speechhoursweek 		  	= $request->client_speechhoursweek;
			$client->client_occupationaltherapy 	  	= $request->client_occupationaltherapy;
			$client->client_occupationalinstitution  	= $request->client_occupationalinstitution;
			$client->client_occupationalhoursweek 		= $request->client_occupationalhoursweek;
			
			$client->client_childattendschool 	    	= $request->client_childattendschool;
			$client->client_schoolname 			   		= $request->client_schoolname;
			$client->client_specialclass 	         	= $request->client_specialclass;
			$client->client_medicalmedication 	    	= $request->client_medicalmedication;
			//$client->client_medicalabahistory 	    = $request->client_medicalabahistory;
			if($request->client_medicallastvisionexam)  $client->client_medicallastvisionexam 	= date('Y-m-d',strtotime($request->client_medicallastvisionexam));
			$client->client_medicalabahoursperweek   	= $request->client_medicalabahoursperweek;
			$client->client_medicaltoolused 	      	= $request->client_medicaltoolused;
			$client->client_medicalphonenumber 	   		= $request->client_medicalphonenumber;
			$client->client_medicalfaxnumber 	     	= $request->client_medicalfaxnumber;
			$client->client_medicaladdress 	       	= $request->client_medicaladdress;

			$client->save();

			Session::flash('Success','<div class="alert alert-success">Medical Information successfully updated</div>');
			return redirect('/franchise/client/viewmedicalinformation/'.$client_id);

		}

        $data['Client'] = $Client;
		
		$franchise_id = Auth::guard('franchise')->user()->franchise_id;
		$getClients = Client::where('franchise_id',$franchise_id) ->orderby('created_at','desc')->paginate(0);
		$data['clients'] = array();
		if($getClients){
			foreach($getClients as $client){
				$data['clients'][] = $client;
			}
		}
		
		return view('franchise.clients.medical_information.editMedicalInformation',$data);
	}

	/////////////////////////////////////////
	// Download Medical Information Documents
	/////////////////////////////////////////
	public function medicalInformationDocumentsDownload($client_id,$doc_id){
	    $client = Client::find($client_id);

	    //Checking if client is in current franchise
	    if($client->franchise_id != Auth::guard('franchise')->user()->franchise_id) {echo "You don't have permission to download other Franchises clients files"; exit;}
	    
	    if($client){
		    
		    $client_doc = Client_documents::find($doc_id);
		    if($client_doc->client_id != $client->id) {echo "You don't have permission to download other Franchises clients files"; exit;}
		    
		    if($client_doc){
				
				$doc = $client_doc;
		        
		        $directory = 'medical-report-other';
		        if($doc->document == 'Childs Dignostic') $directory = 'client-child-diagnostic-report';
		        if($doc->document == 'Childs IEP') $directory = 'client-child-iep';
				
				//echo $doc->document_file;exit;
				$filename = basename($doc->document_file);
				$filePath = 'public/admissionforms/'.$directory.'/'.$filename;
			
				$exists = Storage::exists($filePath);
				if($exists){
					$ext = pathinfo($doc->document_file, PATHINFO_EXTENSION);
					$headers = array('Content-Type: application/pdf',);
					return Storage::download($filePath,$doc->document_name.'.'.$ext, $headers);		
				}
				else
				{
					Session::flash('Success','<div class="alert alert-warning">Child document not found</div>');
					return redirect('/franchise/client/viewmedicalinformation/'.$client_id);
				}
			}
			else
			{
				Session::flash('Success','<div class="alert alert-warning">Child Document not found</div>');
				return redirect('/franchise/client/viewmedicalinformation/'.$client_id);
			}
		}
		else
		{
			return redirect('franchise/clients');
		}
		
	}
	
	///////////////////////////////////////
	// Delete Medical Information Documents
	///////////////////////////////////////
	public function medicalInformationDocumentsDelete(Request $request, $client_id, $doc_id){
	    $client = Client::find($client_id);

	    //Checking if client is in current franchise
	    if($client->franchise_id != Auth::guard('franchise')->user()->franchise_id) {echo "You don't have permission to delete other Franchises clients files"; exit;}

	    if($client){

		    $client_doc = Client_documents::find($doc_id);
		    if($client_doc->client_id != $client->id){ echo "You don't have permission to delete other Franchises clients files"; exit;}

			if($client_doc){
				
				$doc = $client_doc;
		        
		        $directory = 'medical-report-other';
		        if($doc->document == 'Childs Dignostic') $directory = 'client-child-diagnostic-report';
		        if($doc->document == 'Childs IEP') $directory = 'client-child-iep';
		        
				$filename = basename($doc->document_file);
				$filePath = 'public/admissionforms/'.$directory.'/'.$filename;

				$exists = Storage::exists($filePath);
				if($exists){
				  Storage::delete($filePath);
				}
				
				$type = $doc->archive;

				$doc->delete();
				Session::flash('Success','<div class="alert alert-success">Document Deleted successfully</div>');
				
				if($type){
					return redirect('/franchise/client/viewarchives/'.$client_id);
				}else{
					return redirect('/franchise/client/viewmedicalinformation/'.$client_id);
				}

				
			}
			else
			{
				Session::flash('Success','<div class="alert alert-warning">Child Document not found</div>');
				return redirect('/franchise/client/viewmedicalinformation/'.$client_id);
			}			
		}
		else
		{
			return redirect('franchise/clients');
		}
		
	}
	
	/////////////////////////////////////////
	// Archive Medical Information Documents
	/////////////////////////////////////////
	public function medicalInformationDocumentsArchive(Request $request, $client_id, $doc_id){
	    $client = Client::find($client_id);

	    //Checking if client is in current franchise
	    if($client->franchise_id != Auth::guard('franchise')->user()->franchise_id) {echo "You don't have permission to archive other Franchises clients files"; exit;}

	    if($client){

		    $client_doc = Client_documents::find($doc_id);
		    if($client_doc->client_id != $client->id){ echo "You don't have permission to archive other Franchises clients files"; exit;}

			if ($client_doc){
			  $client_doc->archive = 1;
			  $client_doc->save();
			}
			
			Session::flash('Success','<div class="alert alert-success">Document Archived successfully</div>');
			return redirect('/franchise/client/viewmedicalinformation/'.$client_id);
			exit();
		}
		else
		{
			return redirect('franchise/clients');
		}
		
	}
	
	////////////////////////////////////////
	// Active Medical Information Documents
	////////////////////////////////////////
	public function medicalInformationDocumentsActive(Request $request, $client_id, $doc_id){
	    $client = Client::find($client_id);
	    
	    //Checking if client is in current franchise
	    if($client->franchise_id != Auth::guard('franchise')->user()->franchise_id) {echo "You don't have permission to archive other Franchises clients files"; exit;}
	    
	    if($client){
			
			$client_archive = Client_documents::find($doc_id);
		    if($client_archive->client_id != $client->id){ echo "You don't have permission to archive other Franchises clients files"; exit;}

			if($client_archive){
			  $client_archive->archive = 0;
			  $client_archive->save();
			}
			Session::flash('Success','<div class="alert alert-success">Document Unarchived successfully</div>');
			return redirect('/franchise/client/viewarchives/'.$client_id);
			exit();
		}
		else
		{
			return redirect('franchise/clients');
		}
	}
	
	///////////////////
	//	Upload Reports
	public function uploadreport($client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Upload Reports";
        $sub_title                      = "Upload Reports";
        $menu                           = "clients";
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
        if(!$client_id) return redirect('franchise/clients');
        
        $Client = Client::find($client_id);
        
        if(!$Client) return redirect('franchise/clients');

        $data['client'] = $Client;

        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't upload report for other franchises clients.";exit;
		}

        
        return view('franchise.clients.medical_information.reportsUpload',$data);
	}

	///////////////////
	//	Store Reports
	///////////////////		
	public function storereport(Request $request, $client_id){

        $Client = Client::find($client_id);
        
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't upload report for other franchises clients.";exit;
		}
		
		$messages = [
		    'document_name.required' 	=> 'Document Name is required',
		    'document.required' 		=> 'Document is required',
		    //'document.mimes' 			=> 'Document type must be in docx or pdf file',
			'document.mimes' 			=> 'Document type must be in docx , pdf or image file',
		    'document.max' 				=> 'Document size must less than 8mb',
		];
		
		$validator = Validator::make($request->all(), [
		    'document_name' => 'required',
		    //'document' 		=> 'required|mimes:docx,pdf|max:8192',
			'document' 		=> 'required|mimes:docx,pdf,jpg,jpeg,png,JPG,JPEG,PNG|max:8192',
		], $messages);
		
		if ($validator->fails()) {
            return response()->json([ 'errors' => $validator->customMessages ]);
		}
		
		$doc = new Client_documents();
		$doc->client_id 		= $client_id;
		//$doc->document 			= $request->document_type;
		$doc->document_name 	= $request->document_name;
		
		if ($request->hasFile('document')){
			
			$count = 1;
	        $file = $request->file('document');
	        $directory = 'medical-report-other';
	        //if($request->document_type == 'Childs Dignostic') $directory = 'client-child-diagnostic-report';
	        //if($request->document_type == 'Childs IEP') $directory = 'client-child-iep';
	        
            $customName 		= str_replace('.'.$file->getClientOriginalExtension(),'',$file->getClientOriginalName());
            $file_name 			= $customName.'_'.time().'.'.$file->getClientOriginalExtension();
            $file_storage   	= 'public/admissionforms/'.$directory;

            $put_data               = Storage::putFileAs($file_storage, $request->file('document'), $file_name);
            $full_path              = Storage::url($put_data);
            $doc->document_file  	= $full_path;
    		
    		$doc->save();
    		
	 		Session::flash('Success','<div class="alert alert-success">Document Added Successfully</div>');
			return redirect('/franchise/client/viewmedicalinformation/'.$client_id);
    		
		}
				
	}
	
	/////////////////
	// View Archives
	/////////////////
	public function viewArchives(Request $request, $client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Clients";
        $sub_title                      = "Clients";
        $menu                           = "clients";
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
        if(!$client_id) return redirect('franchise/clients');
        
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('franchise/clients');
		}

        $data['Client'] = $Client;
		
		$franchise_id = Auth::guard('franchise')->user()->franchise_id;

        if($Client->franchise_id != $franchise_id){
			echo "You can't view other franchises clients archives.";exit;
		}
		
		$getClients = Client::where('franchise_id',$franchise_id) ->orderby('created_at','desc')->paginate(0);
		$data['clients'] = array();
		if($getClients){
			foreach($getClients as $client){
				$data['clients'][] = $client;
			}
		}
		
		$data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(30);
		
		return view('franchise.clients.archives.viewArchive',$data);
	}
	
	/////////////////
	// View Agreement
	/////////////////
	public function viewAgreement(Request $request, $client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Clients";
        $sub_title                      = "Clients";
        $menu                           = "clients";
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
        if(!$client_id) return redirect('franchise/clients');
        
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('franchise/clients');
		}

        $data['Client'] = $Client;
		
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't view other franchises clients agreement.";exit;
		}
		
		$getClients = Client::where('franchise_id',$franchise_id) ->orderby('created_at','desc')->paginate(0);
		$data['clients'] = array();
		if($getClients){
			foreach($getClients as $client){
				$data['clients'][] = $client;
			}
		}
		
		$data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(0);
		
		return view('franchise.clients.agreement.viewAgreement',$data);
	}
	
	/////////////////
	// Edit Agreement
	/////////////////
	public function editAgreement($client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Agreement";
        $sub_title                      = "Edit Agreement";
        $menu                           = "clients";
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
        if(!$client_id) return redirect('franchise/clients');
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('franchise/clients');
		}
		
		$franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't access another franchises clients Agreements";exit;
		}
		
        $data['Client'] = $Client;
		
		return view('franchise.clients.agreement.editAgreement',$data);
	}

	/////////////////
	// Edit Agreement
	/////////////////
	public function updateAgreement(Request $request, $client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Agreement";
        $sub_title                      = "Edit Agreement";
        $menu                           = "clients";
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
        if(!$client_id) return redirect('franchise/clients');
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('franchise/clients');
		}
		
		$franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't upload for another franchises clients Agreements";exit;
		}
		
		$Client->agreement_hippa 		= $request->agreement_hippa;
		$Client->hipaa_date 			= ($request->agreement_hippa == '1') ? date('Y-m-d', strtotime($request->hipaa_date)) : '0000-00-00';
		
		$Client->agreement_payment 		= $request->agreement_payment;
		$Client->payment_parentsdate 	= ($request->agreement_payment == '1') ? date('Y-m-d', strtotime($request->payment_date)) : '0000-00-00';
		
		$Client->agreement_informed 	= $request->agreement_informed;
		$Client->informed_date 			= ($request->agreement_informed == '1') ? date('Y-m-d', strtotime($request->informed_date)) : '0000-00-00';
		
		$Client->agreement_security 	= $request->agreement_security;
		$Client->security_date 			= ($request->agreement_security == '1') ? date('Y-m-d', strtotime($request->security_date)) : '0000-00-00';
		
		$Client->agreement_release 		= $request->agreement_release;
		$Client->release_date 			= ($request->agreement_release == '1') ? date('Y-m-d', strtotime($request->release_date)) : '0000-00-00';
		
		$Client->agreement_parent 		= $request->agreement_parent;
		$Client->parent_date 			= ($request->agreement_parent == '1') ? date('Y-m-d', strtotime($request->parent_date)) : '0000-00-00';
		$Client->save();
		
        $data['Client'] = $Client;
		
		Session::flash('Success','<div class="alert alert-success">Agreement Updated successfully</div>');
		return redirect('franchise/client/viewagreement/'.$Client->id);
	}

	///////////////////
	// Add Task list
	//////////////////
	public function addtasklist(Request $request, $client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Add Task list";
        $sub_title                      = "Add Task list";
        $menu                           = "clients";
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
        
        $Client = Client::find($client_id);
        
        if(!$Client) return redirect('franchise/clients');

        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't add task for other franchises clients.";exit;
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

			$tasks = Client_tasklist::where('client_id', $client_id)->orderby('sort','asc')->get();
			if(!$tasks->isEmpty()){
				$sort = 1;
				foreach($tasks as $getTask){
					$U_task = Client_tasklist::find($getTask->id);
					$U_task->sort = $sort;
					$U_task->save();
					$sort++;
				}
			}
			
			if(!empty($request->task)){
				foreach($request->task as $task){
					if($task == '') continue;

					$eTask = new Client_tasklist();
					$eTask->task = $task;
					$eTask->client_id = $client_id;
					$eTask->status = 'Incomplete';
					$eTask->save();

				}
			}
			
			Session::flash('Success','<div class="alert alert-success">Task added successfully.</div>');
			return redirect('franchise/client/viewtasklist/'.$client_id);
		}

		$franchise_id = Auth::guard('franchise')->user()->franchise_id;
		$getClients = Client::where('franchise_id',$franchise_id) ->orderby('created_at','desc')->paginate(0);
		$data['clients'] = array();
		if($getClients){
			foreach($getClients as $client){
				$data['clients'][] = $client;
			}
		}
		
		$data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(0);
		
        $data['Client'] = $Client;

		return view('franchise.clients.tasklist.addTask',$data);
	}

	/////////////////
	// VIEW TASKLIST
	////////////////
	public function viewTasklist($client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Clients Task List";
        $sub_title                      = "Clients Task List";
        $menu                           = "clients";
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

        if(!$client_id) return redirect('franchise/clients');
        
        $Client = Client::find($client_id);
        
        if(!$Client) return redirect('franchise/clients'); 
        
		$data['Client'] = $Client;

        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't view task list of other franchises clients.";exit;
		}
		
		$getClients = Client::where('franchise_id',$franchise_id) ->orderby('created_at','desc')->paginate(0);
		$data['clients'] = array();
		if($getClients){
			foreach($getClients as $client){
				$data['clients'][] = $client;
			}
		}
		
		$data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(0);
		
		$task_groups = DB::select("SHOW COLUMNS FROM sos_parent_tasklist LIKE 'group'");
		if ($task_groups) {
			$data['task_groups'] = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $task_groups[0]->Type));
		}
		
		//return view('franchise.clients.tasklist.viewTasklist',$data);
		return view('franchise.clients.tasklist.editTask',$data);
	}
	
	///////////////////
	// Edit Task list
	//////////////////
	public function edittasklist(Request $request, $client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Task list";
        $sub_title                      = "Edit Task list";
        $menu                           = "clients";
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
        
        $Client = Client::find($client_id);
        
        if(!$Client) return redirect('franchise/clients');

        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't edit task list franchises clients.";exit;
		}
		
		/*if($request->isMethod('post')){

			if(!empty($request->task)){
				foreach($request->task as $task){
					Client_tasklist::where('client_id',$Client->id)->where('id',$task['task_id'])
					->update(['sort' => $task['sort'], 'task' => $task['task_description'], 'status' => $task['status'] ]);
				}
			}
			
			Session::flash('Success','<div class="alert alert-success">Task list updated successfully.</div>');
			return redirect('franchise/client/viewtasklist/'.$Client->id);
		}*/
		if($request->isMethod('post')){

			if(!empty($request->task)){
				foreach($request->task as $task){
					Client_tasklist::where('client_id',$Client->id)->where('id',$task['task_id'])
					->update(['sort' => $task['sort'], 'task' => $task['task_description'], 'status' => $task['status'], 'group' => $task['group'] ]);
				}
			}
			
			Session::flash('Success','<div class="alert alert-success">Task list updated successfully.</div>');
			return redirect('franchise/client/viewtasklist/'.$Client->id);
		}
        $data['Client'] = $Client;

		$getClients = Client::where('franchise_id',$franchise_id) ->orderby('created_at','desc')->paginate(0);
		$data['clients'] = array();
		if($getClients){
			foreach($getClients as $client){
				$data['clients'][] = $client;
			}
		}
		
		$data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(0);

		return view('franchise.clients.tasklist.editTask',$data);
	}	

	/////////////////
	//	DELETE TASK
	/////////////////
	public function deletetask($client_id, $task_id){

		$Client = Client::find($client_id);
        if(!$Client){
			return redirect('franchise/clients');
		}


        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't delete tasks of other franchises clients.";exit;
		}
				
		$C_task = Client_tasklist::where('client_id',$client_id)->where('id',$task_id);
		if(!$C_task) return redirect('franchise/clients');
		$C_task->delete();
		
		Session::flash('Success','<div class="alert alert-success">Task deleted successfully.</div>');
		return redirect('franchise/client/edittasklist/'.$client_id);
		
	}
	
	////////////////
	//TRIP ITINERARY
	////////////////
	public function viewTripitinerary($client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Client";
        $sub_title                      = "Client";
        $menu                           = "client";
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

        if(!$client_id) return redirect('franchise/clients');
        
        $Client = Client::find($client_id);
        
        if(!$Client){ return redirect('franchise/clients'); }
		
        if(Auth::guard('franchise')->user()->franchise_id != $Client->franchise_id){ return redirect('franchise/clients'); }

        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't view task list of other franchises clients.";exit;
		}
		
		$days = array( "monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday");

        $client_schedules_data    = array();
        $client_schedules         = $Client->schedules;
        $complete_hours             = 0;

        foreach($days as $day)
        {

			$time_in        = isset($client_schedules->{$day.'_time_in'}) ? date("g:i A", strtotime($client_schedules->{$day.'_time_in'}) ) : "-";
            $time_out       = isset($client_schedules->{$day.'_time_out'}) ? date("g:i A", strtotime($client_schedules->{$day.'_time_out'}) ) : "-";
            $total_hours    = "-";

            if($time_in != "" && $time_out != "")
            {
                $time1          = strtotime($time_in);
                $time2          = strtotime($time_out);
                $difference     = round(abs($time2 - $time1) / 3600,2);
                $total_hours    = ($difference) ? $difference : "-";
            }

            $client_schedules_data[] = array(
                "day"           =>  ucfirst($day),
                "time_in"       =>  $time_in,
                "time_out"      =>  $time_out,
                "total_hours"   =>  $total_hours
            );

            if($total_hours != "-") $complete_hours = $complete_hours + $total_hours;
        }
        
		$data['Client'] = $Client;
        $data['Client_schedule']      = $client_schedules_data;
        $data['Client_schedule_hours']= $complete_hours;
		
		$getClients = Client::where('franchise_id',$franchise_id) ->orderby('created_at','desc')->paginate(0);
		$data['clients'] = array();
		if($getClients){
			foreach($getClients as $client){
				$data['clients'][] = $client;
			}
		}
		
		$data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(0);
		
		return view('franchise.clients.tripitinerary.viewTripitinerary',$data);
	}

    public function tripitenaryupdate(Request $request, $id){
        $days = array(
            "monday",
            "tuesday",
            "wednesday",
            "thursday",
            "friday",
            "saturday",
            "sunday",
        );
		
        $tripitenary = Client_schedules::findOrNew($id);
		if(!$tripitenary->exists)$tripitenary->client_id = $request->client_id;
		
        foreach($days as $day)
        {
            if( $request->{$day.'_time_in'})  $tripitenary->{$day.'_time_in'} = date("H:i:s",strtotime( $request->{$day.'_time_in'}));
            else $tripitenary->{$day.'_time_in'} = NULL;

            if( $request->{$day.'_time_out'})  $tripitenary->{$day.'_time_out'} = date("H:i:s",strtotime( $request->{$day.'_time_out'}));
            else $tripitenary->{$day.'_time_out'} = NULL;
        }
        $tripitenary->save();

        Session::flash('Success','<div class="alert alert-success">Trip Itenary updated successfully.</div>');
        return redirect('franchise/client/viewtripitinerary/'.$request->client_id);
    }

	/////////////////
	//Invite Client
	/////////////////
	public function inviteClient(REQUEST $request, $client_id){
		$Client = Client::find($client_id);
		$franchise_id = Auth::guard('franchise')->user()->franchise_id;
		if($Client->franchise_id != $franchise_id){
			echo "You can't access another franchise of Client";exit;
		}
		
		$Client->email 	= $request->login_email;
		$Client->password = bcrypt($request->client_password);
		$Client->save();
		
        $data = array( "name" => $Client->client_childfullname, "email" => $Client->email, "password" => $request->client_password);
        \Mail::send('email.invite_email', ["name" => $data['name'], "email" => $data['email'], "password" => $data['password'], "link"=>url('client/login')], function ($message) use ($data) {
            $message->from('sos@testing.com', 'SOS');
            $message->to($data['email'])->subject("INVITATION OF SOS");
        });
        
		Session::flash('Success','<div class="alert alert-success">Invitation successfully sent to Client.</div>');
		return redirect('/franchise/client/edit/'.$client_id);
		
	}
    
}
