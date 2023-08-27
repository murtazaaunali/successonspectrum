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
use App\Http\Requests\Admin\Profile\UpdateProfile;
use App\Http\Requests\Admin\User\AddUser;

//Models
use App\Models\Admin;
use App\Models\Admin_designations;

class UserController extends Controller
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
        $page_title                     = "Profile Edit";
        $sub_title                      = "Profile Edit";
        $menu                           = "";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $user = Admin::find(Auth::guard('admin')->user()->id);

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "user"                                  => $user
        );

        return view('admin.profile',$data);
    }

    public function store_profile(UpdateProfile $request)
    {
        $user = Admin::find(Auth::guard('admin')->user()->id);
        $user->fullname   =   $request->fullname;
        $user->email        =   $request->email;

        if($request->password != "") $user->password = bcrypt($request->password);

        if($request->profile_picture)
        {
            $file_storage   = 'public/admin/'.Auth::guard('admin')->user()->id;

            $exists = Storage::exists($user->profile_picture);

            if($exists)
            {
                Storage::delete($user->profile_picture);
            }

            $put_data               = Storage::put($file_storage, $request->profile_picture);
            $full_path              = Storage::url($put_data);
            $user->profile_picture  = $full_path;

            //To Rename the File uncomment below code.
            //Storage::rename($put_data,$file_storage.'/img.png');
        }

        $user->save();

        Session::flash('Success','<div class="alert alert-success">Profile updated successfully!</div>');
        //return redirect(route('admin.home'));
		return redirect('admin/edit_profile');
    }

    public function add()
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Add User";
        $sub_title                      = "Add User";
        $menu                           = "";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "designations"                          => Admin_designations::get(),
        );

        return view('admin.user.add',$data);
    }

    public function store_user(AddUser $request)
    {
        $user = new Admin;
        $user->fullname       =   $request->fullname;
        $user->email            =   $request->email;
        $user->designation_id   =   ($request->designation_id != "") ? $request->designation_id : 0;

        if($request->password != "") $user->password = bcrypt($request->password);

        $user->save();

        if($request->profile_picture)
        {
            $file_storage   = 'public/admin/'.$user->id;

            $exists = Storage::exists($user->profile_picture);

            if($exists)
            {
                Storage::delete($user->profile_picture);
            }

            $put_data               = Storage::put($file_storage, $request->profile_picture);
            $full_path              = Storage::url($put_data);
            $user->profile_picture  = $full_path;
            $user->save();
        }



        Session::flash('Success','<div class="alert alert-success">New User added successfully!</div>');
        return redirect(route('admin.home'));
    }
}