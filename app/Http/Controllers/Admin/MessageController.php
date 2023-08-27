<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Session;
use App\Http\Requests\Admin\Message\SendMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

//Models
use App\Models\Admin;
use App\Models\Franchise;
use App\Models\Franchise\Fuser;
use App\Models\Admins_employees;
use App\Models\Messages;
use App\Models\Messages_read_by;

class MessageController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard('admin')->user();
		$users[] = Auth::guard('admin')->user();
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
        $sender_id          = Auth::guard('admin')->user()->id;
        $sender_type        = "Admin Employee";
        if(Auth::guard('admin')->user()->type == 'Employee') $sender_type = "Admin Employee";

        $channels = array('Administration','Admin_BCBA','SOS_Distributor','Director_Of_Operations','Director_Of_Administration','Human_Resources');
        if(in_array($name,$channels)) $send_message = FALSE;

        /*$messages_list[] = $this->getMessagingList("Administration");
        $messages_list[] = $this->getMessagingList("Admin BCBA");*/
        $messages_list[] = $this->getMessagingList("Director Of Operations");
        $messages_list[] = $this->getMessagingList("Director Of Administration");
        $messages_list[] = $this->getMessagingList("Human Resources");
        $messages_list[] = $this->getMessagingList("SOS Distributor");
        
        //Message Mark as read
    	$messages = Messages::where("is_private",1)
		->where(function ($query) use ($id) {
			$query->where(array('reciever_id'=> Auth::user()->id, 'sender_id'=> $id, 'message_to'=> 'Admin Employee'));	
		})->get();
        
	    if($messages->count())
	    {
	      foreach($messages as $message)
	      {
				Messages_read_by::insert(array(
				    "message_id"    =>  $message->id,
				    "user_type"     =>  "Admin",
				    "user_id"       =>  Auth::user()->id
				));
	      }
		}  
		//Messages mark as read code end here 

		//GEt messages of admin
        $user_id = Auth::guard('admin')->user()->id;
        $users = Messages::where('is_private', 1)
        		->where(function ($query) use ($user_id) {
        			$query->where('message_to','=','Admin Employee');
        			$query->where('sender_type','=','Franchise Employee');
        			$query->where('reciever_id','=',$user_id);
        		})->orWhere(function ($query2) use ($user_id) {
        			$query2->where('sender_id','=', $user_id);
        			$query2->where('message_to','=','Franchise Employee');
        			$query2->where('sender_type','=','Admin Employee');
        		})
        		->orderBy('created_at','desc')->get();
        		
        $user_ids = array();
        if($users->count()){
            foreach($users as $user){
            	$uid = $user->sender_id;
            	if($user->message_to == 'Franchise Employee'){
					$uid = $user->reciever_id;
				}
                if(!in_array($uid,$user_ids)){
					$user_ids[] = $uid;
				}
            }
        }

        //All Franchise Employees who messaged to admin employees
        if(!empty($user_ids)){
	        foreach($user_ids as $u_id){
		        $F_employee = Fuser::find($u_id);
		        if(isset($F_employee))  $messages_list[] = $this->getMessagingList("Franchise Employee",$F_employee->fullname, $F_employee->id);
			}
		}

        //Getting latest messages who messaged to admin employee
        $Emp_ids = array();
        $adminEmp_messages = Messages::where("is_private",1)
        ->where(function ($query) use ($user_id) {
        
        	$query->where(array('reciever_id' => $user_id,'sender_type'=>'Admin Employee', 'message_to'=>'Admin Employee','is_private' => 1));
        
		})->orWhere(function ($query) use ($user_id) {
			
        	$query->where(array('sender_id' => $user_id, 'sender_type'=>'Admin Employee', 'message_to'=>'Admin Employee','is_private' => 1));
		
		})->orderBy('updated_at','desc')->get();


        $adminEmpIds = array();
        if($adminEmp_messages->count())
        {
            foreach($adminEmp_messages as $admin_employee){
            	
        		if($admin_employee->sender_id == $user_id){
        			if(!in_array($admin_employee->reciever_id, $Emp_ids)){
		            	$Employee = Admin::find($admin_employee->reciever_id);
						/*$messages_list[] = $this->getMessagingList("Admin Employee",$Employee->fullname, $Employee->id);
		                $Emp_ids[] = $Employee->id;*/
						if(isset($Employee))
						{
		                	$messages_list[] = $this->getMessagingList("Admin Employee",$Employee->fullname, $Employee->id);
		                	$Emp_ids[] = $Employee->id;
						}
					}
				}else{
	            	if(!in_array($admin_employee->sender_id, $Emp_ids)){
		            	$Employee = Admin::find($admin_employee->sender_id);
		                /*$messages_list[] = $this->getMessagingList("Admin Employee",$Employee->fullname, $Employee->id);
		                $Emp_ids[] = $Employee->id;*/
						if(isset($Employee))
						{
		                	$messages_list[] = $this->getMessagingList("Admin Employee",$Employee->fullname, $Employee->id);
		                $Emp_ids[] = $Employee->id;
						}
					}
				}
				
            }
		}

        //Admin employees
        $Emp_ids[] = Auth::guard('admin')->user()->id;
        if($request->get('search') != '')
        {

			//$admin_employees = Admin::whereNotIn('id',$Emp_ids)->where('fullname','LIKE','%'.$request->get('search').'%')->get();
			/*$admin_employees = Admin::whereNotIn('id',$Emp_ids)->get();
        
	        if($admin_employees->count()){
	            foreach($admin_employees as $admin_employee){
	            	$messages_list[] = $this->getMessagingList("Admin Employee",$admin_employee->fullname, $admin_employee->id);
	            }
	        }*/
		}
		else
		{
			$admin_employees = Admin::whereNotIn('id',$Emp_ids)->get();
		}


		
        if($name != "") $messages = $this->getMessages(str_replace("_"," ",$name),$id);
        else $messages = FALSE;

        $Employees = Admin::where('id','!=',Auth::user()->id)->where('employee_status','1')->get();
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
            "sender_type"                           => $sender_type,
            "Employees"                           	=> $Employees
        );
		//DB::table('messages')->where('id', '!=', 0)->delete();
		//DB::table('messages_read_by')->where('id', '!=', 0)->delete();	
	    return view('admin.message.list',$data);
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

        if($type == 'Admin BCBA'){
        	
        	$employee_id = Auth::guard('admin')->user()->id;
        	$messages = Messages::where(array('sender_type'=>'Franchise Employee', 'message_to'=>'Admin BCBA'))->OrderBy('created_at','DESC')->first();
        	
        }elseif($type == 'Admin Employee'){
        	
        	$employee_id = Auth::guard('admin')->user()->id;
        	$messages = Messages::where('sender_type',$type)->where(array('sender_id'=>$receiver_id, 'reciever_id'=>$employee_id, 'message_to'=>'Admin Employee'))->OrderBy('created_at','DESC')->first();
        	
        }elseif($type == 'Franchise Employee'){
        	
        	$employee_id = Auth::guard('admin')->user()->id;
        	$messages = Messages::where('sender_type',$type)->where(array('sender_id'=>$receiver_id, 'reciever_id'=>$employee_id))->OrderBy('created_at','DESC')->first();
        	
        }else{
	        if($receiver_id != 0){
	        	$messages = Messages::where('message_to',$type)->where('reciever_id',$receiver_id)->OrderBy('created_at','DESC')->first();
	        }else{
	            $messages = Messages::where('message_to',$type)->OrderBy('created_at','DESC')->first();
	        }
		}

        if($type == "Admin BCBA"){
            $message_title  = "BCBA";
            $url            = route('admin.messages', ['name' => "Admin_BCBA"]);
        }

        if($type == "Administration"){
            $message_title  = $type;
            $url            = route('admin.messages', ['name' => $type]);
        }

        if($type == "Franchise Administration"){
            $message_title  = $name . " | Franchise Administration";
            $url            = route("admin.messages", ["name" => "Franchise_Administration", "id" => $id]);
        }

        if($type == "Franchise BCBA"){
            $message_title  = $name . " | BCBA";
            $url            = route("admin.messages", ["name" => "Franchise_BCBA", "id" => $id]);
        }

        if($type == "Admin Employee"){
            $message_title  = $name . ' | Admin Employee';
            $url            = route("admin.messages", ["name" => "Admin_Employee", "id" => $id]);
            $Admin_employee = Admin::find($id);
            if($Admin_employee->profile_picture) $message_image = $Admin_employee->profile_picture;
        }

        if($type == "Franchise Employee"){
        	$franchise = Franchise::find(Fuser::find($id)->franchise_id);
            $message_title  = $name . " | ".$franchise->location;
            $url            = route("admin.messages", ["name" => "Franchise_Employee", "id" => $id]);
            $Fuser = Fuser::find($id);
            if($Fuser->profile_picture) $message_image = $Fuser->profile_picture;
        }

        if($type == "SOS Distributor"){
            $message_title  = $type;
            $url            = route("admin.messages", ["name" => "SOS_Distributor"]);
        }

        if($type == "Director Of Operations"){
            $message_title  = $type;
            $url            = route("admin.messages", ["name" => "Director_Of_Operations"]);
        }

        if($type == "Director Of Administration"){
            $message_title  = $type;
            $url            = route("admin.messages", ["name" => "Director_Of_Administration"]);
        }

        if($type == "Human Resources"){
            $message_title  = $type;
            $url            = route("admin.messages", ["name" => "Human_Resources"]);
        }

        if($messages){
        	
            if($type == "Franchise Employee"){
				$all_messages = Messages::select("id")
								->where(array('reciever_id'=>Auth::guard('admin')->user()->id, 'sender_id'=>$receiver_id, 'message_to'=>'Admin Employee', 'sender_type'=>$type))->get();
			}elseif($type == "Admin BCBA"){
				$all_messages = Messages::select("id")
								->where(array('message_to'=>'Admin BCBA', 'sender_type'=>'Franchise Employee'))->get();
			}else{
	            if($receiver_id != 0){
	                $all_messages = Messages::select("id")->where('message_to',$type)->where(array('reciever_id'=>Auth::guard('admin')->user()->id, 'sender_id'=>$receiver_id))->get();
	            }else{
	                $all_messages = Messages::select("id")->where('message_to',$type)->get();
	            }
	            //echo $type;
			}
			
            $total_messages     = $all_messages->count();
            $last_message       = $messages->message;
            $last_message_time  = ($messages->created_at ? date("h:i a | M d Y",strtotime($messages->created_at)) : '');

            if($total_messages > 0){
            	$user_id = Auth::guard('admin')->user()->id;
                $read_messages    = Messages_read_by::where('user_id',$user_id)
                					->where('user_type','Admin')
                					->whereIn( "message_id", $all_messages->toArray())
                					->GroupBy("message_id")->get()->count();
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
            "message_image"     =>  $message_image,
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
        elseif($name == "Franchise_Administration"){
            $franchise      = Franchise::find($id);
            $title          = $franchise->name . " | Franchise Administration";
        }elseif($name == "Franchise_BCBA"){
            $franchise      = Franchise::find($id);
            $title          = $franchise->name . " | BCBA";
        }elseif($name == "Franchise_Employee"){
            $F_employee     = Fuser::find($id);
			/*if($F_employee->profile_picture){
				$title = '<img class="msgUserImg" src="'.$F_employee->profile_picture.'" > '.$F_employee->fullname . " | Franchise Employee";
			}else{
				$title = '<img class="msgUserImg" src="'.asset('assets/images/super-mess-icon.jpg').'" > '.$F_employee->fullname . " | Franchise Employee";
			}*/
			if(isset($F_employee))
			{
				if($F_employee->profile_picture){
					$title = '<img class="msgUserImg" src="'.$F_employee->profile_picture.'" > '.$F_employee->fullname . " | Franchise Employee";
				}else{
					$title = '<img class="msgUserImg" src="'.asset('assets/images/super-mess-icon.jpg').'" > '.$F_employee->fullname . " | Franchise Employee";
				}
			}
        }elseif($name == "Admin_Employee"){
            $admin_employee = Admin::find($id);
            /*if($admin_employee->profile_picture){
				$title = '<img class="msgUserImg" src="'.$admin_employee->profile_picture.'" > '.$admin_employee->fullname." | Admin Employee";
			}else{
				$title = '<img class="msgUserImg" src="'.asset('assets/images/super-mess-icon.jpg').'" > '.$admin_employee->fullname." | Admin Employee";
			}*/
            if(isset($admin_employee))
			{
				if($admin_employee->profile_picture){
					$title = '<img class="msgUserImg" src="'.$admin_employee->profile_picture.'" > '.$admin_employee->fullname." | Admin Employee";
				}else{
					$title = '<img class="msgUserImg" src="'.asset('assets/images/super-mess-icon.jpg').'" > '.$admin_employee->fullname." | Admin Employee";
				}
			}
        }

        return $title;
    }

    public function getMessages($name="",$id=0)
    {
        $messages       = array();
        $franchise_id   = 0;
        $F_employee_id  = 0;

        if($name == "Franchise Administration" || $name == "Franchise BCBA")
            $franchise_id                   = $id;
            
        if($name == "Franchise Employee")
        	$F_employee_id = $id;
        
        $allowed_sender = array('Administration','Franchise Administration','Admin BCBA','Franchise BCBA','Admin Employee','Franchise Employee','SOS Distributor','Parent','Director Of Operations','Director Of Administration','Human Resources');

        if(in_array($name,$allowed_sender))
        {
            //Messages list for private chat between employee and current franchise
			if($name == 'Franchise Employee'){
				
				//Admin Employee to Franchise Employee messages
				$employee_id = Auth::guard('admin')->user()->id;
				$user_id = $id;
				$all_messages = Messages::where("is_private",1)
	            ->where(function ($query) use ($employee_id, $user_id) {
	                $query->where(array('reciever_id'=> $user_id, 'sender_id'=> $employee_id, 'message_to'=> 'Franchise Employee', 'sender_type'=>'Admin Employee'));
	            })->orWhere(function ($query) use ($employee_id, $user_id) {
	            	$query->where(array('reciever_id'=> $employee_id, 'sender_id'=> $user_id, 'franchise_id'=>0, 'sender_type'=> 'Franchise Employee', 'message_to'=> 'Admin Employee'));
	            })->orderBy("created_at","ASC")->get();
				
			}elseif($name == 'Admin Employee'){

				//Admin Employee to Admin Employee messages
				$employee_id = Auth::guard('admin')->user()->id;
				$otherEmp_id = $id;
				$all_messages = Messages::where("is_private",1)
	            ->where(function ($query) use ($employee_id, $otherEmp_id) {
	                $query->where(array('reciever_id'=> $otherEmp_id, 'sender_id'=> $employee_id, 'message_to'=> 'Admin Employee', 'sender_type'=>'Admin Employee'));
	            })->orWhere(function ($query) use ($employee_id, $otherEmp_id) {
	            	$query->where(array('reciever_id'=> $employee_id, 'sender_id'=> $otherEmp_id, 'franchise_id'=>0, 'sender_type'=> 'Admin Employee', 'message_to'=> 'Admin Employee'));
	            })->orderBy("created_at","ASC")->get();
				
			}elseif($name == 'Admin BCBA'){
				
				//$user_created = Admin::find(Auth::guard('admin')->user()->id)->created_at;
				$user_created = "0000-00-00 00:00:00";
				if(!empty(Admin::find(Auth::guard('admin')->user()->id)->created_at))$user_created = Admin::find(Auth::guard('admin')->user()->id)->created_at;
				$all_messages = Messages::where("is_private",0)->where(array('message_to'=> 'Admin BCBA', 'sender_type'=>'Franchise Employee'))->where('created_at','>',$user_created)->orderBy("created_at","ASC")->get();
				
			}else{
	            //This message for administrator group
	            $user_created = Admin::find(Auth::guard('admin')->user()->id)->created_at;
	            if($franchise_id != 0){
	                $all_messages       = Messages::where('message_to',$name)->where("franchise_id",$franchise_id)->where()->where('is_private','0')->orderBy("created_at","ASC")->get();
	            }else{
	                $all_messages       = Messages::where('message_to',$name)->orderBy("created_at","ASC")->get();
	            }
			}

            if( $all_messages->count() )
            {
                foreach($all_messages as $msg)
                {
                    $sender             = array();
                    $message_time       = date("h:i a | M d Y",strtotime($msg->created_at));
                    $message_read       = Messages_read_by::where('user_id',Auth::guard('admin')->user()->id)->where('user_type','Admin')->where( "message_id", $msg->id )->get()->count();
                    $my_reply           = FALSE;

                    if($name == 'Franchise Administration'){
                    	if($msg->sender_id == Auth::guard('admin')->user()->id && $msg->sender_type == "Admin Employee") $my_reply = TRUE;
                    }elseif($name == 'Franchise Employee'){
						if($msg->sender_id == Auth::guard('admin')->user()->id && $msg->sender_type == "Admin Employee") $my_reply = TRUE;
					}elseif($name == 'Admin Employee'){
						if($msg->sender_id == Auth::guard('admin')->user()->id && $msg->sender_type == "Admin Employee") $my_reply = TRUE;
					}elseif($name == 'Admin BCBA'){
						if($msg->sender_id == Auth::guard('admin')->user()->id && $msg->sender_type == "Admin BCBA") $my_reply = TRUE;
					}else{
						if($msg->sender_id == Auth::guard('admin')->user()->id && $msg->sender_type == "Administration") $my_reply = TRUE;
					}

                    if($msg->sender_type == "Franchise Employee" || $msg->sender_type == 'Franchise BCBA') $user = Fuser::find($msg->sender_id);
                    if($msg->sender_type == "Administration" || $msg->sender_type == "Admin Employee") $user = Admin::find($msg->sender_id);

                    $sender["id"]       =  $user->id;
                    $sender["name"]     =  isset($user->name) ? $user->name : $user->fullname;
                    
                    if($name == "Administration" || $name == "Admin BCBA") $sender["name"] = $user->fullname . " (".$user->type.') | '. Franchise::find($user->franchise_id)->location;
                   
                    //GETTING PROFILE PICTURE OF USER
                    if(isset($user->profile_picture)){
                        $sender["image"]    =  ($user->profile_picture) ? asset($user->profile_picture) : asset('assets/images/super-mess-icon.jpg');
                    }else{
                        $sender["image"]    =  asset('assets/images/super-mess-icon.jpg');
                    }
                    $sender["type"]     =  $msg->sender_type;

                    if($msg->sender_id != Auth::guard('admin')->user()->id || $msg->sender_type != "Administration")
                        $sender["reply_url"] = route("admin.messages", ["name" => str_replace(" ","_",$msg->sender_type), "id" => $user->id]);

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

        //echo '<pre>';print_r($messages);exit;
        return $messages;
    }

    public function send_message(SendMessage $request)
    {
    	//echo '<pre>';print_r($request->reciever_id);exit;
        $franchise_id                   = 0;
               
        if($request->message_to == "Franchise Administration" || $request->message_to == "Franchise BCBA")
            $franchise_id = $request->reciever_id;
		
		if($request->message_to == "Franchise Employee")
			$franchise_id = Fuser::find($request->reciever_id)->franchise_id;
		
		//
        if(is_array($request->reciever_id) && !empty($request->reciever_id))
        {
        	foreach($request->reciever_id as $reciever_id)
        	{
			    $new_message                    = new Messages();
			    $new_message->sender_id         = Auth::user()->id;
			    $new_message->sender_type       = $request->sender_type;
			    $new_message->reciever_id       = $reciever_id;
			    $new_message->message_to        = $request->message_to;
			    $new_message->message           = $request->message;
			    $new_message->franchise_id      = 0;
			    $new_message->is_private = 1;
			    $new_message->save();
				
		        $message_read_by                = new Messages_read_by();//::where('user_id',Auth::guard('admin')->user()->id)->where('user_type','Admin')->whereIn( "message_id", $all_messages->toArray() )->GroupBy("message_id")->get()->count();
		        $message_read_by->message_id    = $new_message->id;
		        $message_read_by->user_id       = Auth::guard('admin')->user()->id;
		        $message_read_by->user_type     = 'Admin';
		        $message_read_by->save();
			}
		}
		else
		{
	        $new_message                    = new Messages();
	        $new_message->sender_id         = $request->sender_id;
	        $new_message->sender_type       = $request->sender_type;
	        $new_message->reciever_id       = $request->reciever_id;
	        $new_message->message_to        = $request->message_to;
	        $new_message->message           = $request->message;
	        $new_message->franchise_id      = $franchise_id;
	        if($request->message_to == 'Admin Employee' || $request->message_to == 'Franchise Employee') $new_message->is_private = 1;
	        $new_message->save();

	        if($request->img)
	        {
	            $file_storage   = 'public/messages_files/'.$new_message->id;

	            $put_data                = Storage::put($file_storage, $request->img);
	            $full_path               = Storage::url($put_data);
	            $new_message->file       = $full_path;
	            $new_message->save();
	        }

	        $message_read_by                = new Messages_read_by();//::where('user_id',Auth::guard('admin')->user()->id)->where('user_type','Admin')->whereIn( "message_id", $all_messages->toArray() )->GroupBy("message_id")->get()->count();
	        $message_read_by->message_id    = $new_message->id;
	        $message_read_by->user_id       = Auth::guard('admin')->user()->id;
	        $message_read_by->user_type     = 'Admin';
	        $message_read_by->save();				
		}
        
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
                "user_type"     =>  "Admin",
                "user_id"       =>  Auth::guard('admin')->user()->id
            );
            if($type == "read")
            {
                Messages_read_by::insert($data);
            }
            elseif($type == "unread")
            {
                Messages_read_by::where($data)->delete();
            }


            return redirect()->back();
        }
    }
}