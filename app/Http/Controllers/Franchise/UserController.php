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
use App\Http\Requests\Franchise\User\UpdateProfile;
use App\Http\Requests\Franchise\User\AddUser;

//Models
use App\Models\Franchise\Fuser;

class UserController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard('franchise')->user();
		$users[] = Auth::guard('franchise')->user();
		
		$this->middleware(function ($request, $next) {
		    $this->user = auth()->user();
			//If user type is not owner or manager then redirecting to dashboard
			$method_name = $request->route()->getActionMethod();

			if($this->user->type != 'Owner' && $this->user->type != 'Manager' && ($method_name != "index" && $method_name != "store_profile")){
				return redirect('franchise/dashboard');
			}
		    return $next($request);
		});
	}

	public function index(){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Staff";
        $sub_title                      = "Staff";
        $menu                           = "staff";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $users = Fuser::where('franchise_id',Auth::guard('franchise')->user()->franchise_id)->get();
        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "users"									=> $users
        );
        
        return view('franchise.user.list',$data);		
	}
	
	public function edit_profile()
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Profile Edit";
        $sub_title                      = "Profile Edit";
        $menu                           = "staff";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
		
		$user_id = Auth::guard('franchise')->user()->id;

        //If ID IS NULL THEN REDIRECT
        if(!$user_id) return redirect('franchise/login');
			
        $user = Fuser::find($user_id);

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "user"                                  => $user,
            "designations"                          => array('Manager','BCBA','Intern','Receptionist'),
        );

        return view('franchise.user.profile',$data);
    }

    public function store_profile(UpdateProfile $request)
    {
        $user_id = Auth::guard('franchise')->user()->id;

        //If ID IS NULL THEN REDIRECT
        if(!$user_id) return redirect('franchise/login');
		
		$user = Fuser::find($user_id);
        $user->fullname   = $request->fullname;
        $user->email      = $request->email;
        $user->type       = (Auth::guard('franchise')->user()->type == 'Owner' && Auth::guard('franchise')->user()->id == $request->user_id ? 'Owner' : $request->type);

        if($request->password != "") $user->password = bcrypt($request->password);

        if($request->profile_picture)
        {
            $file_storage   = 'public/admin/'.Auth::guard('franchise')->user()->id;

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

        $data = array( "name" => $user->fullname, "email" => $user->email, "password" => $request->password);
        \Mail::send('email.invite_email', ["name" => $data['name'], "email" => $data['email'], "password" => $data['password'], "link"=>url('franchise/login')], function ($message) use ($data) {
            $message->from('sos@testing.com', 'SOS');
            $message->to($data['email'])->subject("INVITATION OF SOS");
        });

        Session::flash('Success','<div class="alert alert-success">Profile updated successfully!</div>');
        //return redirect(route('franchise.staff'));
		return redirect('franchise/edit_profile');
    }
	
	public function add()
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Add User";
        $sub_title                      = "Add User";
        $menu                           = "staff";
        $sub_menu                       = "add_user";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "designations"                          => array('Manager','BCBA','Intern','Receptionist'),
        );

        return view('franchise.user.add',$data);
    }

    public function store_user(AddUser $request)
    {
        $user = new Fuser;
        $user->fullname       = $request->fullname;
        $user->email          = $request->email;
        $user->type           = $request->type;
        $user->franchise_id   = Auth::guard('franchise')->user()->franchise_id;
        
        if($request->password != "") $user->password = bcrypt($request->password);
        $user->save();

        if($request->profile_picture)
        {
            $file_storage   = 'public/franchise/'.$user->id;

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

        $data = array( "name" => $user->fullname, "email" => $user->email, "password" => $request->password);
        \Mail::send('email.invite_email', ["name" => $data['name'], "email" => $data['email'], "password" => $data['password'], "link"=>url('franchise/login')], function ($message) use ($data) {
            $message->from('sos@testing.com', 'SOS');
            $message->to($data['email'])->subject("INVITATION OF SOS");
        });

        Session::flash('Success','<div class="alert alert-success">New User added successfully!</div>');
        return redirect(route('franchise.staff'));
    }
	
	public function edit($user_id)
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Profile Edit";
        $sub_title                      = "Profile Edit";
        $menu                           = "staff";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $user = Fuser::find($user_id);

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "user"                                  => $user,
            "designations"                          => array('Manager','BCBA','Intern','Receptionist'),
        );

        return view('franchise.user.edit',$data);
    }
	
	public function edit_user(UpdateProfile $request)
    {
        $user = Fuser::find($request->user_id);
        $user->fullname   = $request->fullname;
        $user->email      = $request->email;
        $user->type       = (Auth::guard('franchise')->user()->type == 'Owner' && Auth::guard('franchise')->user()->id == $request->user_id ? 'Owner' : $request->type);

        if($request->password != "") $user->password = bcrypt($request->password);

        if($request->profile_picture)
        {
            $file_storage   = 'public/admin/'.Auth::guard('franchise')->user()->id;

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
        //return redirect(route('franchise.staff'));
		return redirect('franchise/edituser/'.$request->user_id);
	}
	
	public function userDelete($user_id){
		$Fuser = Fuser::find($user_id);
		$Fuser->delete();
		
        Session::flash('Success','<div class="alert alert-success">User Deleted successfully!</div>');
        return redirect(route('franchise.staff'));
	}
}