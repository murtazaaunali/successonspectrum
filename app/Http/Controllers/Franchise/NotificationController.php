<?php
namespace App\Http\Controllers\Franchise;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Franchise\Notifications\AddNotification;

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
		$users[] = Auth::guard()->user();
		$users[] = Auth::guard('franchise')->user();
	}


    public function index()
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "All Notifications";
        $sub_title                      = "Notifications";
        $menu                           = "main_deck";
        $sub_menu                       = "notification";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
		$franchise_id = Auth::guard('franchise')->user()->franchise_id;
		
        $notfications           = Notifications::where("archive",0)->where(array('user_type'=>'Franchise Administration', 'franchise_id'=>$franchise_id))->orderBy("created_at","DESC")->get();
        $archive_notifications  = Notifications::where("archive",1)->where(array('user_type'=>'Franchise Administration', 'franchise_id'=>$franchise_id))->get();
        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "notifications"                         => $notfications,
            "archive_notifications"                 => $archive_notifications,
        );

        return view('franchise.notifications.list',$data);
    }

    public function MainNotifications()
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "All Notifications";
        $sub_title                      = "Notifications";
        $menu                           = "main_deck";
        $sub_menu                       = "main_notification";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
		$franchise_id = Auth::guard('franchise')->user()->franchise_id;
		
        $notfications           = Notifications::where("archive",0)->where(array("send_to_admin"=>0,'user_type'=>'Administration'))->orderBy("created_at","DESC")->get();
        $archive_notifications  = Notifications::where("archive",1)->where(array("send_to_admin"=>0,'user_type'=>'Administration'))->get();
        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "notifications"                         => $notfications,
            "archive_notifications"                 => $archive_notifications,
        );

        return view('franchise.notifications.admin_notifications.list',$data);
    }

    public function archiveNotifications()
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Archive Notifications";
        $sub_title                      = "Archive Notifications";
        $menu                           = "main_deck";
        $sub_menu                       = "notification";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $notfications  = Notifications::where("archive",1)->where(array("send_to_admin"=>0, 'user_type'=>'Franchise Administration'))->orderBy("created_at","DESC")->get();

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "notifications"                         => $notfications,
        );

        return view('franchise.notifications.archive',$data);
    }

    public function addNotification()
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Create Notification";
        $sub_title                      = "Notification";
        $menu                           = "main_deck";
        $sub_menu                       = "notification";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $franchises = Franchise::get();

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "franchises"                            => $franchises,
        );

        return view('franchise.notifications.add',$data);
    }

    public function addStore(AddNotification $request)
    {
        $notification = new Notifications;
        $notification->title        = $request->title;
        $notification->description  = $request->description;
        $notification->type         = $request->type;
        $notification->user_id      = Auth::guard('franchise')->user()->id;
        $notification->franchise_id = Auth::guard('franchise')->user()->franchise_id;
        $notification->user_type    = 'Franchise Administration';
        $notification->send_to_type = 'Franchise';

        if($request->select_user && is_array($request->select_user))
        {
            foreach($request->select_user as $user)
            {
                $send_to = 'send_to_'.$user;
                $notification->{$send_to}  = 1;
            }
        }


        $notification->save();

        if($request->attachment)
        {
            $file_storage   = 'public/notification/'.$notification->id;

            $put_data                       = Storage::put($file_storage, $request->attachment);
            $full_path                      = Storage::url($put_data);
            $notification->attachment       = $full_path;
            $notification->save();
        }

        Session::flash('Success','<div class="alert alert-success">New Notification created successfully!</div>');
        return redirect(route('franchise.notification_list'));
    }

    public function editNotification($id)
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Notification";
        $sub_title                      = "Edit Notification";
        $menu                           = "main_deck";
        $sub_menu                       = "notification";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $notification = Notifications::where("id",$id)->where(array("send_to_admin"=>0, 'user_type'=>'Franchise Administration'))->first();
        $franchises = Franchise::get();
        if($notification == "" || $notification == FALSE || $notification == NULL)
        {
            Session::flash('Success','<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ops Something went wrong!</div>');
            return redirect(route('franchise.notification_list'));
        }

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "franchises"                            => $franchises,
            "notification"                          => $notification,
        );

        return view('franchise.notifications.edit',$data);
    }

    public function editStore(AddNotification $request)
    {
        $notification = Notifications::find($request->notification_id);

        if($notification == "" || $notification == FALSE || $notification == NULL)
        {
            Session::flash('Success','<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ops Something went wrong!</div>');
            return redirect(route('franchise.notification_list'));
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

        if($request->select_user && is_array($request->select_user))
        {
            foreach($request->select_user as $user)
            {
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
                $notification_to_franchise                      = new Notifications_to_franchise;
                $notification_to_franchise->notification_id     = $notification->id;
                $notification_to_franchise->franchise_id        = $franchise;
                $notification_to_franchise->save();
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
        return redirect(route('franchise.notification_list'));
    }

    public function MoveToArchive($id)
    {
        $notification = Notifications::find($id);

        if($notification == "" || $notification == FALSE || $notification == NULL)
        {
            Session::flash('Success','<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ops Something went wrong!</div>');
            return redirect(route('franchise.notification_list'));
        }

        $notification->archive = 1;
        $notification->save();

        Session::flash('Success','<div class="alert alert-success">Notification moved to Archive successfully!</div>');
        return redirect(route('franchise.archive_notifications'));
    }

    public function MoveFromArchive($id)
    {
        $notification = Notifications::find($id);

        if($notification == "" || $notification == FALSE || $notification == NULL)
        {
            Session::flash('Success','<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ops Something went wrong!</div>');
            return redirect(route('franchise.notification_list'));
        }

        $notification->archive = 0;
        $notification->save();

        Session::flash('Success','<div class="alert alert-success">Notification moved From Archive Successfully!</div>');
        return redirect(route('franchise.notification_list'));
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
					$addNoti->user_type = 'Franchise Administration';
					$addNoti->created_at = date('Y-m-d H:i:s');
					$addNoti->save();
				}
				return Response()->json('Success');
			}
		}
		
	}
}