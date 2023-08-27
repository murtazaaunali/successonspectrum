<?php
namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\Profile\UpdateProfile;
use App\Http\Requests\Admin\User\AddUser;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

//Models
use App\Models\Admin;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Franchise;
use App\Models\Order_products;
use App\Models\Franchise_payments;
use App\Models\Franchise_tasklist;
use App\Models\Franchise\Femployee;

class CronesController extends Controller
{
	function __construct(){
		$users[] = Auth::user();
		$users[] = Auth::guard()->user();
		$users[] = Auth::guard('franchise')->user();
	}
	
	public function FranchiseExpiration(REQUEST $request){

		$currDate = date('Y-m-d');
		//Adding two weeks into current Date for check upcomming perforamance
		$upcommingDate = date('Y-m-d',strtotime($currDate."+14 days"));
        $Franchises = Franchise::whereBetween('fdd_expiration_date',[$currDate, $upcommingDate])->get();
        if(!$Franchises->isEmpty()){
			foreach($Franchises as $Franchise){
				
				$message = 'Your franchise will be expire with in 14 days';
		        //$data = array("name" => $Franchise->Location, "email" => $Franchise->email, "Message" => 'Your franchise will be expire with in 14 days');
		        \Mail::send('email.email_template', ["name" => $Franchise->Location, "email" => $Franchise->email, "link"=>url('franchise/login'), 'Message' => $message], function ($message) use ($data) {
		            $message->from(['address' => 'sos@testing.com', 'name' => 'SOS']);
		            $message->to($data['email'])->subject("Franchise Expiration Notice");
		        });
			}
		}//Franchise Condition

	}
	
	//Crone Once in a day for checking pending task of franchise
	/*public function taskPendingFranchise(){

		$Franchises = Franchise::all();
		if(!$Franchises->isEmpty()){
			foreach($Franchises as $Franchise){
		
				$messgeEmail = 'Hello! ('.$Franchise->location.'), These tasks are Incomplete, <br/><br/>';
				$EmailTest = false;
				$tasks = Franchise_tasklist::where('franchise_id', $Franchise->id)->orderby('sort','asc')->get();
				if(!$tasks->isEmpty()){
					
					foreach($tasks as $getTask){
						if($getTask['status'] == 'Incomplete'){
							$EmailTest = true;
							$messgeEmail .= '<strong>Task:</strong> '.$getTask['task'].'. <strong>Status:</strong> '.$getTask['status'].'<br/>';
						}
					}
				}
				
				if($EmailTest){
			        $Admin = Admin::where('type','Super Admin')->first();
			        $data = array("name" => $Franchise->location, "email" => $Franchise->email, "messages" => $messgeEmail);
			        \Mail::send('email.email_template', ["name" => $Franchise->location, "email" => $Franchise->email, "link"=>url('franchise/login'), 'messages' => $messgeEmail], function ($message) use ($data) {
			            $message->from('sos@testing.com', 'SOS');
			            $message->to($data['email'])->subject("Franchise Pending Task List");
			        });						
				}
				
			}
		}//Checkin Franchises object is not empty
	}*/

  	//employee contract near by expire and expiration (Cron) for Franchise Employees
  	public function FranchiseEmployeeExpiration(){

		$Franchises = Franchise::all();
		if(!$Franchises->isEmpty()){
			foreach($Franchises as $Franchise){
		
				$messgeEmail = 'Your account will be expired with in 14 days, <br/><br/>';
				$EmailTest = false;

				$currDate = date('Y-m-d');
				$upcommingDate = date('Y-m-d',strtotime($currDate."+14 days"));
				$Employees = Femployee::where('franchise_id', $Franchise->id)->where('career_probation_completion_date', $upcommingDate)->orderby('sort','asc')->get();
				if($Employees->isEmpty()){
					foreach($Employees as $Employee){

				        //$Admin = Admin::where('type','Super Admin')->first();
				        $data = array("name" => $Employee->personal_name, "email" => $Employee->personal_email, "messages" => $messgeEmail);
				        \Mail::send('email.email_template', ["name" => $Employee->personal_name, "email" => $Employee->personal_email, "link"=>url('femployee/login'), 'messages' => $messgeEmail], function ($message) use ($data) {
				            $message->from('sos@testing.com', 'SOS');
				            $message->to($data['email'])->subject("Account Expiration Notification");
				        });						
						
					}
				}
			}
		}//Checkin Franchises object is not empty
		
	}

}
