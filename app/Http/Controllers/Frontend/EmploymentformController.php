<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App;
use PDF;
use Image;
use Session;
use Response;
use Illuminate\Support\Facades\Input;
use App\Models\Frontend\Employmentform;
use Illuminate\Support\Facades\Validator;

//Models
use App\Models\Franchise;
use App\Models\Franchise\Fuser;
use App\Models\Franchise\Femployees_tasklist;
use App\Models\Franchise\Femployees_schedules;

class EmploymentformController extends Controller
{
	public function index(){
		//return view('frontend.employmentform');
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
		return view('frontend.employmentform',$data);
	}
	
	public function send(Request $request){
		
        $franchise = Franchise::find($request->franchise_id);
        if(!$franchise){
			echo "Can't Find Franchise";exit;
		}
		
		$emp = new Employmentform();
		$emp->franchise_id             = $request->franchise_id;
		$emp->personal_name 			= $request->personal_name;
		$emp->personal_phone 			= $request->personal_phone;
		$emp->personal_email 			= $request->personal_email;
		$emp->personal_city 			= $request->personal_city;
		$emp->personal_state 			= $request->personal_state;
		$emp->personal_zipcode 			= $request->personal_zipcode;
		$emp->personal_address 			= $request->personal_address;
		
		//CAREER OPTIONS
		$emp->career_desired_position 		= !empty($request->career_desired_position) ? implode(',',$request->career_desired_position) : '';
		$emp->career_desired_schedule 		= $request->career_desired_schedule;
		$emp->career_availability 			= serialize($request->career_availability);
		$emp->career_desired_pay 			= $request->career_desired_pay;
		if($request->career_earliest_startdate != "") $emp->career_earliest_startdate = date('Y-m-d',strtotime($request->career_earliest_startdate));
		$emp->career_bacb 					= $request->career_bacb;
		if($request->career_bacb == 'Yes')  $emp->bacb_regist_date = date('Y-m-d',strtotime($request->bacb_regist_date));
		$emp->career_cpr_certified 			= $request->career_cpr_certified;
		if($request->career_cpr_certified == 'Yes')  $emp->cpr_regist_date = date('Y-m-d',strtotime($request->cpr_regist_date));
		$emp->career_highest_degree 		= $request->career_highest_degree;
		$emp->career_desired_location 		= !empty($request->career_desired_location) ? implode('|',$request->career_desired_location) : '';
		
		//WORK ELIGIBILITY
		$emp->work_underage 		= $request->work_underage;
		$emp->work_authorised 		= $request->work_authorised;
		$emp->work_capable 			= $request->work_capable;
		$emp->work_nocapable 		= $request->work_nocapable;
		$emp->work_liftlbs 			= $request->work_liftlbs;
		
		//ABA EXPERIENCE AND REFERENCES
		if($request->aba_employment_startingdate != "") $emp->aba_employment_startingdate 	= date('Y-m-d',strtotime($request->aba_employment_startingdate));
		if($request->aba_employment_endingdate != "")	$emp->aba_employment_endingdate 	= date('Y-m-d',strtotime($request->aba_employment_endingdate));
		$emp->aba_companyname 				= $request->aba_companyname;
		$emp->aba_positionheld 				= $request->aba_positionheld;
		$emp->aba_reasonforleaving 			= $request->aba_reasonforleaving;
		$emp->aba_managersname 				= $request->aba_managersname;
		$emp->aba_phone 					= $request->aba_phone;
		if($request->aba_employment_startingdate2 != "") $emp->aba_employment_startingdate2 = date('Y-m-d',strtotime($request->aba_employment_startingdate2));
		if($request->aba_employment_endingdate2 != "") $emp->aba_employment_endingdate2 	= date('Y-m-d',strtotime($request->aba_employment_endingdate2));
		
		$emp->aba_companyname2 				= $request->aba_companyname2;
		$emp->aba_positionheld2 			= $request->aba_positionheld2;
		$emp->aba_reasonforleaving2 		= $request->aba_reasonforleaving2;
		$emp->aba_managersname2 			= $request->aba_managersname2;
		$emp->aba_phone2 					= $request->aba_phone2;
		if($request->aba_employment_startingdate3 != '') $emp->aba_employment_startingdate3 = date('Y-m-d',strtotime($request->aba_employment_startingdate3));
		if($request->aba_employment_endingdate3 != '') $emp->aba_employment_endingdate3 = date('Y-m-d',strtotime($request->aba_employment_endingdate3));
		$emp->aba_companyname3 				= $request->aba_companyname3;
		$emp->aba_positionheld3 			= $request->aba_positionheld3;
		$emp->aba_reasonforleaving3 		= $request->aba_reasonforleaving3;
		$emp->aba_managersname3 			= $request->aba_managersname3;
		$emp->aba_phone3 					= $request->aba_phone3;
		
		//CAREFULLY SIGNING APPLICATION
		$emp->careully_applicantpname = $request->careully_applicantpname;
		if($request->careully_date != "")	$emp->careully_date = date('Y-m-d',strtotime($request->careully_date));
		$emp->careully_signature = $request->careully_signature;
		
		$currDate = date('Y-m-d');
		$emp->upcomming_performance = date('Y-m-d',strtotime($currDate.'+6 months'));
		$emp->save();
		
		//save pdf
		if($emp->id){
			
			//$request->career_availability
			if(isset($request->career_availability) && !empty($request->career_availability)){
				$EmpShedule = new Femployees_schedules();
				foreach($request->career_availability as $day => $time){
					$times = explode('-',$time);
					$EmpShedule->{$day.'_time_in'} = date('H:i:s', strtotime($times[0]));
					$EmpShedule->{$day.'_time_out'} = date('H:i:s', strtotime($times[1]));
				}
				$EmpShedule->admin_employee_id = $emp->id;
				$EmpShedule->save();
			}

			//Employee Tasks
			if($emp->id){
				$sort = 1;
				foreach($this->AdditionalTasks() as $task){
					$ETask = new Femployees_tasklist();
					$ETask->task = $task;
					$ETask->employee_id = $emp->id;
					$ETask->status = 'Incomplete';
					$ETask->sort = $sort;
					$ETask->save();
					$sort++;
				}
			}

			$data['empForm'] = $emp;
			$data['emp_shedule'] = $request->career_availability;
			$pdf = App::make('dompdf.wrapper');
	    	$pdf->loadView('pdf.employmentform', $data);
	    	//return $pdf->stream();//to preview the pdf

			if (!file_exists(storage_path().'/app/public/employmentform/pdf')) {
			    mkdir(storage_path().'/app/public/employmentform/pdf', 0777, true);
			}
			
			$pdfName = $emp->id.'_'.time();
			$pdfNameWithoutPath = '/employmentform/pdf/'.$pdfName.'.pdf';
			$pdfNameWithPath = storage_path().'/app/public/employmentform/pdf/'.$pdfName.'.pdf';
	    	$pdf->save($pdfNameWithPath)->stream();
	    	$emp->pdf = $pdfNameWithoutPath;
	    	$emp->save();
	    	
	        //Email for Franchise owner
	        $franchise = Franchise::find($request->franchise_id);
	        $F_owner = Fuser::where(array('franchise_id'=>$franchise->id, 'type'=>'Owner'))->orderby('created_at','asc')->first();
	        
	        //Email for admin
	        $data = array( "name" => $F_owner->fullname, "email" => $F_owner->email, "pdfName" => $pdfName, 'employee_name' => $request->personal_name);
	        \Mail::send('email.employmentformforadmin', ["name" => $data['name']], function ($message) use ($data) {
	            $message->from('swhouston@successonthespectrum.com', 'SOS');
	            $message->to($data['email'])->subject("Employment Form");
	            $message->attach(storage_path().'/app/public/employmentform/pdf/'.$data['pdfName'].'.pdf', [
                  'as' => $data['employee_name'].'.pdf',
                  'mime' => 'application/pdf',
	            ]);
	        });
	        
	        //Email for Employee 
	        $email = '';
	        if($emp->personal_email != ''){
				$email = $emp->personal_email;
				$data2 = array( "name" => $emp->personal_name, "email" =>  $emp->personal_email, "pdfName" =>  $pdfName, 'employee_name' => $request->personal_name);
			}

	        if($emp->personal_email != ''){

		        \Mail::send('email.employmentform', ["name" => $data2['name']], function ($message) use ($data2) {
		            $message->from('swhouston@successonthespectrum.com', 'SOS');
		            $message->to($data2['email'])->subject("Employment Form");
		            $message->attach(storage_path().'/app/public/employmentform/pdf/'.$data2['pdfName'].'.pdf', [
	                  'as' => $data2['employee_name'].'.pdf',
	                  'mime' => 'application/pdf',
	            	]);
		        });
			}
	        	        
	        Session::flash('link',$data['pdfName']);
	        return redirect('employmentform/employmentthankyou');
		}			
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

	public function employmentstart(){
		return view('frontend.employmentstart');
	}
	
	public function employmentthankyou(){
		return view('frontend.employmentthankyou');
	}
	
	public function pdfdownload($id){
		if($id){
			
			$file = storage_path().'/app/public/employmentform/pdf/'.$id.'.pdf';
	        if(file_exists($file)){
		        $headers = array('Content-Type: application/pdf',);
		        return Response::download($file, 'Employment Form.pdf',$headers);
			}else{
				echo "File doesn't exists'";
			}			
			
		}else{
			return redirect('employmentform');
		}
		
	}	
	
	public function EmailExist(Request $request){
		
		$messages = [
		    'email.required' => 'Email Already exit.',
		];
		
		$validator = Validator::make($request->all(), [
		    'email' => 'email|unique:employment_form,personal_email',
		], $messages);
		
		if ($validator->fails()) {
            return response()->json([ 'errors' => $validator->customMessages ]);
		}
		
		 return response()->json(['success' => 'Done']);
		 		
	}		
}
