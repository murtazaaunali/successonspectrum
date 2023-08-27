<?php
namespace App\Http\Controllers\Parent;

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
use App\Models\Franchise\Client_tasklist;
use App\Models\Franchise\Client_documents;

class ClientController extends Controller
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

        $client_id = Auth::guard('parent')->user()->id;

        //If ID IS NULL THEN REDIRECT
        if(!$client_id) return redirect('parent/dashboard');
        
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('parent/dashboard');
		}
		
        $data['Client'] = $Client;
		
		/*$getClients = Client::where('franchise_id',$franchise_id) ->orderby('created_at','desc')->paginate(0);
		$data['clients'] = array();
		if($getClients){
			foreach($getClients as $client){
				$data['clients'][] = $client;
			}
		}*/
		
		$data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(0);
		
		return view('parent.client.view',$data);
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
		
		$client_id = Auth::guard('parent')->user()->id;

        //If ID IS NULL THEN REDIRECT
        if(!$client_id) return redirect('parent/login');
		
        $client = Client::find($client_id);
		
		if(!$client){
			return redirect('parent/dashboard');
		}

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "client"                                => $client,
        );

        return view('parent.profile.edit',$data);
    }
	
	///////////////////
	//	Store Profile
	///////////////////	
	public function storeProfile(Request $request)
    {
        $client = Client::find($request->id);
		if(!$client){
			return redirect('parent/dashboard');
		}
        $client->client_childfullname   = $request->client_childfullname;
        $client->email                  = $request->email;
        if($request->password != "") $client->password = bcrypt($request->password);

        if($request->profile_picture)
        {
            $file_storage   = 'public/parent/'.Auth::guard('parent')->user()->id;

            $exists = Storage::exists($client->client_profilepicture);

            if($exists)
            {
                Storage::delete($client->client_profilepicture);
            }

            $put_data               = Storage::put($file_storage, $request->profile_picture);
            $full_path              = Storage::url($put_data);
            $client->client_profilepicture  = $full_path;

            //To Rename the File uncomment below code.
            //Storage::rename($put_data,$file_storage.'/img.png');
        }

        $client->save();

        Session::flash('Success','<div class="alert alert-success">Profile updated successfully!</div>');
        //return redirect(route('parent.home'));
		return redirect('parent/edit_profile');
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
        //If ID IS NULL THEN REDIRECT
        if(!$client_id) return redirect('parent/dashboard');
        
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('parent/dashboard');
		}
		
        $data['Client'] = $Client;
        
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
			$client->email           				   	= $request->client_email;
			if($request->client_password) $client->password    = bcrypt($request->client_password);
			
			$client->save();

			Session::flash('Success','<div class="alert alert-success">Client successfully updated</div>');
			return redirect('/parent/client/view/');

		}
        
		
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
		
		$getFemployees = Femployee::when('Active', function ($query, $status) {
            return $query->where('personal_status', $status);
        })
		->orderby('created_at','desc')->paginate(0);
		$data['femployees'] = array();
		if($getFemployees){
			foreach($getFemployees as $femployee){
				$data['femployees'][] = $femployee;
			}
		}
		
		return view('parent.client.editClient',$data);
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
	
	
	/////////////////
	// View Insurance
	/////////////////
	public function viewInsurance(){
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

        //If ID IS NULL THEN REDIRECT
		$client_id = Auth::guard('parent')->user()->id;
        if(!$client_id) return redirect('parent/dashboard');
        
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('parent/dashboard');
		}

         $data['Client'] = $Client;
		
		$data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(0);
		
		return view('parent.client.insurance.viewInsurance',$data);
	}

	public function uploadreport($client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Upload Reports";
        $sub_title                      = "Upload Reports";
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

        //If ID IS NULL THEN REDIRECT
        if(!$client_id) return redirect('parent/dashboard');
        
        $Client = Client::find($client_id);
        
        if(!$Client) return redirect('parent/dashboard');

        $data['Client'] = $Client;

        return view('parent.client.medical_information.reportsUpload',$data);
	}

	///////////////////
	//	Store Reports
	///////////////////		
	public function storereport(Request $request, $client_id){

        $Client = Client::find($client_id);
        
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
		$doc->document 			= $request->document_type;
		$doc->document_name 	= $request->document_name;
		
		if ($request->hasFile('document')){
			
			$count = 1;
	        $file = $request->file('document');
	        $directory = 'medical-report-other';
	        if($request->document_type == 'Childs Dignostic') $directory = 'client-child-diagnostic-report';
	        if($request->document_type == 'Childs IEP') $directory = 'client-child-iep';
	        
            $customName 		= str_replace('.'.$file->getClientOriginalExtension(),'',$file->getClientOriginalName());
            $file_name 			= $customName.'_'.time().'.'.$file->getClientOriginalExtension();
            $file_storage   	= 'public/admissionforms/'.$directory;

            $put_data               = Storage::putFileAs($file_storage, $request->file('document'), $file_name);
            $full_path              = Storage::url($put_data);
            $doc->document_file  	= $full_path;
    		
    		$doc->save();
    		
	 		Session::flash('Success','<div class="alert alert-success">Document Added Successfully</div>');
			return redirect('/parent/client/viewmedicalinformation');
    		
		}
				
	}
	
	///////////////////
	//	Edit Insurance
	///////////////////	
	public function editInsurance(Request $request, $type, $client_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Insurance";
        $sub_title                      = "Edit Insurance";
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

        $Client = Client::find($client_id);
        $router_name = \Request::route()->getName();
		
        if($request->isMethod('post')){

			$client = Client::find($client_id);
			if($type == 'primarypolicy'){
				$client->client_insurancecompanyname 	  = $request->client_insurancecompanyname;
				$client->client_memberid 				  = $request->client_memberid;
				$client->client_groupid 				   = $request->client_groupid;
				$client->client_policyholdersname 		 = $request->client_policyholdersname;
				$client->client_policyholdersdateofbirth  = date('Y-m-d',strtotime($request->client_policyholdersdateofbirth));
				$client->client_childfullname 			= $request->client_childfullname;
				$client->client_childdateofbirth 		  = date('Y-m-d',strtotime($request->client_childdateofbirth));
				$client->client_subscribername 			= $request->client_subscribername;
				$client->client_subscriberdateofbirth 	 = date('Y-m-d',strtotime($request->client_subscriberdateofbirth));
			}
			
			if($type == 'benefits'){
				$client->client_benefiteffectivedate     	= date('Y-m-d',strtotime($request->client_benefiteffectivedate));
				$client->client_benefitexpirationdate    	= date('Y-m-d',strtotime($request->client_benefitexpirationdate));
				$client->client_benefitcopay 		     	= $request->client_benefitcopay;
				$client->client_benefitoopm 		      	= $request->client_benefitoopm;
				$client->client_benefitannualbenefit     	= $request->client_benefitannualbenefit;
				$client->client_benefitclaimaddress      	= $request->client_benefitclaimaddress;
				$client->client_benefitdateverified      	= date('Y-m-d',strtotime($request->client_benefitdateverified));
				$client->client_benefitinsuranceemployee 	= $request->client_benefitinsuranceemployee;
				$client->client_benefitreferencenumber   	= $request->client_benefitreferencenumber;
			}
			
			if($type == 'authorizations'){
				$client->client_authorizationsstartdate      	= date('Y-m-d',strtotime($request->client_authorizationsstartdate));
				$client->client_authorizationseenddate       	= date('Y-m-d',strtotime($request->client_authorizationseenddate));
				$client->client_authorizationsaba 		    	= $request->client_authorizationsaba;
				$client->client_authorizationssupervision 		= $request->client_authorizationssupervision;
				$client->client_authorizationsparenttraining 	= date('Y-m-d',strtotime($request->client_authorizationsparenttraining));
				$client->client_authorizationsreassessment   	= date('Y-m-d',strtotime($request->client_authorizationsreassessment));
			}
			
			if($type == 'uploadinsurancecompanyidcard'){
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
				if($router_name == "parent.editinsurance")return redirect('/parent/insurance');else return redirect('/parent/client/viewinsurance');
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
				if($router_name == "parent.editinsurance")return redirect('/parent/insurance');else return redirect('/parent/client/viewinsurance');
				exit();
			}
			
			$client->save();
			//exit();

			Session::flash('Success','<div class="alert alert-success">Insurance successfully updated</div>');
			if($router_name == "parent.editinsurance")return redirect('/parent/insurance');else return redirect('/parent/client/viewinsurance');

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
		$data['type'] = $type;
		return view('parent.client.insurance.editInsurance',$data);
	}
	
	/////////////////
	// View Medical Information
	/////////////////
	public function viewMedicalInformation(){
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
		
        //If ID IS NULL THEN REDIRECT
		$client_id = Auth::guard('parent')->user()->id;
        if(!$client_id) return redirect('parent/dashboard');
        
        $Client = Client::find($client_id);
        
        if(!$Client) return redirect('parent/dashboard');
		
        $data['Client'] = $Client;
		
		$data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(0);
		
		return view('parent.client.medical_information.viewMedicalInformation',$data);
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

        //If ID IS NULL THEN REDIRECT
        if(!$client_id) return redirect('parent/dashboard');
        
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('parent/dashboard');
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
			$client->client_medicalabahistory 	    	= $request->client_medicalabahistory;
			if($request->client_medicallastvisionexam) $client->client_medicallastvisionexam 	= date('Y-m-d',strtotime($request->client_medicallastvisionexam));
			$client->client_medicalabahoursperweek   	= $request->client_medicalabahoursperweek;
			$client->client_medicaltoolused 	      	= $request->client_medicaltoolused;
			$client->client_medicalphonenumber 	   		= $request->client_medicalphonenumber;
			$client->client_medicalfaxnumber 	     	= $request->client_medicalfaxnumber;
			$client->client_medicaladdress 	       	= $request->client_medicaladdress;

			$client->save();

			Session::flash('Success','<div class="alert alert-success">Medical Information successfully updated</div>');
			return redirect('/parent/client/viewmedicalinformation');

		}

        $data['Client'] = $Client;
		
		return view('parent.client.medical_information.editMedicalInformation',$data);
	}

	/////////////////////////////////////////
	// Download Medical Information Documents
	/////////////////////////////////////////
	public function medicalInformationDocumentsDownload($client_id,$doc_id){
	    
		$client = Client::find($client_id);

	    //Checking if client is in current franchise
	    if($client->franchise_id != Auth::guard('parent')->user()->franchise_id) {echo "You don't have permission to download other Franchises clients files"; exit;}
	    
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
					return redirect('/parent/client/viewmedicalinformation');
				}
			}
			else
			{
				Session::flash('Success','<div class="alert alert-warning">Child Document not found</div>');
				return redirect('/parent/client/viewmedicalinformation');
			}
		}
		else
		{
			return redirect('parent/dashboard');
		}
		
	}
	
	///////////////////////////////////////
	// Delete Medical Information Documents
	///////////////////////////////////////
	public function medicalInformationDocumentsDelete(Request $request, $client_id, $doc_id){
	    $client = Client::find($client_id);

	    //Checking if client is in current franchise
	    if($client->franchise_id != Auth::guard('parent')->user()->franchise_id) {echo "You don't have permission to delete other Franchises clients files"; exit;}

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
					return redirect('/parent/client/viewarchives');
				}else{
					return redirect('/parent/client/viewmedicalinformation');
				}

				
			}
			else
			{
				Session::flash('Success','<div class="alert alert-warning">Child Document not found</div>');
				return redirect('/parent/client/viewmedicalinformation');
			}			
		}
		else
		{
			return redirect('parent/dashboard');
		}
		
	}
	
	/////////////////////////////////////////
	// Archive Medical Information Documents
	/////////////////////////////////////////
	public function medicalInformationDocumentsArchive(Request $request, $client_id, $doc_id){
	    $client = Client::find($client_id);

	    //Checking if client is in current franchise
	    if($client->franchise_id != Auth::guard('parent')->user()->franchise_id) {echo "You don't have permission to archive other Franchises clients files"; exit;}

	    if($client){

		    $client_doc = Client_documents::find($doc_id);
		    if($client_doc->client_id != $client->id){ echo "You don't have permission to archive other Franchises clients files"; exit;}

			if ($client_doc){
			  $client_doc->archive = 1;
			  $client_doc->save();
			}
			
			Session::flash('Success','<div class="alert alert-success">Document Archived successfully</div>');
			return redirect('/parent/client/viewmedicalinformation');
			exit();
		}
		else
		{
			return redirect('parent/dashboard');
		}
		
	}
	
	////////////////////////////////////////
	// Active Medical Information Documents
	////////////////////////////////////////
	public function medicalInformationDocumentsActive(Request $request, $client_id, $doc_id){
	    $client = Client::find($client_id);
	    
	    //Checking if client is in current franchise
	    if($client->franchise_id != Auth::guard('parent')->user()->franchise_id) {echo "You don't have permission to archive other Franchises clients files"; exit;}
	    
	    if($client){
			
			$client_archive = Client_documents::find($doc_id);
		    if($client_archive->client_id != $client->id){ echo "You don't have permission to archive other Franchises clients files"; exit;}

			if($client_archive){
			  $client_archive->archive = 0;
			  $client_archive->save();
			}
			Session::flash('Success','<div class="alert alert-success">Document Unarchived successfully</div>');
			return redirect('/parent/client/viewarchives');
			exit();
		}
		else
		{
			return redirect('parent/dashboard');
		}
	}
	
	/////////////////
	// View Archives
	/////////////////
	public function viewArchives(){
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

        //If ID IS NULL THEN REDIRECT
		$client_id = Auth::guard('parent')->user()->id;
        if(!$client_id) return redirect('parent/dashboard');
        
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('parent/dashboard');
		}

        $data['Client'] = $Client;
		
		$data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(30);
		
		return view('parent.client.archives.viewArchive',$data);
	}
	
	/////////////////
	// View Agreement
	/////////////////
	public function viewAgreement(){
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

        //If ID IS NULL THEN REDIRECT
		$client_id = Auth::guard('parent')->user()->id;
        if(!$client_id) return redirect('parent/dashboard');
        
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('parent/dashboard');
		}

        $data['Client'] = $Client;
		
        $data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(0);
		
		return view('parent.client.agreement.viewAgreement',$data);
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

        //If ID IS NULL THEN REDIRECT
        if(!$client_id) return redirect('parent/dashboard');
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('parent/dashboard');
		}
		
		$data['Client'] = $Client;
		
		return view('parent.client.agreement.editAgreement',$data);
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

        //If ID IS NULL THEN REDIRECT
        if(!$client_id) return redirect('parent/dashboard');
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('parent/dashboard');
		}
		
		$Client->agreement_hippa 		= $request->agreement_hippa;
		$Client->agreement_payment 		= $request->agreement_payment;
		$Client->agreement_informed 	= $request->agreement_informed;
		$Client->agreement_security 	= $request->agreement_security;
		$Client->agreement_release 		= $request->agreement_release;
		$Client->agreement_parent 		= $request->agreement_parent;
		$Client->save();
		
        $data['Client'] = $Client;
		
		Session::flash('Success','<div class="alert alert-success">Agreement Updated successfully</div>');
		return redirect('parent/client/viewagreement');
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
        
        $Client = Client::find($client_id);
        
        if(!$Client) return redirect('parent/dashboard');

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
			return redirect('parent/client/viewtasklist');
		}

		$data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(0);
		
        $data['Client'] = $Client;

		return view('parent.client.tasklist.addTask',$data);
	}

	/////////////////
	// VIEW TASKLIST
	////////////////
	public function viewTasklist(){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Clients Task List";
        $sub_title                      = "Clients Task List";
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

        $client_id = Auth::guard('parent')->user()->id;
		if(!$client_id) return redirect('parent/dashboard');
        
        $Client = Client::find($client_id);
        
        if(!$Client) return redirect('parent/dashboard'); 
        
		$data['Client'] = $Client;

        $data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(0);
		
		return view('parent.client.tasklist.viewTasklist',$data);
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
        
        $Client = Client::find($client_id);
        
        if(!$Client) return redirect('parent/dashboard');

       if($request->isMethod('post')){

			if(!empty($request->task)){
				foreach($request->task as $task){
					Client_tasklist::where('client_id',$Client->id)->where('id',$task['task_id'])
					->update(['sort' => $task['sort'], 'task' => $task['task_description'], 'status' => $task['status'] ]);
				}
			}
			
			Session::flash('Success','<div class="alert alert-success">Task list updated successfully.</div>');
			return redirect('parent/client/viewtasklist');
		}
        $data['Client'] = $Client;

		$data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(0);

		return view('parent.client.tasklist.editTask',$data);
	}	

	/////////////////
	//	DELETE TASK
	/////////////////
	public function deletetask($client_id, $task_id){

		$Client = Client::find($client_id);
        if(!$Client){
			return redirect('parent/dashboard');
		}

		$C_task = Client_tasklist::where('client_id',$client_id)->where('id',$task_id);
		if(!$C_task) return redirect('parent/dashboard');
		$C_task->delete();
		
		Session::flash('Success','<div class="alert alert-success">Task deleted successfully.</div>');
		return redirect('parent/client/edittasklist/'.$client_id);
		
	}
	
	/////////////////
	// Sessions Logs
	/////////////////
	public function SessionsLogs(){
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

        //If ID IS NULL THEN REDIRECT
		$client_id = Auth::guard('parent')->user()->id;
        if(!$client_id) return redirect('parent/dashboard');
        
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('parent/dashboard');
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
        $data['Client'] = $Client;
        $data['ClientArchives'] = Client_documents::where('client_id',$client_id)->where('archive',1)->orderby('created_at','desc')->paginate(0);
		
		return view('parent.client.sessionslogs.sessionslogs',$data);		
	}

}