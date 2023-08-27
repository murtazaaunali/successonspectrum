<?php
namespace App\Http\Controllers\Femployee;

use Session;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;

//Models
use App\Models\Franchise;
use App\Models\Femployee;
use App\Models\Notifications;

class NotificationController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard()->user();
		$users[] = Auth::guard('femployee')->user();
	}


    public function index()
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "All Notifications";
        $sub_title                      = "Notifications";
        $menu                           = "main_deck";
        $sub_menu                       = "main_deck";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
		$franchise_id           = Auth::guard()->user()->franchise_id;
		
        $notfications           = Notifications::where(array("send_to_employees"=>1,'franchise_id'=>$franchise_id))->orderBy("created_at","DESC")->get();
        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "notifications"                         => $notfications
        );

        return view('femployee.notifications.list',$data);
    }
}