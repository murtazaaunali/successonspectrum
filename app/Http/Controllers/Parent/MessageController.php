<?php

namespace App\Http\Controllers\Parent;

use Illuminate\Http\Request;
use Session;
use App\Http\Requests\Franchise\Message\SendMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Admin;
use App\Models\Messages;
use App\Models\Franchise;
use App\Models\Franchise\Fuser;
use App\Models\Messages_read_by;
use App\Models\Frontend\Admissionform;
use App\Models\Frontend\Employmentform;

class MessageController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard()->user();
		$users[] = Auth::guard('parent')->user();
	}


    public function index($name = "", $id = 0)
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
        $sender_id          = Auth::guard('parent')->user()->id;
        $sender_type 		= "Parent";

		$messages_list[] = $this->getMessagingList("Franchise Administration");
	    $messages_list[] = $this->getMessagingList("Franchise BCBA");
        
        $user_type = Auth::guard('parent')->user()->type;

        $user_id = Auth::guard('parent')->user()->id;
        $Emp_ids = array();
        $Emp_messages = Messages::where('is_private', 1)
		->where('franchise_id',Auth::guard('parent')->user()->franchise_id)
		->where(function ($query) use ($user_id){
			$query->where('reciever_id',$user_id)
			->where('sender_type','Franchise Employee')
			->where('message_to','Parent');
		})
		->orWhere(function ($query) use ($user_id){
			$query->where('sender_type','Parent')
			->where('message_to','Franchise Employee')
			->where('sender_id',$user_id);
		})
		->orderBy('created_at','desc')->get();

        $Employee_ids = array();
        if($Emp_messages->count()){
            foreach($Emp_messages as $employee){

            	$uid = $employee->sender_id;
            	if($employee->sender_id == $user_id){
					$uid = $employee->reciever_id;
				}

            	if(!in_array($uid, $Employee_ids)){
	            	$Employee = Fuser::find($uid);
	                $messages_list[] = $this->getMessagingList("Franchise Employee",$Employee->fullname, $Employee->id);
	                $Employee_ids[] = $uid;
				}
            }
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

	    return view('parent.message.list',$data);
    }

    public function getMessagingList($type = "Admin BCBA", $name = "", $id = "")
    {
        $message_title      = "BCBA";
        $receiver_id        = $id;
        $url                = "#";//route('admin.messages', ['id' => 1]);
        $unseen_messages    = 0;
        $last_message_time  = date("h:i a | M d Y");
        $last_message       = "No Message";
        $message_image      = asset('assets/images/super-mess-icon.jpg');

        $user_id = Auth::guard('parent')->user()->id;
        if($type == 'Franchise BCBA'){
        	
    		$franchise_id = Auth::guard('parent')->user()->franchise_id;
			$messages = Messages::where(array('message_to'=>'Franchise BCBA', 'sender_type'=>'Parent', 'franchise_id'=>$franchise_id))->orderBy('created_at','desc')->first();
        	
        }elseif($type == 'Franchise Administration'){
    		
    		$franchise_id = Auth::guard('parent')->user()->franchise_id;
			$messages = Messages::where(array('message_to'=>'Franchise Administration', 'sender_type'=>'Parent', 'franchise_id'=>$franchise_id))->orderBy('created_at','desc')->first();
        	
        }elseif($type == 'Franchise Employee'){

    		$rcv_id = Auth::guard('parent')->user()->id;
    		$sender_id = $receiver_id;
			$messages = Messages::where(array('message_to'=>'Parent', 'sender_type'=>'Franchise Employee', 'reciever_id'=> $rcv_id, 'sender_id'=>$sender_id ))->orderBy('created_at','desc')->first();
        	
        }else{
	        if($receiver_id != 0){
				$messages = Messages::where('message_to',$type)->where('reciever_id',$receiver_id)->OrderBy('created_at','DESC')->first();
	        }else{
	            $messages = Messages::where('message_to',$type)->OrderBy('created_at','DESC')->first();
	        }
		}

        if($type == "Franchise Administration"){
            $message_title  = "Franchise Administration";
            $url            = route("parent.messages", ["name" => "Franchise_Administration", "id" => $id]);
        }

        if($type == "Franchise BCBA"){
            $message_title  = "Franchise BCBA";
            $url            = route("parent.messages", ["name" => "Franchise_BCBA", "id" => $id]);
        }

        if($type == "Franchise Employee"){
            $message_title  = $name . " <br/> <span class='designation'>Franchise Employee</span>";
            $url            = route("parent.messages", ["name" => "Franchise_Employee", "id" => $id]);
            $employee = Fuser::find($id);
            if($employee->profile_picture) $message_image = $employee->profile_picture;
        }

        if($type == "SOS Distributor"){
            $message_title  = $type;
            $url            = route("parent.messages", ["name" => "SOS_Distributor"]);
        }

        if($messages){
            if($receiver_id != 0){
	        	if($type == 'Franchise Employee'){

	        		$emp_id = $receiver_id;
	        		$reciever = Auth::guard('parent')->user()->id;
	        		$all_messages = Messages::select("id")->where(array('message_to'=>'Parent', 'sender_type'=>'Franchise Employee', 'sender_id'=>$emp_id, 'reciever_id'=>$reciever))->get();
				}elseif($type == 'Franchise Administration'){

	        		$franchise_id = Auth::guard('parent')->user()->franchise_id;
	        		$all_messages = Messages::select("id")->where(array('message_to'=>'Franchise Administration', 'sender_type'=>'Parent', 'franchise_id'=>$franchise_id))->get();
					
				}elseif($type == 'Franchise BCBA'){
	        		$franchise_id = Auth::guard('parent')->user()->franchise_id;
	        		$all_messages = Messages::select("id")->where(array('message_to'=>'Franchise BCBA', 'sender_type'=>'Parent', 'franchise_id'=>$franchise_id))->get();
					
				}else{
	                $all_messages = Messages::select("id")->where('message_to',$type)->where('reciever_id',$receiver_id)->get();
				}    
            }else{
                $all_messages       = Messages::select("id")->where('message_to',$type)->get();
            }
            
            $total_messages     = $all_messages->count();
            $last_message       = $messages->message;
            $last_message_time  = date("h:i a | M d Y",strtotime($messages->created_at));

            if($total_messages > 0){
            	
	            $read_messages    = Messages_read_by::where('user_id',Auth::guard()->user()->id)
									->where('user_type','Parent')
									->whereIn( "message_id", $all_messages->toArray() )
									->GroupBy("message_id")
									->get()->count();
									//echo $read_messages;exit;
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
/*        if($type == 'Franchise Employee'){
			echo '<pre>';print_r($data);exit;
		}*/

        return $data;
    }

    public function message_title($name="",$id=0)
    {
        $title = "Msg In A Bottle";

        if($name == "Administration") $title = "Administration";
        elseif($name == "Admin_BCBA") $title = "BCBA";
        elseif($name == "SOS_Distributor") $title = "SOS Distributor";
        elseif($name == "Franchise_Administration") $title = "Franchise Administration";
        elseif($name == "Franchise_BCBA") $title = "Franchise BCBA";
        elseif($name == "Admin_Employee"){
            $admin_employee = Admin::find($id);
            $title          = $admin_employee->fullname . " | Admin Employee";
        }
		elseif($name == "Franchise_Employee"){
            $F_employee = Fuser::find($id);
            $title          = $F_employee->fullname . " | Franchise Employee";
        }
        return $title;
    }

    public function getMessages($name="",$id=0)
    {
        $messages       = array();
        $franchise_id   = 0;
        $F_employee_id  = 0;

        if($name == "Franchise Administration" || $name == "Franchise BCBA")
            $franchise_id = Auth::guard('parent')->user()->franchise_id;

        $allowed_sender = array('Administration','Franchise Administration','Admin BCBA','Franchise BCBA','Admin Employee','Franchise Employee','SOS Distributor','Parent');

        if(in_array($name,$allowed_sender))
        {
 
            //Messages list for private chat between employee and current franchise
            if($name == 'Franchise Administration'){
            	
            	$all_messages = Messages::where("is_private",0)
	            ->where(function ($query) use ($name) {
	                $query->where(array('message_to'=> $name, 'franchise_id'=>Auth::guard('parent')->user()->franchise_id ));
	            })->orderBy("created_at","ASC")->get();
				
			}elseif($name == 'Franchise BCBA'){
            	
            	$all_messages = Messages::where("is_private",0)
	            ->where(function ($query) use ($name) {
	                $query->where(array('message_to'=> $name, 'franchise_id'=>Auth::guard('parent')->user()->franchise_id ));
	            })->orderBy("created_at","ASC")->get();
	            
			}elseif($name == 'Franchise Employee'){
            	
            	$F_employee_id = Auth::guard('parent')->user()->id;
            	$Admin_employee_id = $id;
            	$all_messages = Messages::where("is_private",1)
	            ->where(function ($query) use ($Admin_employee_id, $F_employee_id) {
	                $query->where(array('reciever_id'=> $F_employee_id, 'franchise_id'=> Auth::guard('parent')->user()->franchise_id, 'sender_id'=> $Admin_employee_id, 'message_to'=> 'Parent', 'sender_type'=> 'Franchise Employee'));
	            })
	            ->orWhere(function ($query) use ($Admin_employee_id, $F_employee_id) {
	            	$query->where(array('reciever_id'=> $Admin_employee_id, 'sender_id'=> $F_employee_id, 'sender_type'=> 'Parent', 'message_to'=> 'Franchise Employee'));
	            })->orderBy("created_at","ASC")->get();

				
			}else{
	            //This message for administrator group
	            if($franchise_id != 0){
	                $all_messages = Messages::where('message_to',$name)->where("franchise_id",$franchise_id)->orderBy("created_at","ASC")->get();
	            }else{
	                $all_messages = Messages::where('message_to',$name)->orderBy("created_at","ASC")->get();
	            }
			}
            

            if( $all_messages->count() )
            {
                foreach($all_messages as $msg)
                {
                    $sender             = array();
                    $message_time       = date("h:i a | M d Y",strtotime($msg->created_at));
                    $message_read       = Messages_read_by::where('user_id',Auth::guard()->user()->id)->where('user_type','Parent')->where( "message_id", $msg->id )->get()->count();
                    $my_reply           = FALSE;

                    if($msg->sender_id == Auth::guard('parent')->user()->id && $msg->sender_type == "Parent" ) $my_reply = TRUE;

                    if($msg->sender_type == "Franchise Employee" || $msg->sender_type == 'Franchise BCBA') $user = Fuser::find($msg->sender_id);
                    if($msg->sender_type == "Employee") $user = Employmentform::find($msg->sender_id);
                    if($msg->sender_type == "Parent") $user = Admissionform::find($msg->sender_id);

                    $sender["id"]       =  $user->id;
                    $sender["name"]     =  isset($user->location) ? $user->location : $user->fullname;
                    
                    if($msg->sender_type == "Employee") $sender["name"] =  isset($user->personal_name) ? $user->personal_name.' | Employee' : '';
                    if($msg->sender_type == "Parent") 	$sender["name"] =  isset($user->client_childfullname) ? $user->client_childfullname.' | Client' : '';
                    
                    if(isset($user->personal_picture) || isset($user->client_profilepicture)){
                    	
                        if($msg->sender_type == "Parent") $sender["image"] = ($user->client_profilepicture) ? asset($user->client_profilepicture) : asset('assets/images/super-mess-icon.jpg');
                        else $sender["image"] =  ($user->personal_picture) ? asset($user->personal_picture) : asset('assets/images/super-mess-icon.jpg');
                        
                    }else{
                        $sender["image"]    =  asset('assets/images/super-mess-icon.jpg');
                    }
                    $sender["type"]     =  $msg->sender_type;

                    if($msg->reciever_id != Auth::guard()->user()->id || $msg->sender_type != "Administration")
                        $sender["reply_url"] = route("parent.messages", ["name" => str_replace(" ","_",$msg->sender_type), "id" => $user->id]);

                    $messages[] = array(
                        "message_id"        =>  $msg->id,
                        "message_from"      =>  $sender,
                        "message"           =>  $msg->message,
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
		
		$users_allow = array("Franchise Administration","Franchise BCBA","Franchise Employee","Parent");
        if(in_array($request->message_to,$users_allow) )
            $franchise_id = Auth::guard()->user()->franchise_id;

        $new_message                    = new Messages();
        $new_message->sender_id         = $request->sender_id;
        $new_message->sender_type       = $request->sender_type;
        $new_message->reciever_id       = $request->reciever_id;
        $new_message->message_to        = $request->message_to;
        $new_message->message           = $request->message;
        if($request->message_to == 'Franchise Employee') $new_message->is_private = 1;
        $new_message->franchise_id      = $franchise_id;
        $new_message->save();

        $message_read_by                = new Messages_read_by();
        $message_read_by->message_id    = $new_message->id;
        $message_read_by->user_id       = Auth::guard()->user()->id;
        $message_read_by->user_type     = 'Parent';
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
                "user_type"     =>  "Parent",
                "user_id"       =>  Auth::guard('parent')->user()->id,
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