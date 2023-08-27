<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use validator;
use Image;
use PDF;
use Session;
use App;
use Response;
use App\Models\Frontend\Admissionform;
use Illuminate\Support\Facades\Input;

use App\Models\Franchise;
use App\Models\Franchise\Fuser;
use App\Models\Franchise_owners;
use App\Models\Franchise\Client_tasklist;
use App\Models\Franchise\Client_documents;
use App\Models\Franchise\Client_insurance_policy;
use App\Models\Franchise\Client_insurance_policy_idcards;

class AdmissionformController extends Controller
{
	public function index(){

		$getFranchises = Franchise::when('Active', function ($query, $status) {
            return $query->where('status', $status);
        })->orderby('created_at','desc')->paginate(0);
		
		$data['franchises'] = array();
		if($getFranchises){
			foreach($getFranchises as $franchise){
				$data['franchises'][] = $franchise;
			}
		}

		return view('frontend.admissionform',$data);
	}
	
	public function send(Request $request){

        $franchise = Franchise::find($request->franchise_id);
        if(!$franchise){
			echo "Can't Find Franchise";exit;
		}

		$childName = $request->client_childfirstname.' '.$request->client_childlastname;
		$MomsName = $request->client_momsfname.' '.$request->client_momslname;
		$DadsName = $request->client_dadsfname.' '.$request->client_dadslname;
		
		$admissionForm = new Admissionform();
		$admissionForm->franchise_id = $request->franchise_id;
		$admissionForm->client_status = 'Applicant';
		
		//Choose Location
		$admissionForm->chooselocation_interest 		= $request->chooselocation_interest;
		$admissionForm->chooselocation_location 		= !empty($request->chooselocation_location) ? implode('|',$request->chooselocation_location) : '';
		
		//CLient Information
		if($request->client_todaydate) 					$admissionForm->client_todaydate = date('Y-m-d',strtotime($request->client_todaydate));
		$admissionForm->client_childfullname 			= $request->client_childfirstname." ".$request->client_childlastname;
		if($request->client_childdateofbirth) 			$admissionForm->client_childdateofbirth = date('Y-m-d',strtotime($request->client_childdateofbirth));
		$admissionForm->client_custodialparent 			= $request->client_custodialparent;
		$admissionForm->client_momsname 				= $request->client_momsfname.' '.$request->client_momslname;
		$admissionForm->client_momsemail 				= $request->client_momsemail;
		$admissionForm->client_momscell 				= $request->client_momscell;
		$admissionForm->client_custodialparentsaddress 	= $request->client_custodialparentsaddress;
		$admissionForm->client_dadsname 				= $request->client_dadsfname.' '.$request->client_dadslname;
		$admissionForm->client_dadsemail 				= $request->client_dadsemail;
		$admissionForm->client_dadscell 				= $request->client_dadscell;
		$admissionForm->client_emergencycontactname 	= $request->client_emergencycontactname;
		$admissionForm->client_emergencycontactphone 	= $request->client_emergencycontactphone;
		$admissionForm->client_insurancecompanyname 	= $request->client_insurancecompanyname;
		//$admissionForm->client_insurancecompanyidcard = $request->client_insurancecompanyidcard;
		$admissionForm->client_memberid 				= $request->client_memberid;
		$admissionForm->client_groupid 					= $request->client_groupid;
		$admissionForm->client_policyholdersname 		= $request->client_policyholdersname;
		if($request->client_policyholdersdateofbirth) 	$admissionForm->client_policyholdersdateofbirth = date('Y-m-d',strtotime($request->client_policyholdersdateofbirth));
		$admissionForm->client_ageandsymtoms 			= $request->client_ageandsymtoms;
		if($request->client_dateofautism) 				$admissionForm->client_dateofautism = date('Y-m-d',strtotime($request->client_dateofautism));
		//$admissionForm->client_childdiagnostic_report = $request->client_childdiagnostic_report;
		$admissionForm->client_diagnosingdoctor 		= $request->client_diagnosingdoctor;
		$admissionForm->client_primarydiagnosis 		= $request->client_primarydiagnosis;
		$admissionForm->client_secondarydiagnosis 		= $request->client_secondarydiagnosis;
		$admissionForm->client_childcurrentmedications 	= $request->client_childcurrentmedications;
		$admissionForm->client_allergies 				= $request->client_allergies;
		$admissionForm->client_aba 						= $request->client_aba;
		
		if($request->client_aba == 'Yes'){
			$aba_array = array();
			foreach($request->aba as $aba){
				$aba_array[] = array(
					'client_facility' => $aba['client_facility'],
					'client_start' => $aba['client_start'],
					'client_end' => $aba['client_end'],
					'client_hours' => $aba['client_hours'],
				);
			}
			
			$admissionForm->client_aba_facilities = serialize($aba_array);
		}
		
		//$admissionForm->client_abarecord = $request->client_abarecord;
		$admissionForm->client_speechtherapy 			= $request->client_speechtherapy;
		$admissionForm->client_speechinstitution 		= $request->client_speechinstitution;
		$admissionForm->client_speechhoursweek 			= $request->client_speechhoursweek;
		$admissionForm->client_occupationaltherapy 		= $request->client_occupationaltherapy;
		$admissionForm->client_occupationalinstitution 	= $request->client_occupationalinstitution;
		$admissionForm->client_occupationalhoursweek 	= $request->client_occupationalhoursweek;
		$admissionForm->client_childattendschool 		= $request->client_childattendschool;
		$admissionForm->client_schoolname 				= $request->client_schoolname;
		$admissionForm->client_specialclass 			= $request->client_specialclass;
		//$admissionForm->client_childiep = $request->client_childiep;
		
		//HIPAA Agreement Form
		$admissionForm->hipaa_childsname 				= $request->hipaa_childsname;
		$admissionForm->hipaa_parentsname 				= $request->hipaa_parentsname;
		$admissionForm->hipaa_sospolicy 				= $request->hipaa_sospolicy;
		$admissionForm->hipaa_insideourcenter 			= $request->hipaa_insideourcenter;
		$admissionForm->hipaa_whenclients 				= $request->hipaa_whenclients;
		$admissionForm->hipaa_readprivacy 				= $request->hipaa_readprivacy;
		if($request->hipaa_date) 						$admissionForm->hipaa_date = date('Y-m-d',strtotime($request->hipaa_date));
		$admissionForm->hipaa_signature 				= $request->hipaa_signature;
		
		//Payment Agreement Form
		$admissionForm->payment_childsname 				= $request->payment_childsname;
		$admissionForm->payment_parentsname 			= $request->payment_parentsname;
		$admissionForm->payment_parentssignature 		= $request->payment_parentssignature;
		$admissionForm->payment_parentssocialsecurity 	= $request->payment_parentssocialsecurity;
		if($request->payment_parentsbirthday) 			$admissionForm->payment_parentsbirthday = date('Y-m-d',strtotime($request->payment_parentsbirthday));
		if($request->payment_parentsdate) 				$admissionForm->payment_parentsdate = date('Y-m-d',strtotime($request->payment_parentsdate));
		
		//Informed Consent For Services
		$admissionForm->informed_childsname 	= $request->informed_childsname;
		$admissionForm->informed_parentsname 	= $request->informed_parentsname;
		if($request->informed_date) 			$admissionForm->informed_date = date('Y-m-d',strtotime($request->informed_date));
		$admissionForm->informed_signature 		= $request->informed_signature;
		
		//Security System Waiver
		$admissionForm->security_childsname 		= $request->security_childsname;
		$admissionForm->security_parentsname 		= $request->security_parentsname;
		$admissionForm->security_grantsuccess 		= $request->security_grantsuccess;
		$admissionForm->security_acknowledge 		= $request->security_acknowledge;
		$admissionForm->security_sospolicy 			= $request->security_sospolicy;
		$admissionForm->security_whenclients 		= $request->security_whenclients;
		if($request->security_date) 				$admissionForm->security_date = date('Y-m-d',strtotime($request->security_date));
		$admissionForm->security_signature 			= $request->security_signature;
		
		//Release of Liability
		$admissionForm->release_childsname 		= $request->release_childsname;
		$admissionForm->release_parentsname 	= $request->release_parentsname;
		if($request->release_date) 				$admissionForm->release_date = date('Y-m-d',strtotime($request->release_date));
		$admissionForm->release_signature 		= $request->release_signature;
		
		//Parent Handbook Agreement
		$admissionForm->parent_childsname 		= $request->parent_childsname;
		$admissionForm->parent_parentsname 		= $request->parent_parentsname;
		if($request->parent_date) 				$admissionForm->parent_date = date('Y-m-d',strtotime($request->parent_date));
		$admissionForm->parent_signature 		= $request->parent_signature;
		$admissionForm->agreement_hippa 		= '1';
		$admissionForm->agreement_payment 		= '1';
		$admissionForm->agreement_informed 		= '1';
		$admissionForm->agreement_security 		= '1';
		$admissionForm->agreement_release 		= '1';
		$admissionForm->agreement_parent 		= '1';
		$admissionForm->save();
		
		$data['request'] = $request->all();

		//Client Tasks
		if($admissionForm->id){
			$sort = 1;
			foreach($this->AdditionalTasks() as $key=>$task){
				/*$ETask = new Client_tasklist();
				$ETask->task = $task;
				$ETask->client_id = $admissionForm->id;
				$ETask->status = 'Incomplete';
				$ETask->sort = $sort;
				$ETask->save();
				$sort++;*/
				$group = $key;
				foreach($task as $task_row){
					$ETask = new Client_tasklist();
					$ETask->group = $group;
					$ETask->task = $task_row;
					$ETask->client_id = $admissionForm->id;
					$ETask->status = 'Incomplete';
					$ETask->sort = $sort;
					$ETask->save();
					$sort++;	
				}
			}
		}
		
		$data['idcard'] = '';
		//Client Insurance Company ID Card
		if ($request->hasFile('client_insurancecompanyidcard')){

	        $file = $request->file('client_insurancecompanyidcard');
			$exists = Storage::exists('public/admissionforms/insurance-company-id-card/'.basename($admissionForm->client_insurancecompanyidcard));
			if($exists){
				Storage::delete('public/admissionforms/insurance-company-id-card/'.basename($admissionForm->client_insurancecompanyidcard));
			}

			$customName 		= str_replace('.'.$file->getClientOriginalExtension(),'',$file->getClientOriginalName());
    		$file_name 			= $customName.'_'.$admissionForm->id.'.'.$file->getClientOriginalExtension();

            $file_storage  = 'public/admissionforms/insurance-company-id-card';
            $put_data      = Storage::putFileAs($file_storage, $file, $file_name);
            $full_path     = Storage::url($put_data);
            $admissionForm->client_insurancecompanyidcard = $full_path;

    		$admissionForm->save();
    		$data['idcard'] = $file_name;
		}
		
		//Client Child Diagnostic Report Multi file codes
		if ($request->hasFile('client_childdiagnostic_report')){
			$diagnostic_reports = array();
			$count = 1;
	        foreach($request->file('client_childdiagnostic_report') as $pdf){
		        $file = $pdf;

				$customName = str_replace('.'.$file->getClientOriginalExtension(),'',$file->getClientOriginalName());
	    		$file_name 	= $customName.'_'.$admissionForm->id.''.$count.'.'.$file->getClientOriginalExtension();

	            $file_storage  = 'public/admissionforms/client-child-diagnostic-report';
	            $put_data      = Storage::putFileAs($file_storage, $file, $file_name);
				
				/*Save Data in Client Documents*/
				$Client_documents = new Client_documents();
				$Client_documents->client_id 		= $admissionForm->id;
				$Client_documents->document 		= 'Childs Dignostic';
				$Client_documents->document_name 	= $file_name;
				$Client_documents->document_file 	= Storage::url($put_data);
				$Client_documents->archive 			= 0;
				$Client_documents->save();
				
	    		$count++;
			}
			$admissionForm->client_childdiagnostic_report = serialize($diagnostic_reports);
    		$admissionForm->save();
		}		

		$data['childiep'] = '';
		//Client Child's IEP
		if ($request->hasFile('client_childiep')){

	        $file = $request->file('client_childiep');

			$customName = str_replace('.'.$file->getClientOriginalExtension(),'',$file->getClientOriginalName());
    		$file_name 	= $customName.'_'.$admissionForm->id.'.'.$file->getClientOriginalExtension();

            $file_storage  = 'public/admissionforms/client-child-iep';
            $put_data      = Storage::putFileAs($file_storage, $file, $file_name);
			
			/*Save Data in Client Documents*/
			$Client_documents = new Client_documents();
			$Client_documents->client_id = $admissionForm->id;
			$Client_documents->document = 'Childs IEP';
			$Client_documents->document_name = $file_name;
			$Client_documents->document_file = Storage::url($put_data);
			$Client_documents->archive = 0;
			$Client_documents->save();
			
    		$admissionForm->save();
    		$data['childiep'] = $file_name;
		}
		
		//Client Insurance Policy
		if($admissionForm->id){
			/*Save Data in Client Insurance Policy*/
			$Client_insurance_policy = new Client_insurance_policy();
			$Client_insurance_policy->client_id = $admissionForm->id;
			$Client_insurance_policy->client_insurancecompanyname = $request->client_insurancecompanyname;
			$Client_insurance_policy->client_memberid = $request->client_memberid;
			$Client_insurance_policy->client_groupid = $request->client_groupid;
			$Client_insurance_policy->client_policyholdersname = $request->client_policyholdersname;
			if($request->client_policyholdersdateofbirth)
			$Client_insurance_policy->client_policyholdersdateofbirth = date('Y-m-d',strtotime($request->client_policyholdersdateofbirth));
			$Client_insurance_policy->client_insurance_primary = 1;
			$Client_insurance_policy->save();
			 
			/*Save Data in Client_insurance_policy_idcards*/
			$Client_insurance_policy_idcards = '';
			if ($request->hasFile('client_insurancecompanyidcard')){
				$Client_insurance_policy_idcards = new Client_insurance_policy_idcards();
				$Client_insurance_policy_idcards->client_insurance_id  = $Client_insurance_policy->id;
				$Client_insurance_policy_idcards->save();
				
				$file = $request->file('client_insurancecompanyidcard');
				$exists = Storage::exists('public/admissionforms/insurance-company-id-card/'.basename($Client_insurance_policy_idcards->client_insurancecompanyidcard));
				if($exists){
					Storage::delete('public/admissionforms/insurance-company-id-card/'.basename($Client_insurance_policy_idcards->client_insurancecompanyidcard));
				}
	
				$customName = str_replace('.'.$file->getClientOriginalExtension(),'',$file->getClientOriginalName());
				$file_name = $customName.'_'.$admissionForm->id.'_'.$Client_insurance_policy->id.'_'.$Client_insurance_policy_idcards->id.'.'.$file->getClientOriginalExtension();
	
				$file_storage  = 'public/admissionforms/insurance-company-id-card';
				$put_data = Storage::putFileAs($file_storage, $file, $file_name);
				$full_path = Storage::url($put_data);
				$Client_insurance_policy_idcards->client_insurancecompanyidcard = $full_path;
				$Client_insurance_policy_idcards->client_insurancecompanyidcard_name = $customName;
				$Client_insurance_policy_idcards->save();
				$data['idcard'] = $file_name;
			}
		}		
		
		//save pdf
		if($admissionForm->id){
			$data['adForm'] = $admissionForm;
			$data['adFormInsurancePolicy'] = $Client_insurance_policy;
			$data['adFormInsurancePolicyIDCard'] = $Client_insurance_policy_idcards;
			$pdf = App::make('dompdf.wrapper');
	    	$pdf->loadView('pdf.admissionform', $data);
	    	//return $pdf->stream();//to preview the pdf
			if (!file_exists(storage_path().'/app/public/admissionforms/pdf')) {
			    mkdir(storage_path().'/app/public/admissionforms/pdf', 0777, true);
			}
			
			$pdfName = $admissionForm->id.'_'.time();
			$pdfNameWithoutPath = '/admissionforms/pdf/'.$pdfName.'.pdf';
			$pdfNameWithPath = storage_path().'/app/public/admissionforms/pdf/'.$pdfName.'.pdf';
	    	$pdf->save($pdfNameWithPath)->stream();
	    	$admissionForm->pdf = $pdfNameWithoutPath;
	    	$admissionForm->save();

	        //Email for Franchise owner
	        $franchise = Franchise::find($request->franchise_id);
	        $F_owner = Fuser::where(array('franchise_id'=>$franchise->id, 'type'=>'Owner'))->orderby('created_at','asc')->first();
	        
	        $data = array( "name" => $F_owner->fullname, "email" => $F_owner->email, "pdfName" => $pdfName, 'childname' => $childName);
	        \Mail::send('email.admissionformforadmin', ["name" => $data['name'], "email"=> $data['email']], function ($message) use ($data) {
	            $message->from('swhouston@successonthespectrum.com', 'SOS');
	            $message->to($data['email'])->subject("Admission Form");
	            $message->attach(storage_path().'/app/public/admissionforms/pdf/'.$data['pdfName'].'.pdf', [
                  'as' => $data['childname'].'.pdf',
                  'mime' => 'application/pdf',
	            ]);
	        });
	        
	        //Email for client 
	        //Father Email
			$data2 = array( "name" => $admissionForm->client_dadsname, "email" =>  $admissionForm->client_dadsemail, "pdfName" =>  $pdfName, 'childname' => $childName);
	        if($admissionForm->client_dadsemail){

		        \Mail::send('email.admissionform', ["name" => $data2['name']], function ($message) use ($data2) {
		            $message->from('swhouston@successonthespectrum.com', 'SOS');
		            $message->to($data2['email'])->subject("Admission Form");
		            $message->attach(storage_path().'/app/public/admissionforms/pdf/'.$data2['pdfName'].'.pdf', [
	                  'as' => $data2['childname'].'.pdf',
	                  'mime' => 'application/pdf',
	            	]);
		        });
				
			}

	        //Mom Email
	        $data3 = array( "name" => $admissionForm->client_momsname, "email" =>  $admissionForm->client_momsemail, "pdfName" =>  $pdfName, 'childname' => $childName);
	        if($admissionForm->client_momsemail){

		        \Mail::send('email.admissionform', ["name" => $data3['name']], function ($message) use ($data3) {
		            $message->from('swhouston@successonthespectrum.com', 'SOS');
		            $message->to($data3['email'])->subject("Admission Form");
		            $message->attach(storage_path().'/app/public/admissionforms/pdf/'.$data3['pdfName'].'.pdf', [
	                  'as' => $data3['childname'].'.pdf',
	                  'mime' => 'application/pdf',
	            	]);
		        });
				
			}
	        	        
	        Session::flash('link',$data['pdfName']);
	        return redirect('admissionform/admissionthankyou');
		}			
		
	}

