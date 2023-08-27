<?php
namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\Notifications\AddNotification;

//Models
use App\Models\Franchise;
use App\Models\Notifications;
use App\Models\Notifications_read_by;
use App\Models\Notifications_to_franchise;

class NotificationController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard('admin')->user();
		$users[] = Auth::guard('admin')->user();
	}


    public function index()
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "All Notifications";
        $sub_title                      = "Notifications";
        $menu                           = "notification";
        $sub_menu                       = "notification";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $notfications           = Notifications::where(array("archive"=>0, 'notification_type'=>'Custom Notification'))->whereIn('user_type',array('Administration','Franchise Administration','All Franchises'))->orderBy("created_at","DESC")->get();
        $archive_notifications  = Notifications::where(array("archive"=>1, 'notification_type'=>'Custom Notification'))->whereIn('user_type',array('Administration','Franchise Administration','All Franchises'))->orderBy("created_at","DESC")->get();

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "notifications"                         => $notfications,
            "archive_notifications"                 => $archive_notifications,
        );

        return view('admin.notifications.list',$data);
    }

    public function archiveNotifications()
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Archive Notifications";
        $sub_title                      = "Archive Notifications";
        $menu                           = "message";
        $sub_menu                       = "notification";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $notfications  = Notifications::where(array("archive"=>1, 'notification_type'=>'Custom Notification'))->whereIn('user_type',array('Administration','Franchise Administration','All Franchises'))->orderBy("created_at","DESC")->get();

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "notifications"                         => $notfications,
        );

        return view('admin.notifications.archive',$data);
    }

    public function addNotification()
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Create Notification";
        $sub_title                      = "Notification";
        $menu                           = "notification";
        $sub_menu                       = "notification";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $franchises = Franchise::where('status','Active')->get();

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "franchises"                            => $franchises,
        );

        return view('admin.notifications.add',$data);
    }

    public function addStore(AddNotification $request)
    {
        $notification 				= new Notifications;
        $notification->title        = '<a href="'.url('franchise/mainnotifications').'">'.$request->title.'</a>';
        $notification->description  = $request->description;
        $notification->type         = $request->type;
        $notification->user_id      = Auth::guard('admin')->user()->id;
        $notification->user_type    = 'Administration';
        $notification->send_to_type = 'Franchise Administration';
        $notification->notification_type = 'Custom Notification';

        if($request->select_user && is_array($request->select_user))
        {
            foreach($request->select_user as $user)
            {
            	if($user == 1) continue;
                $send_to = 'send_to_'.$user;
                $notification->{$send_to}  = 1;
            }
        }

        $notification->save();
		
        if($request->franchises && is_array($request->franchises))
        {
            foreach($request->franchises as $franchise)
            {
            	if($franchise == 'All')
            	{
					$franchises = Franchise::where('status','Active')->get();
					foreach($franchises as $getFran)
					{
				        $notification_to_franchise                      = new Notifications_to_franchise;
				        $notification_to_franchise->notification_id     = $notification->id;
				        $notification_to_franchise->franchise_id        = $getFran->id;
				        //$notification_to_franchise->link        		= 'franchise/mainnotifications';
				        $notification_to_franchise->save();
				        
					}

			        $UpdateNoti = Notifications::find($notification->id);
					$UpdateNoti->send_to_franchise_admin  	= 1;
			        $UpdateNoti->send_to_type = 'All Franchises';
			        $UpdateNoti->save();

				}
				elseif($franchise == 'SOS Franchising')//IF SELECTED SOS FRANCHISING THE NOTI SEND TO ADMINISTRATION
				{
			        $UpdateNoti = Notifications::find($notification->id);
			        $UpdateNoti->title        				= $request->title;
			        $UpdateNoti->send_to_type 				= 'Administration';
	                $UpdateNoti->send_to_everyone  			= 0;
	                $UpdateNoti->send_to_franchise_admin  	= 0;
	                $UpdateNoti->send_to_employees  		= 1;
	                $UpdateNoti->send_to_clients  			= 0;
	                $UpdateNoti->send_to_admin  			= 1;
			        $UpdateNoti->save();
				}
				else
				{
		            $notification_to_franchise                      = new Notifications_to_franchise;
		            $notification_to_franchise->notification_id     = $notification->id;
		            $notification_to_franchise->franchise_id        = $franchise;
		            $notification_to_franchise->save();
				}
            }
        }

        if($request->attachment)
        {
            $file_storage   = 'public/notification/'.$notification->id;

            $put_data                       = Storage::put($file_storage, $request->attachment);
            $full_path                      = Storage::url($put_data);
            $notification->attachment       = $full_path;
            $notification->save();
        }

        Session::flash('Success','<div class="alert alert-success">New Notification created successfully!</div>');
        return redirect(route('admin.notification_list'));
    }

    public function editNotification($id)
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Notification";
        $sub_title                      = "Edit Notification";
        $menu                           = "notification";
        $sub_menu                       = "notification";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $notification = Notifications::where("id",$id)->whereIn('user_type',array('Administration','Franchise Administration','All Franchises'))->first();
        $franchises = Franchise::where('status','Active')->get();
        if($notification == "" || $notification == FALSE || $notification == NULL)
        {
            Session::flash('Success','<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ops Something went wrong!</div>');
            return redirect(route('admin.notification_list'));
        }

        $data = array(
            "page_title"      => $page_title,
            "sub_title"       => $sub_title,
            "menu"            => $menu,
            "sub_menu"        => $sub_menu,
            "franchises"      => $franchises,
            "notification"    => $notification,
        );

        return view('admin.notifications.edit',$data);
    }

    public function editStore(AddNotification $request)
    {
        $notification = Notifications::find($request->notification_id);

        if($notification == "" || $notification == FALSE || $notification == NULL)
        {
            Session::flash('Success','<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ops Something went wrong!</div>');
            return redirect(route('admin.notification_list'));
        }

        if($notification->description != $request->description)
        {
            $notification->old_description = $notification->description;
        }

        $notification->title                    = $request->title;
        $notification->description              = $request->description;
        $notification->type                     = $request->type;
        $notification->send_to_everyone         = 0;
        $notification->send_to_franchise_admin  = 0;
        $notification->send_to_employees        = 0;
        $notification->send_to_clients          = 0;
        $notification->send_to_type          	= 'Franchise Administration';
        $notification->notification_type 		= 'Custom Notification';

        if($request->select_user && is_array($request->select_user))
        {
            foreach($request->select_user as $user)
            {
            	if($user == 1) continue;
                $send_to = 'send_to_'.$user;
                $notification->{$send_to}  = 1;
            }
        }
        $notification->save();

        Notifications_to_franchise::where("notification_id",$notification->id)->delete();

        if($request->franchises && is_array($request->franchises))
        {
            foreach($request->franchises as $franchise)
            {
            	if($franchise == 'All'){
					$franchises = Franchise::where('status','Active')->get();
					foreach($franchises as $getFran)
					{
				        $notification_to_franchise                      = new Notifications_to_franchise;
				        $notification_to_franchise->notification_id     = $notification->id;
				        $notification_to_franchise->franchise_id        = $getFran->id;
				        $notification_to_franchise->save();
				        
				        $UpdateNoti = Notifications::find($notification->id);
				        $UpdateNoti->send_to_type = 'All Franchises';
				        $UpdateNoti->save();
					}
				}
				elseif($franchise == 'SOS Franchising')//IF SELECTED SOS FRANCHISING THE NOTI SEND TO ADMINISTRATION
				{
			        $UpdateNoti = Notifications::find($notification->id);
			        $UpdateNoti->send_to_type 				= 'Administration';
	                $UpdateNoti->send_to_everyone  			= 0;
	                $UpdateNoti->send_to_franchise_admin  	= 0;
	                $UpdateNoti->send_to_employees  		= 1;
	                $UpdateNoti->send_to_clients  			= 0;
	                $UpdateNoti->send_to_admin  			= 1;
			        $UpdateNoti->save();
				}
				else
				{
		            $notification_to_franchise                      = new Notifications_to_franchise;
		            $notification_to_franchise->notification_id     = $notification->id;
		            $notification_to_franchise->franchise_id        = $franchise;
		            $notification_to_franchise->save();
				}
            }
        }

        if($request->attachment)
        {
            $file_storage   = 'public/notification/'.$notification->id;

            $exists = Storage::exists($notification->attachment);

            if($exists)
            {
                Storage::delete($notification->attachment);
            }

            $put_data                       = Storage::put($file_storage, $request->attachment);
            $full_path                      = Storage::url($put_data);
            $notification->attachment       = $full_path;
            $notification->save();
        }

        Session::flash('Success','<div class="alert alert-success">Notification updated successfully!</div>');
        return redirect(route('admin.notification_list'));
    }

    public function MoveToArchive($id)
    {
        $notification = Notifications::find($id);

        if($notification == "" || $notification == FALSE || $notification == NULL)
        {
            Session::flash('Success','<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ops Something went wrong!</div>');
            return redirect(route('admin.notification_list'));
        }

        $notification->archive = 1;
        $notification->save();

        Session::flash('Success','<div class="alert alert-success">Notification moved to Archive successfully!</div>');
        return redirect(route('admin.archive_notifications'));
    }

    public function MoveFromArchive($id)
    {
        $notification = Notifications::find($id);

        if($notification == "" || $notification == FALSE || $notification == NULL)
        {
            Session::flash('Success','<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ops Something went wrong!</div>');
            return redirect(route('admin.notification_list'));
        }

        $notification->archive = 0;
        $notification->save();

        Session::flash('Success','<div class="alert alert-success">Notification moved From Archive Successfully!</div>');
        return redirect(route('admin.notification_list'));
    }
    
    public function readNotifications(Request $request)
    {
		if(!empty($request->ids))
		{
			$checkExist = Notifications_read_by::whereIn('notification_id',$request->ids)->select('id')->get();
			if($checkExist->isEmpty())
			{
				foreach($request->ids as $getID)
				{
					$addNoti = new Notifications_read_by();
					$addNoti->notification_id = $getID;
					$addNoti->user_id = Auth::user()->id;
					$addNoti->user_type = 'Administration';
					$addNoti->created_at = date('Y-m-d H:i:s');
					$addNoti->save();
				}
				return Response()->json('Success');
			}
		}
		
	}

}