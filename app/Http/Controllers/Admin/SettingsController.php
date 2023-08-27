<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

//Franchise Models
use App\Models\State;
use App\Models\Admin;
use App\Models\Settings;

class SettingsController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard()->user();
		$users[] = Auth::guard('admin')->user();
	}

	public function index(Request $request)
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Settings";
        $sub_title                      = "Settings"; 
        $menu                           = "settings";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu
        );
		
		$getStates = State::get();
		$States = array();
		if(!$getStates->isEmpty()){
			foreach($getStates as $state){
				$States[$state->code] = $state;
			}
		}
		//echo "<pre>";print_r($States['TX']->state_name);exit();	
		$data['States'] = $States;
		$data['Settings'] = Settings::all();
        
        return view('admin.settings.view',$data);
    }
	
	public function edit(Request $request)
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Settings";
        $sub_title                      = "Settings"; 
        $menu                           = "settings";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu
        );

		$getStates = State::get();
		$States = array();
		if(!$getStates->isEmpty()){
			foreach($getStates as $state){
				$States[$state->code] = $state;
			}
		}
	
        if($request->isMethod('post')){
			foreach($request->settings as $key=>$value){
				Settings::where("key",$key)->update(["value"=>$value]);
			}
			Session::flash('Success','<div class="alert alert-success">Settings saved successfully.</div>');
			return redirect('admin/settings');
		}
        
        $data['States'] = $States;
		$data['Settings'] = Settings::all();
        
        return view('admin.settings.edit',$data);
    }
}