	/////////////////////
	// All task list
	/////////////////////
	public function AdditionalTasks(){
		/*return array(
			'Parents toured facility',
			'Received admission form',
			'Verified benefits',
			'Send initial assessment request form to health insurance',
			'Receive pre-auth for initial assessment',
			'Schedule initial assessment',
			'Complete initial assessment',
			'Schedule appointment with parents to review initial assessment report',
			'Send request for ABA to health insurance',
			'Received pre-auth ABA',
			"Schedule client's first day",
			'Schedule initial parent training',
			'Complete parent training every week',
		);*/
		return array(
			'Potential'=>array(
				'Facility Tour',
				'Verify Benefits and send email to parents'
			),
			'Admissions'=>array(
				'Receive Admission Form',
				'If cash pay, have client sign self-pay consent form',
				'Receive Scored Diagnostic test from physician',
				'If client wants school-shadowing, obtain Third Party Release Form',
				'If child attends school, Receive IEP',
				'Send parents email that everything has been received'
			),
			'Enrollment Process'=>array(
				'Complete Initial Assessment Request Form',
				'Assign client to a crew',
				'Send initial request form to insurance company',
				'Receive pre-auth for Initial Assessment',
				'Send parents email to schedule an initial assessment',
				'Complete Initial Assessment',
				'Schedule appointment with parents to review initial assessment report',
				'Complete request for ABA',
				'Send request for ABA to insurance company',
				'Receive pre-auth for ABA',
				"Choose Clients first day and send welcome email"
			)
		);
	}
	
	public function admissionthankyou(){
		return view('frontend.admissionthankyou');
	}
	
	public function pdfdownload($id){
		if($id){
			
			$file = storage_path().'/app/public/admissionforms/pdf/'.$id.'.pdf';
	        if(file_exists($file)){
		        $headers = array('Content-Type: application/pdf',);
		        return Response::download($file, 'Admission Form.pdf',$headers);
			}else{
				echo "File doesn't exists'";
			}			
			
		}else{
			return redirect('admissionform');
		}
		
	}	
	
	
}
