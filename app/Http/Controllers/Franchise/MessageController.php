<?php

namespace App\Http\Controllers\Franchise;

use Illuminate\Http\Request;
use Session;
use App\Http\Requests\Franchise\Message\SendMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Franchise;
use App\Models\Admins_employees;
use App\Models\Messages;
use App\Models\Messages_read_by;
use App\Models\Franchise\Fuser;
use App\Models\Frontend\Employmentform;
use App\Models\Frontend\Admissionform;

class MessageController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard()->user();
		$users[] = Auth::guard('franchise')->user();

		$this->middleware(function ($request, $next) {
		    $this->user = auth()->user();
			//If user type is not owner or manager then redirecting to dashboard
			if($this->user->type != 'Owner' && $this->user->type != 'Manager' && $this->user->type != 'BCBA'){
				return redirect('franchise/dashboard');
			}
		    return $next($request);
		});

	}


    public function index(Request $request, $name = "", $id = 0)
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Message In a Bottle";
        $sub_title                      = "Message In a Bottle";
        $inner_title                    = "Messages";
        $menu                           = "message";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $send_message       = TRUE;
        $sender_id          = Auth::guard('franchise')->user()->id;
        $sender_type = "Franchise Employee";

        //if(Auth::guard('franchise')->user()->type == 'Owner' || Auth::guard('franchise')->user()->type == 'Manager') $sender_type = "Franchise Employee";
        if($name == "Franchise_Administration" || $name == "Franchise_BCBA") $send_message = FALSE;

        $user_type = Auth::guard('franchise')->user()->type;
        if($user_type == 'Owner' || $user_type == 'Manager'){
	        //$messages_list[] = $this->getMessagingList("Administration");			
	        $messages_list[] = $this->getMessagingList("Director Of Operations");
	        $messages_list[] = $this->getMessagingList("Director Of Administration");
	        $messages_list[] = $this->getMessagingList("Human Resources");
	        $messages_list[] = $this->getMessagingList("SOS Distributor");
		}

        //Message Mark as read
    	$messages = Messages::where("is_private",1)
		->where(function ($query) use ($id) {
			$query->where(array('reciever_id'=> Auth::user()->id, 'sender_id'=> $id, 'message_to'=> 'Franchise Employee'));	
		})->get();
        
	    if($messages->count())
	    {
	      foreach($messages as $message)
	      {
				Messages_read_by::insert(array(
				    "message_id"    =>  $message->id,
				    "user_type"     =>  "Franchise",
				    "user_id"       =>  Auth::user()->id
				));
	      }
		}  
		//Messages mark as read code end here 
		
		//Checking Franchise users roles
		if($name == 'Admin_BCBA' && $user_type != 'BCBA' && $user_type != 'Owner' && $user_type != 'Manager') 
			{echo "You can't send or view messages to BCBA";exit;}
		if($name == 'Administrator' && ($user_type != 'Owner' || $user_type != 'Manager') ) 
			{ echo "You can't send or view messages to Administrator";exit;}

        //$messages_list[] = $this->getMessagingList("Admin BCBA");

        $user_id = Auth::guard('franchise')->user()->id;

		if($user_type == 'Owner' || $user_type == 'Manager') $messages_list[] = $this->getMessagingList("Franchise Administration");
		if($user_type == 'Owner' || $user_type == 'Manager' || $user_type == 'BCBA') $messages_list[] = $this->getMessagingList("Franchise BCBA");

        //Messages of admin employees
        $AdminEmps = Messages::where('is_private', 1)
		->where(function ($query) use ($user_id) {
	        $query->where( 'message_to','Franchise Employee')
	        ->where('sender_type','Admin Employee')
	        ->where('franchise_id',Auth::guard('franchise')->user()->franchise_id)
	        ->where('reciever_id','=',$user_id);
		})->orWhere(function ($query) use ($user_id) {
	        $query->where('message_to','Admin Employee')
	        ->where('sender_type','Franchise Employee')
	        ->where('sender_id','=',$user_id);
		})->orderBy('created_at','DESC')->get();
        
        $adminEmpIDs = array();
        if($AdminEmps->count())
        {
            foreach($AdminEmps as $franchise)
            {
            	$s_id = $franchise->sender_id;
            	if($franchise->message_to == 'Admin Employee'){
            		$s_id = $franchise->reciever_id;
				}
                if(!in_array($s_id,$adminEmpIDs)){
					$adminEmpIDs[] = $s_id;
				}
            }
        }

        if(!empty($adminEmpIDs))
        {
            foreach($adminEmpIDs as $uid)
            {
            	$admin_employee = Admin::find($uid);
                $messages_list[] = $this->getMessagingList("Admin Employee",$admin_employee->fullname, $admin_employee->id);
            }
        }
        //Messages of admin employees end here
		
		if($user_type == 'Owner' || $user_type == 'Manager' || $user_type == 'BCBA'){
			
			///////////////////////////////////////////////
			//GETTING CURRENT FRANCHISE ALL STAFF EMPLOYEES
			///////////////////////////////////////////////
	        $user_id = Auth::guard('franchise')->user()->id;
	        
	        $Emp_ids = array();
	        $Emp_messages = Messages::where('is_private', 1)
			->where('franchise_id',Auth::guard('franchise')->user()->franchise_id)
			->where(function ($query) use ($user_id){
				$query->where('reciever_id',$user_id)
				->where('sender_type','Franchise Employee')
				->where('message_to','Franchise Employee');
			})
			->orWhere(function ($query) use ($user_id){
				$query->where('sender_type','Franchise Employee')
				->where('message_to','Franchise Employee')
				->where('sender_id',$user_id);
			})
			->orderBy('created_at','desc')->get();

	        if($Emp_messages->count()){
	            foreach($Emp_messages as $admin_employee){

	            	$uid = $admin_employee->sender_id;
	            	if($admin_employee->sender_id == $user_id){
						$uid = $admin_employee->reciever_id;
					}
    
	            	if(!in_array($uid, $Emp_ids)){
		            	$Employee = Fuser::find($uid);
		                $messages_list[] = $this->getMessagingList("Franchise Employee",$Employee->fullname, $Employee->id);
		                //$Emp_ids[] = $admin_employee->sender_id;
		                $Emp_ids[] = $uid;
					}
	            }
			}

	        //FRANCHISE EMPLOYEES
	        $Emp_ids[] = Auth::guard('franchise')->user()->id;
	        
	        if($request->get('search') != '')
	        {

				//$franchise_employees = Fuser::whereNotIn('id',$Emp_ids)->where('franchise_id',Auth::user()->franchise_id)->where('fullname','LIKE','%'.$request->get('search').'%')->get();
				/*$franchise_employees = Fuser::whereNotIn('id',$Emp_ids)->where('franchise_id',Auth::user()->franchise_id)->get();
		    
		        if($franchise_employees->count()){
		            foreach($franchise_employees as $franchise_employee){
		                $messages_list[] = $this->getMessagingList("Franchise Employee",$franchise_employee->fullname, $franchise_employee->id);
		            }
		        }*/
	        	
	        }else
	        {
				$admin_employees = Fuser::whereNotIn('id',$Emp_ids)->where('franchise_id',Auth::guard('franchise')->user()->franchise_id)->where('type','!=','Intern')->where('type','!=','Receptionist')->get();
		        /*if($admin_employees->count()){
		            foreach($admin_employees as $femployee){
		                $messages_list[] = $this->getMessagingList("Franchise Employee",$femployee->fullname, $femployee->id);
		            }
		        }*/
			}
	        
			/////////////////////////////////////////////////////////
			//GETTING CURRENT FRANCHISE ALL EMPLOYEE(STAFF) EMPLOYEES
			/////////////////////////////////////////////////////////	        			


			//////////////////////////////////////////
			//GETTING CURRENT FRANCHISE ALL EMPLOYEES
			//////////////////////////////////////////

	        $Emp_ids = array();
	        $Emp_messages = Messages::where('is_private', 1)
			->where('franchise_id',Auth::guard('franchise')->user()->franchise_id)
			->where(function ($query) use ($user_id){
				$query->where('reciever_id',$user_id)
				->where('sender_type','Employee')
				->where('message_to','Franchise Employee');
			})
			->orWhere(function ($query) use ($user_id){
				$query->where('sender_type','Franchise Employee')
				->where('message_to','Employee')
				->where('sender_id',$user_id);
			})
			->orderBy('created_at','desc')->get();

	        $Employee_ids = array();
	        if($Emp_messages->count()){
	            foreach($Emp_messages as $admin_employee){

	            	$uid = $admin_employee->sender_id;
	            	if($admin_employee->sender_id == $user_id){
						$uid = $admin_employee->reciever_id;
					}
    
	            	if(!in_array($uid, $Employee_ids)){
		            	$Employee = Employmentform::find($uid);
		                $messages_list[] = $this->getMessagingList("Employee",$Employee->personal_name, $Employee->id);
		                $Employee_ids[] = $uid;
					}
	            }
			}			

	        //FRANCHISE EMPLOYEES (TEACHERS)
	        /*$Employee_ids[] = Auth::guard('franchise')->user()->id;
	        $admin_employees = Employmentform::whereNotIn('id',$Employee_ids)->get();
	        if($admin_employees->count()){
	            foreach($admin_employees as $femployee){
	                $messages_list[] = $this->getMessagingList("Employee",$femployee->personal_name, $femployee->id);
	            }
	        }*/
			//////////////////////////////////////////
			//GETTING CURRENT FRANCHISE ALL EMPLOYEES
			//////////////////////////////////////////


			/////////////////////////////////////////////////////////
			//GETTING CURRENT FRANCHISE CLIENTS (PARENTS)
			/////////////////////////////////////////////////////////

	        $Parent_messages = Messages::where('is_private', 1)
			->where('franchise_id',Auth::guard('franchise')->user()->franchise_id)
			->where(function ($query) use ($user_id){
				$query->where('sender_id',$user_id)
				->where('sender_type','Franchise Employee')
				->where('message_to','Parent');
			})
			->orWhere(function ($query) use ($user_id){
				$query->where('sender_type','Parent')
				->where('message_to','Franchise Employee')
				->where('reciever_id',$user_id);
			})
			->orderBy('created_at','desc')->get();

	        $Parent_ids = array();
	        if($Parent_messages->count()){
	            foreach($Parent_messages as $parent){

	            	$uid = $parent->sender_id;
	            	if($parent->sender_id == $user_id){
						$uid = $parent->reciever_id;
					}

	            	if(!in_array($uid, $Parent_ids)){
		            	$Parent = Admissionform::find($uid);
		                $messages_list[] = $this->getMessagingList("Parent",$Parent->client_childfullname, $Parent->id);
		                $Parent_ids[] = $uid;
					}
	            }
			}
			
			/////////////////////////////////////////////////////////
			//GETTING CURRENT FRANCHISE ALL EMPLOYEE(STAFF) EMPLOYEES
			/////////////////////////////////////////////////////////
			
		}
		
        if($name != "") $messages = $this->getMessages(str_replace("_"," ",$name),$id);
        else $messages = FALSE;

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "inner_title"                           => $inner_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "messages_list"                         => $messages_list,
            "messenger_title"                       => $this->message_title($name,$id),
            "messages"                              => $messages,
            "send_message"                          => $send_message,
            "name"                                  => $name,
            "id"                                    => $id,
            "sender_id"                             => $sender_id,
            "sender_type"                           => $sender_type
        );

	    return view('franchise.message.list',$data);
    }

    public function getMessagingList($type = "Admin BCBA", $name = "", $id = "")
    {
        $message_title      = "BCBA";
        $receiver_id        = $id;
        $url                = "#";//route('admin.messages', ['id' => 1]);
        $unseen_messages    = 0;
        $last_message_time  = '';//date("h:i a | M d Y");
        $last_message       = "No Message";
        $message_image      = asset('assets/images/super-mess-icon.jpg');

        $user_id = Auth::guard('franchise')->user()->id;
        if($type == 'Admin Employee'){

			$messages = Messages::where(array('message_to'=>'Franchise Employee', 'sender_type'=>'Admin Employee', 'sender_id'=>$receiver_id, 'reciever_id'=>$user_id))->orderBy('created_at','desc')->first();
        
        }elseif($type == 'Administration'){
        	
    		$franchise_id = Auth::guard('franchise')->user()->franchise_id;
    		$franchise_created = Franchise::find($franchise_id)->created_at;
			$messages = Messages::where(array('message_to'=>'Administration', 'sender_type'=>'Franchise Employee'))->where('created_at','>',$franchise_created)->orderBy('created_at','desc')->first();
        	
        }elseif($type == 'Admin BCBA'){
        	
    		$franchise_id = Auth::guard('franchise')->user()->franchise_id;
			$messages = Messages::where(array('message_to'=>'Admin BCBA', 'sender_type'=>'Franchise Employee'))->orderBy('created_at','desc')->first();
        	
        }elseif($type == 'Franchise BCBA'){
        	
    		$franchise_id = Auth::guard('franchise')->user()->franchise_id;
			$messages = Messages::where(array('message_to'=>'Franchise BCBA', 'franchise_id'=>$franchise_id))->orderBy('created_at','desc')->first();
        	
        }elseif($type == 'Franchise Administration'){
    		
    		$franchise_id = Auth::guard('franchise')->user()->franchise_id;
			$messages = Messages::where(array('message_to'=>'Franchise Administration', 'franchise_id'=>$franchise_id))->orderBy('created_at','desc')->first();
        	
        }elseif($type == 'Franchise Employee'){
        	
    		$rcv_id = Auth::guard('franchise')->user()->id;
    		$sender_id = $receiver_id;
			$messages = Messages::where(array('message_to'=>'Franchise Employee', 'sender_type'=>'Franchise Employee', 'reciever_id'=> $rcv_id, 'sender_id'=>$sender_id ))->orderBy('created_at','desc')->first();
        	
        }elseif($type == 'Employee'){

    		$rcv_id = Auth::guard('franchise')->user()->id;
    		$sender_id = $receiver_id;
			$messages = Messages::where(array('message_to'=>'Franchise Employee', 'sender_type'=>'Employee', 'reciever_id'=> $rcv_id, 'sender_id'=>$sender_id ))->orderBy('created_at','desc')->first();
        	
        }elseif($type == 'Parent'){

    		$rcv_id = Auth::guard('franchise')->user()->id;
    		$sender_id = $receiver_id;
			$messages = Messages::where(array('message_to'=>'Franchise Employee', 'sender_type'=>'Parent', 'reciever_id'=> $rcv_id, 'sender_id'=>$sender_id ))->orderBy('created_at','desc')->first();
        	
        }else{
	        if($receiver_id != 0){
				$messages = Messages::where('message_to',$type)->where('reciever_id',$receiver_id)->OrderBy('created_at','DESC')->first();
	        }else{
	            $messages = Messages::where('message_to',$type)->OrderBy('created_at','DESC')->first();
	        }
		}

        if($type == "Admin BCBA"){
            $message_title  = "BCBA";
            $url            = route('franchise.messages', ['name' => "Admin_BCBA"]);
        }

        if($type == "Administration"){
            $message_title  = $type;
            $url            = route('franchise.messages', ['name' => $type]);
        }

        if($type == "Franchise Administration"){
            $message_title  = "Franchise Administration";
            $url            = route("franchise.messages", ["name" => "Franchise_Administration", "id" => $id]);
        }

        if($type == "Franchise BCBA"){
            $message_title  = "Franchise BCBA";
            $url            = route("franchise.messages", ["name" => "Franchise_BCBA", "id" => $id]);
        }

        if($type == "Admin Employee"){
            $message_title  = $name . " <br/> <span class='designation'>Admin Employee</span>";
            $url            = route("franchise.messages", ["name" => "Admin_Employee", "id" => $id]);
            $employee 		= Admin::find($id);
            if($employee->profile_picture) $message_image = $employee->profile_picture;
        }

        if($type == "Franchise Employee"){
            $message_title  = $name . " <br/> <span class='designation'> Franchise Employee</span>";
            $url            = route("franchise.messages", ["name" => "Franchise_Employee", "id" => $id]);
            $employee 		= Fuser::find($id);
            if($employee->profile_picture) $message_image = $employee->profile_picture;
        }

        if($type == "Employee"){
            $message_title  = $name . " <br/> <span class='designation'>Employee</span>";
            $url            = route("franchise.messages", ["name" => "Employee", "id" => $id]);
            $employee 		= Employmentform::find($id);
            if($employee->personal_picture) $message_image = $employee->personal_picture;
        }
        
		if($type == "Parent"){
            $message_title  = $name . " <br/> <span class='designation'>Client</span>";
            $url            = route("franchise.messages", ["name" => "Parent", "id" => $id]);
            $employee 		= Admissionform::find($id);
            if($employee->client_profilepicture) $message_image = $employee->client_profilepicture;
        }        

        if($type == "SOS Distributor"){
            $message_title  = $type;
            $url            = route("franchise.messages", ["name" => "SOS_Distributor"]);
        }

        if($type == "Director Of Operations"){
            $message_title  = $type;
            $url            = route("franchise.messages", ["name" => "Director_Of_Operations"]);
        }

        if($type == "Director Of Administration"){
            $message_title  = $type;
            $url            = route("franchise.messages", ["name" => "Director_Of_Administration"]);
        }

        if($type == "Human Resources"){
            $message_title  = $type;
            $url            = route("franchise.messages", ["name" => "Human_Resources"]);
        }


        if($messages){
        	$franchise_id = Auth::guard('franchise')->user()->franchise_id;
        	//echo $franchise_id;exit;
        	$u_id = Auth::guard('franchise')->user()->id;
            if($type == 'Franchise Administration')
            {
				$user_created = Fuser::find($u_id)->created_at;
				$all_messages = Messages::select("id")->where(array('message_to'=>'Franchise Administration', 'sender_type'=>'Employee', 'franchise_id'=>$franchise_id))->where('created_at','>',$user_created)->get();
			}
			elseif($type == 'Franchise BCBA')
			{
				$user_created = Fuser::find($u_id)->created_at;
				$all_messages = Messages::select("id")->where(array('message_to'=>'Franchise BCBA', 'sender_type'=>'Employee', 'franchise_id'=>$franchise_id))->where('created_at','>',$user_created)->get();
			}
			else{

	            if($receiver_id != 0){
		        	if($type == 'Admin Employee'){
		        		$emp_id = $receiver_id;
		        		$reciever = Auth::guard('franchise')->user()->id;
		        		$all_messages = Messages::select("id")->where(array('message_to'=>'Franchise Employee', 'sender_type'=>'Admin Employee', 'sender_id'=>$emp_id, 'reciever_id'=>$reciever))->get();
					
					}
					elseif($type == 'Admin BCBA')
					{
						$franchise_created = Franchise::find($franchise_id)->created_at;
						$all_messages = Messages::select("id")->where(array('message_to'=>'Admin BCBA', 'sender_type'=>'Franchise Employee', 'franchise_id'=>$franchise_id))->where('created_at','>',$franchise_created)->get();
						
					}elseif($type == 'Franchise Administration')
					{
						$user_created = Fuser::find($u_id)->created_at;
						$all_messages = Messages::select("id")->where(array('message_to'=>'Franchise Administration', 'sender_type'=>'Employee', 'franchise_id'=>$franchise_id))->where('created_at','>',$user_created)->get();
					}
					elseif($type == 'Franchise BCBA')
					{
						$user_created = Fuser::find($u_id)->created_at;
						$all_messages = Messages::select("id")->where(array('message_to'=>'Franchise BCBA', 'sender_type'=>'Employee', 'franchise_id'=>$franchise_id))->where('created_at','>',$user_created)->get();
					}
					elseif($type == 'Franchise Employee'){
						
		        		$emp_id = $receiver_id;
		        		$reciever = Auth::guard('franchise')->user()->id;
		        		$all_messages = Messages::select("id")->where(array('message_to'=>'Franchise Employee', 'sender_type'=>'Franchise Employee', 'sender_id'=>$emp_id, 'reciever_id'=>$reciever))->get();
						
					}elseif($type == 'Employee'){
						
		        		$emp_id = $receiver_id;
		        		$reciever = Auth::guard('franchise')->user()->id;
		        		$all_messages = Messages::select("id")->where(array('message_to'=>'Franchise Employee', 'sender_type'=>'Employee', 'sender_id'=>$emp_id, 'reciever_id'=>$reciever))->get();
						
					}elseif($type == 'Parent'){
						
		        		$emp_id = $receiver_id;
		        		$reciever = Auth::guard('franchise')->user()->id;
		        		$all_messages = Messages::select("id")->where(array('message_to'=>'Franchise Employee', 'sender_type'=>'Parent', 'sender_id'=>$emp_id, 'reciever_id'=>$reciever))->get();
						
					}else{
						$franchise_created = Franchise::find($franchise_id)->created_at;
		                $all_messages = Messages::select("id")->where('message_to',$type)->where('reciever_id',$receiver_id)->where('created_at','>',$franchise_created)->get();
					}    
	            }
	            else{
	                $all_messages = Messages::select("id")->where('message_to',$type)->get();
	            }
				
			}

            $total_messages     = $all_messages->count();
            $last_message       = $messages->message;
            $last_message_time  = date("h:i a | M d Y",strtotime($messages->created_at));

            if($total_messages > 0)
            {

	            $read_messages    = Messages_read_by::where('user_id',Auth::guard('franchise')->user()->id)->where('user_type','Franchise')->whereIn( "message_id", $all_messages->toArray() )->GroupBy("message_id")->get()->count();
	            $unseen_messages = $total_messages - $read_messages;
	            if($unseen_messages < 0) $unseen_messages = 0;
					
            }
        }

        $data = array(
            "title"             =>  $message_title,
            "url"               =>  $url,
            "last_message"      =>  $last_message,
            "last_message_time" =>  $last_message_time,
            "unseen_messages"   =>  $unseen_messages,
            "message_image"     =>  $message_image
        );

        return $data;
    }

    public function message_title($name="",$id=0)
    {
        $title = "Msg In A Bottle";

        if($name == "Administration") $title = "Administration";
        elseif($name == "Admin_BCBA") $title = "BCBA";
        elseif($name == "SOS_Distributor") $title = "SOS Distributor";
        elseif($name == "Director_Of_Operations") $title = "Director Of Operations";
        elseif($name == "Director_Of_Administration") $title = "Director Of Administration";
        elseif($name == "Human_Resources") $title = "Human Resources";
        elseif($name == "Franchise_Administration") $title = "Franchise Administration";
        elseif($name == "Franchise_BCBA") $title = "Franchise BCBA";
        elseif($name == "Admin_Employee"){
            $admin_employee = Admin::find($id);
            $title          = $admin_employee->fullname . " | Admin Employee";
        }
        elseif($name == "Employee"){
            $employee = Employmentform::find($id);
            $title          = $employee->personal_name . " | Employee";
        }
        elseif($name == "Franchise_Employee"){
            $Femployee = Fuser::find($id);
            $title          = $Femployee->fullname . " | Franchise Employee";
        }
        elseif($name == "Parent"){
            $client = Admissionform::find($id);
            $title  = $client->client_childfullname . " | Client";
        }        

        return $title;
    }

    public function getMessages($name="",$id=0)
    {
        $messages       = array();
        $franchise_id   = 0;
        $F_employee_id  = 0;

        if($name == "Franchise Administration" || $name == "Franchise BCBA")
            $franchise_id = Auth::guard('franchise')->user()->franchise_id;
            
        $allowed_sender = array('Administration','Franchise Administration','Admin BCBA','Franchise BCBA','Admin Employee','Franchise Employee','SOS Distributor','Employee','Parent','Director Of Operations','Director Of Administration','Human Resources');

        if(in_array($name,$allowed_sender))
        {
            //Messages list for private chat between employee and current franchise
            if($name == 'Admin Employee'){
            	$F_employee_id = Auth::guard('franchise')->user()->id;
            	$Admin_employee_id = $id;
            	$all_messages = Messages::where("is_private",1)
	            ->where(function ($query) use ($Admin_employee_id, $F_employee_id) {
	                $query->where(array('reciever_id'=> $F_employee_id, 'franchise_id'=> Auth::guard('franchise')->user()->franchise_id, 'sender_id'=> $Admin_employee_id, 'message_to'=> 'Franchise Employee', 'sender_type'=> 'Admin Employee'));
	            })
	            ->orWhere(function ($query) use ($Admin_employee_id, $F_employee_id) {
	            	$query->where(array('reciever_id'=> $Admin_employee_id, 'sender_id'=> $F_employee_id, 'franchise_id'=>0, 'sender_type'=> 'Franchise Employee', 'message_to'=> 'Admin Employee'));
	            })->orderBy("created_at","ASC")->get();
			
			
			//MESSAGES OF ADMIN BCBA	
			}elseif($name == 'Admin BCBA'){
            	
            	$all_messages = Messages::where("is_private",0)
	            ->where(function ($query) use ($name) {
	                $query->where(array('sender_type'=> 'Franchise Employee', 'message_to'=> $name));
	            })->orderBy("created_at","ASC")->get();
			
			//MESSAGES OF FRANCHISE ADMINISTRATION	
			}elseif($name == 'Franchise Administration'){
            	$all_messages = Messages::where("is_private",0)
	            ->where(function ($query) use ($name) {
	                $query->where(array('message_to'=> $name, 'franchise_id'=>Auth::guard('franchise')->user()->franchise_id ));
	            })->orderBy("created_at","ASC")->get();
			
			//MESSAGES OF FRANCHISE BCBA	
			}elseif($name == 'Franchise BCBA'){
            	$all_messages = Messages::where("is_private",0)
	            ->where(function ($query) use ($name) {
	                $query->where(array('message_to'=> $name, 'franchise_id'=>Auth::guard('franchise')->user()->franchise_id ));
	            })->orderBy("created_at","ASC")->get();
			
			//MESSAGES OF TEACHERS	
			}elseif($name == 'Employee'){
            	$F_employee_id = Auth::guard('franchise')->user()->id;
            	$Admin_employee_id = $id;
            	$all_messages = Messages::where("is_private",1)
	            ->where(function ($query) use ($Admin_employee_id, $F_employee_id) {
	                $query->where(array('reciever_id'=> $F_employee_id, 'franchise_id'=> Auth::guard('franchise')->user()->franchise_id, 'sender_id'=> $Admin_employee_id, 'message_to'=> 'Franchise Employee', 'sender_type'=> 'Employee'));
	            })
	            ->orWhere(function ($query) use ($Admin_employee_id, $F_employee_id) {
	            	$query->where(array('reciever_id'=> $Admin_employee_id, 'sender_id'=> $F_employee_id, 'sender_type'=> 'Franchise Employee', 'message_to'=> 'Employee'));
	            })->orderBy("created_at","ASC")->get();
	            	
			//MESSAGE OF FRANCHISE CLIENTS (PARENTS)
			}elseif($name == 'Parent'){
            	$F_employee_id = Auth::guard('franchise')->user()->id;
            	$Admin_employee_id = $id;
            	$all_messages = Messages::where("is_private",1)
	            ->where(function ($query) use ($Admin_employee_id, $F_employee_id) {
	                $query->where(array('reciever_id'=> $F_employee_id, 'franchise_id'=> Auth::guard('franchise')->user()->franchise_id, 'sender_id'=> $Admin_employee_id, 'message_to'=> 'Franchise Employee', 'sender_type'=> 'Parent'));
	            })
	            ->orWhere(function ($query) use ($Admin_employee_id, $F_employee_id) {
	            	$query->where(array('reciever_id'=> $Admin_employee_id, 'sender_id'=> $F_employee_id, 'sender_type'=> 'Franchise Employee', 'message_to'=> 'Parent'));
	            })->orderBy("created_at","ASC")->get();
	            	
			//MESSAGE OF FRANCHISE STAFF (EMPLOYEES)
			}elseif($name == 'Franchise Employee'){
            	$F_employee_id = Auth::guard('franchise')->user()->id;
            	$Admin_employee_id = $id;
            	$all_messages = Messages::where("is_private",1)
	            ->where(function ($query) use ($Admin_employee_id, $F_employee_id) {
	                $query->where(array('reciever_id'=> $F_employee_id, 'franchise_id'=> Auth::guard('franchise')->user()->franchise_id, 'sender_id'=> $Admin_employee_id, 'message_to'=> 'Franchise Employee', 'sender_type'=> 'Franchise Employee'));
	            })
	            ->orWhere(function ($query) use ($Admin_employee_id, $F_employee_id) {
	            	$query->where(array('reciever_id'=> $Admin_employee_id, 'sender_id'=> $F_employee_id, 'sender_type'=> 'Franchise Employee', 'message_to'=> 'Franchise Employee'));
	            })->orderBy("created_at","ASC")->get();

			//MESSAGE OF FRANCHISE CLIENTS 
			}elseif($name == 'Parent'){
            	$F_employee_id = Auth::guard('franchise')->user()->id;
            	$Admin_employee_id = $id;
            	$all_messages = Messages::where("is_private",1)
	            ->where(function ($query) use ($Admin_employee_id, $F_employee_id) {
	                $query->where(array('reciever_id'=> $F_employee_id, 'franchise_id'=> Auth::guard('franchise')->user()->franchise_id, 'sender_id'=> $Admin_employee_id, 'message_to'=> 'Franchise Employee', 'sender_type'=> 'Parent'));
	            })
	            ->orWhere(function ($query) use ($Admin_employee_id, $F_employee_id) {
	            	$query->where(array('reciever_id'=> $Admin_employee_id, 'sender_id'=> $F_employee_id, 'sender_type'=> 'Franchise Employee', 'message_to'=> 'Parent'));
	            })->orderBy("created_at","ASC")->get();
	            	
			}else{
	            //This message for administrator group
	            if($franchise_id != 0){
	                $all_messages = Messages::where('message_to',$name)->where("franchise_id",$franchise_id)->orderBy("created_at","ASC")->get();
	            }
	            else{
	                $all_messages = Messages::where('message_to',$name)->orderBy("created_at","ASC")->get();
	            }
			}
            

            if( $all_messages->count() )
            {
                foreach($all_messages as $msg)
                {
                    $user 			   = array();	
					$sender             = array();
                    $message_time       = date("h:i a | M d Y",strtotime($msg->created_at));
                    $message_read       = Messages_read_by::where('user_id',Auth::guard('franchise')->user()->id)->where('user_type','Franchise')->where( "message_id", $msg->id )->get()->count();
                    $my_reply           = FALSE;

                    $channels = array('Administration','Admin BCBA','SOS Distributor','Director Of Operations','Director Of Administration','Human Resources');
                    
                    //if($msg->sender_id == Auth::guard('franchise')->user()->franchise_id && $msg->sender_type == "Franchise Administration" ) $my_reply = TRUE;
                    if($msg->sender_id == Auth::guard('franchise')->user()->id && $msg->sender_type == "Franchise Employee" ) $my_reply = TRUE;
                    if($msg->sender_id == Auth::guard('franchise')->user()->id && $msg->sender_type == "Franchise BCBA" ) $my_reply = TRUE;

                    //if($msg->sender_type == "Franchise Administration") $user = Franchise::find($msg->sender_id);
                    if($msg->sender_type == "Franchise Employee" || $msg->sender_type == 'Franchise BCBA') $user = Fuser::find($msg->sender_id);
                    if($msg->sender_type == "Admin Employee") $user = Admin::find($msg->sender_id);
                    if($msg->sender_type == "Administration" || $msg->sender_type == "Admin Employee") $user = Admin::find($msg->sender_id);
                    if($msg->sender_type == "Employee") $user = Employmentform::find($msg->sender_id);
                    if($msg->sender_type == "Parent") $user = Admissionform::find($msg->sender_id);

                    $sender["id"]       =  $user->id;
                    $sender["name"]     =  isset($user->location) ? $user->location : $user->fullname;
                    
                    //SETING NAME WITH FRANCHISE NAME
                    if(in_array($name,$channels)) 		$sender["name"] = $user->fullname . " (".$user->type.') | '. Franchise::find($user->franchise_id)->location;
                    if($msg->sender_type == "Parent") 	$sender["name"] = isset($user->client_childfullname) ? $user->client_childfullname.' | Client' : '';
                    if($msg->sender_type == "Employee") $sender["name"] = isset($user->personal_name) ? $user->personal_name.' | Employee' : '';
                    
                    if(isset($user->profile_picture) || isset($user->personal_picture) || isset($user->client_profilepicture)){

                        if($msg->sender_type == "Employee") $sender["image"]    =  ($user->personal_picture) ? asset($user->personal_picture) : asset('assets/images/super-mess-icon.jpg');
                        elseif($msg->sender_type == "Parent") $sender["image"] = ($user->client_profilepicture) ? asset($user->client_profilepicture) : asset('assets/images/super-mess-icon.jpg');
                        else $sender["image"] = ($user->profile_picture) ? asset($user->profile_picture) : asset('assets/images/super-mess-icon.jpg');

                    }else{
                        $sender["image"]    =  asset('assets/images/super-mess-icon.jpg');
                    }
                    $sender["type"]     =  $msg->sender_type;

                    if($msg->reciever_id != Auth::guard('franchise')->user()->id || $msg->sender_type != "Administration")
                        $sender["reply_url"] = route("franchise.messages", ["name" => str_replace(" ","_",$msg->sender_type), "id" => $user->id]);

                    $messages[] = array(
                        "message_id"        =>  $msg->id,
                        "message_from"      =>  $sender,
                        "message"           =>  $msg->message,
                        "file"           	=>  $msg->file,
                        "message_read"      =>  $message_read,
                        "message_time"      =>  $message_time,
                        "my_reply"          =>  $my_reply,
                    );
                }
            }
        }

        return $messages;
    }

    public function send_message(SendMessage $request)
    {
        $franchise_id   = 0;

        $users_allow = array("Franchise Administration","Franchise BCBA","Franchise Employee","Parent","Admin BCBA", "Employee");
        if(in_array($request->message_to,$users_allow))
            $franchise_id = Auth::guard('franchise')->user()->franchise_id;
            
        $private = array("Franchise Employee","Parent", "Employee", 'Admin Employee');    

        $new_message                    = new Messages();
        $new_message->sender_id         = $request->sender_id;
        $new_message->sender_type       = $request->sender_type;
        $new_message->reciever_id       = $request->reciever_id;
        $new_message->message_to        = $request->message_to;
        $new_message->message           = $request->message;
        if(in_array($request->message_to,$private)){
        	$new_message->is_private = 1;			
		}
        $new_message->franchise_id      = $franchise_id;
        $new_message->save();

        $message_read_by                = new Messages_read_by();//::where('user_id',Auth::guard('franchise')->user()->id)->where('user_type','Admin')->whereIn( "message_id", $all_messages->toArray() )->GroupBy("message_id")->get()->count();
        $message_read_by->message_id    = $new_message->id;
        $message_read_by->user_id       = Auth::guard('franchise')->user()->id;
        $message_read_by->user_type     = 'Franchise';
        $message_read_by->save();

        Session::flash('Success','<div class="alert alert-success">Message Sent successfully!</div>');
        return redirect()->back();
    }

    public function message_status($type="",$id=0)
    {
        if($type == "" || $id == 0)
        {
            return redirect()->back();
        }
        else
        {
            $data = array(
                "message_id"    =>  $id,
                "user_type"     =>  "Franchise",
                "user_id"       =>  Auth::guard('franchise')->user()->id,
            );
            if($type == "read"){
                Messages_read_by::insert($data);
            }
            elseif($type == "unread"){
                Messages_read_by::where($data)->delete();
            }


            return redirect()->back();
        }
    }
}