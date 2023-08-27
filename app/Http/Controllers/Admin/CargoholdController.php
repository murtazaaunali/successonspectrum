<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\Franchise\CreateFranchiseRequest;
use App\Http\Requests\Admin\Franchise\EditFranchiseRequest;
use App\Http\Requests\Admin\Franchise\EditFeeRequest;
use App\Http\Requests\Admin\Cargohold\UploadDocumentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

use App\Models\Cargohold;
use App\Models\Cargohold_folders;

//Franchise Models
use App\Models\Franchise;
use App\Models\Admin;
use App\Models\Notifications;

use App\Models\State;
use Session;
use Illuminate\Support\Facades\Storage;

class CargoholdController extends Controller
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
        $page_title                     = "Cargo Hold List";
        $sub_title                      = "Cargo Hold";
        $menu                           = "cargo";
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
        
        //$cargoholds 			= Cargohold::paginate(30);
        $Cargohold_folders		     = Cargohold_folders::where('archive','0')->get();
		$Completed_Franchisee_Forms 	= Cargohold::where(array('category'=>'Completed Franchisee Forms', 'archive'=>'0', 'user_type' => 'Admin', 'folder_id' => 0))->orderby("id","desc")->paginate(0);
        //$Employee_Forms 			   = Cargohold::where(array('category'=>'Admin Employee Forms', 'archive'=>'0', 'user_type' => 'Admin'))->paginate(40);
        $Personal_Documents 			= Cargohold::where(array('category'=>'Personal Documents', 'archive'=>'0', 'user_type' => 'Admin', 'franchise_id' => 0, 'shared_with_admin'=> 1, 'folder_id' => 0))->orderby("id","desc")->paginate(0);
        $Archives 					  = Cargohold::where(array('archive'=>1, 'category'=>'Personal Documents', 'user_type' => 'Admin', 'franchise_id' => 0, 'shared_with_admin'=> 1, 'folder_id' => 0))->orderby("id","desc")->paginate(0);
        
		$cargohold_folders_category = DB::select("SHOW COLUMNS FROM sos_cargohold_folders LIKE 'category'");
		if ($cargohold_folders_category) {
			$cargohold_folders_category = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $cargohold_folders_category[0]->Type));
		}
		$data['Cargohold_folders_category'] = $cargohold_folders_category;
		
        //$data['cargoholds'] = $cargoholds;
        $data['Cargohold_folders'] 		  = $Cargohold_folders;
		$data['Completed_Franchisee_Forms'] = $Completed_Franchisee_Forms;
        //$data['Employee_Forms'] 			= $Employee_Forms;
        $data['Personal_Documents'] 		 = $Personal_Documents;
        $data['Archives'] 				   = $Archives;
		
	    return view('admin.cargohold.cargohold',$data);
    }
    
	///////////////////
    // UPLOAD DOCUMENT
    ///////////////////
    public function uploadDocument(Request $request){

        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Cargo Hold Upload";
        $sub_title                      = "Cargo Hold Upload";
        $menu                           = "cargo";
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

        $franchises = Franchise::all();
        $data['franchises'] = $franchises;
		
		$data['Cargohold_folders'] = Cargohold_folders::where('archive','0')->get();

		$data['title'] = '';
		$data['franchise_id'] = '';
		$data['expiration'] = '';
		$data['category'] = '';
		$data['user_type'] = array();
		$data['action'] = url('admin/cargohold/add-document');
		$data['type'] = 'add';
		if($request->has('cargo_id') && $request->get('cargo_id') ){

			$cargohold = Cargohold::find($request->get('cargo_id'));

			if($cargohold->user_type != 'Admin'){
				return redirect('admin/cargohold');
			}

            $user_types = array();
            if($cargohold->shared_with_everyone) $user_types[] = 'Everyone';
            if($cargohold->shared_with_franchise_admin) $user_types[] = 'Franchise Admin(s)';
            if($cargohold->shared_with_employees) $user_types[] = 'Employees';
            if($cargohold->shared_with_clients) $user_types[] = 'Clients';
            if($cargohold->shared_with_self) $user_types[] = 'Self';

			//echo '<pre>';print_r($cargohold);exit;
			if(!$cargohold) return redirect('admin/cargohold');
			$data['title'] 			= $cargohold->title;
			$data['franchise_id'] 	= $cargohold->franchise_id;
			$data['expiration'] 	= $cargohold->expiration_date;
			$data['category'] 		= $cargohold->category;
			$data['user_type'] 		= $user_types;
			$data['action'] 		= url('admin/cargohold/edit-document/'.$cargohold->id);
			$data['type'] = 'edit';
		}
		return view('admin.cargohold.cargoholdUpload', $data);
	}
	
	////////////////
	// Add document
	////////////////
	public function addDocument(UploadDocumentRequest $request){

	    //$allowed_types                          = !empty($request->user_type) ? $request->user_type : array();
	    $cargohold                              = new Cargohold();
		$cargohold->franchise_id                = ($request->category == 'Personal Documents' ? 0 : $request->franchise);
		$cargohold->folder_id                   = $request->folder_id;
		$cargohold->title                       = $request->title;
		//$cargohold->expiration_date             = date('Y-m-d',strtotime($request->expiration));
		$cargohold->category                    = $request->category;
		$cargohold->user_type                   = 'Admin';
        $cargohold->user_id                     = Auth::user()->id;
		/*$cargohold->shared_with_everyone      = in_array('Everyone',$allowed_types) ? 1 : 0;
        $cargohold->shared_with_franchise_admin = in_array('Franchise Admin(s)',$allowed_types) ? 1 : 0;
        $cargohold->shared_with_employees       = in_array('Employees',$allowed_types) ? 1 : 0;
        $cargohold->shared_with_clients         = in_array('Clients',$allowed_types) ? 1 : 0;
        $cargohold->shared_with_self            = in_array('Self',$allowed_types) ? 1 : 0;*/
        $cargohold->shared_with_everyone        = 0;
        $cargohold->shared_with_franchise_admin = ($request->category != 'Personal Documents' ? 0 : 1);
        $cargohold->shared_with_employees       = 0;
        $cargohold->shared_with_clients         = 0;
        $cargohold->shared_with_self            = 0;
        $cargohold->shared_with_admin           = ($request->category == 'Personal Documents' ? 1 : 0);
		$cargohold->save();

		//Document Upload
		if ($request->hasFile('document')){

	        $file = $request->file('document');
			if (!file_exists(storage_path().'/app/public/cargohold')) {
			    mkdir(storage_path().'/app/public/cargohold', 0777, true);
			}
			$destinationPath 	= storage_path().'/app/public/cargohold';
    		$file_name 	= $cargohold->id.'_cargohold_'.time().'.'.$file->getClientOriginalExtension();
    		$file->move($destinationPath,$file_name);
    		$cargohold->file = '/app/public/cargohold/'.$file_name;
    		$cargohold->save();
    		
    		Session::flash('Success','<div class="alert alert-success">Document uploaded successfully</div>');
    		//return redirect('admin/cargohold');
			
			$tab = '';
			if($cargohold->category == 'Template Company Forms') 	 $tab = '?tab=tab1';
			if($cargohold->category == 'Completed Franchisee Forms') $tab = '?tab=tab2';
			if($cargohold->category == 'Personal Documents') 		 $tab = '?tab=tab3';
			
			$messages = 'New Document added into Cargo Hold, <br/> <b>Document Name:</b> '.$cargohold->title;
			if($request->category != 'Personal Documents'){
				$franchise = Franchise::find($request->franchise);
				/*$data = array("name" => $franchise->location, "email" => $franchise->email, "messages" => $messages);
		        \Mail::send('email.email_template', ["name" => $franchise->location, "email" => $franchise->email, "link"=>url('franchise/login'), 'messages' => $messages], function ($message) use ($data) {
		            $message->from('sos@testing.com', 'SOS');
		            $message->to($data['email'])->subject("Cargo Hold Uploaded");
		        });*/
				if($franchise && !empty($franchise->email))
				{
					$data = array("name" => $franchise->location, "email" => $franchise->email, "messages" => $messages);
					\Mail::send('email.email_template', ["name" => $franchise->location, "email" => $franchise->email, "link"=>url('franchise/login'), 'messages' => $messages], function ($message) use ($data) {
						$message->from('sos@testing.com', 'SOS');
						$message->to($data['email'])->subject("Cargo Hold Uploaded");
					});
				}
			}

	        $Employee = Admin::find(Auth::user()->id);
	        $newNoti = new Notifications();
	        $newNoti->title = 'Cargo Hold Uploaded';
	        $newNoti->description = 'New cargo hold uploaded by '.$Employee->fullname;
	        $newNoti->type = 'Activity';
	        $newNoti->send_to_admin = '1';
	        $newNoti->user_id = Auth::guard('admin')->user()->id;
	        $newNoti->franchise_id = 0;
	        $newNoti->user_type = 'Administration';
	        $newNoti->send_to_type = 'Director of Administration';
	        $newNoti->save();
	        
			return redirect('admin/cargohold'.$tab);
		}
	}
	
	////////////////
	// Edit Document
	////////////////
	public function editDocument(Request $request, $cargo_id){

        //$allowed_types                          = !empty($request->user_type) ? $request->user_type : array();
		$cargohold                              = Cargohold::find($cargo_id);
		$cargohold->franchise_id                = ($request->category == 'Personal Documents' ? 0 : $request->franchise);
		$cargohold->title                       = $request->title;
		//$cargohold->expiration_date             = date('Y-m-d',strtotime($request->expiration));
		$cargohold->category                    = $request->category;
        $cargohold->shared_with_everyone        = 0;
        $cargohold->shared_with_franchise_admin = ($request->category != 'Personal Documents' ? 0 : 1);
        $cargohold->shared_with_employees       = 0;
        $cargohold->shared_with_clients         = 0;
        $cargohold->shared_with_self            = 0;
        $cargohold->shared_with_admin           = ($request->category == 'Personal Documents' ? 1 : 0);
		$cargohold->save();

		//Document Upload
		if ($request->hasFile('document')){

	        if(file_exists( storage_path().$cargohold->file) && $cargohold->file != ''){
				unlink(storage_path().$cargohold->file);
			}
	        
	        $file = $request->file('document');
			if (!file_exists(storage_path().'/app/public/cargohold')) {
			    mkdir(storage_path().'/app/public/cargohold', 0777, true);
			}
			$destinationPath 	= storage_path().'/app/public/cargohold';
    		$file_name 	= $cargohold->id.'_cargohold_'.time().'.'.$file->getClientOriginalExtension();
    		$file->move($destinationPath,$file_name);
    		$cargohold->file = '/app/public/cargohold/'.$file_name;
		}

		$cargohold->save();
		
		$tab = '';
		if($cargohold->category == 'Template Company Forms') 	 $tab = '?tab=tab1';
		if($cargohold->category == 'Completed Franchisee Forms') $tab = '?tab=tab2';
		if($cargohold->category == 'Personal Documents') 		 $tab = '?tab=tab3';
		
		Session::flash('Success','<div class="alert alert-success">Document updated successfully</div>');
		return redirect('admin/cargohold/'.$tab);

	}
	
	///////////////////////
	// View cargo hold
	///////////////////////
	public function cargoHoldView($cargo_id){
	    //View PDF 
	    $cargo = Cargohold::find($cargo_id);
	    if($cargo){
		    $file = storage_path(). $cargo->file;
		    $ext = pathinfo($file, PATHINFO_EXTENSION);
			
			if($ext == "pdf")
			{
				return Response::make(file_get_contents($file), 200, [
					'Content-Type' => 'application/pdf',
					'Content-Disposition' => 'inline; filename="'.$cargo->title.'.'.$ext.'"'
				]);	
			}
			else
			{
				return Response::make(file_get_contents($file), 200, [
					'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
					'Content-Disposition' => 'inline; filename="'.$cargo->title.'.'.$ext.'"'
				]);
			}
		}
	}
	
	///////////////////////
	// Download cargo hold
	///////////////////////
	public function cargoHoldDownload($cargo_id){
	    //DOWNLOAD PDF 
	    $cargo = Cargohold::find($cargo_id);
	    if($cargo){
		    $file = storage_path(). $cargo->file;
		    $ext = pathinfo($file, PATHINFO_EXTENSION);
		    $headers = array('Content-Type: application/pdf',);
		    return Response::download($file, $cargo->title.'.'.$ext, $headers);					
		}
	}
	
	/////////////////////
	// Delete Cargo Hold
	/////////////////////
	public function deleteCargoHold($cargo_id){
		
	    $cargo = Cargohold::find($cargo_id);
	    if($cargo){

	        if(file_exists( storage_path().$cargo->file)){
				unlink(storage_path().$cargo->file);
			}

			if($cargo->category == 'Template Company Forms') 		$tab = '?tab=tab1';
			if($cargo->category == 'Completed Franchisee Forms') 	$tab = '?tab=tab2';
			if($cargo->category == 'Personal Documents') 			$tab = '?tab=tab3';

			$cargo->delete();

			Session::flash('Success','<div class="alert alert-success">Document Deleted successfully</div>');
			return redirect('admin/cargohold/'.$tab);
						
		}else{
			echo "File doesn't exist";
		}
		
	}

    /////////////////////
    // Archive Cargo Hold
    /////////////////////
    public function archiveCargoHold($cargo_id){

        $cargo = Cargohold::find($cargo_id);
        $cargo->archive = 1;
        $cargo->save();

        Session::flash('Success','<div class="alert alert-success">Document Moved to Archive Successfully!</div>');
        return redirect('admin/cargohold/?tab=tab4');
    }

    /////////////////////
    // Active Cargo Hold
    /////////////////////
    public function activeCargoHold($cargo_id){

        $cargo = Cargohold::find($cargo_id);
        $cargo->archive = 0;
        $cargo->save();

		if($cargo->category == 'Template Company Forms') 		$tab = '?tab=tab1';
		if($cargo->category == 'Completed Franchisee Forms') 	$tab = '?tab=tab2';
		if($cargo->category == 'Personal Documents') 			$tab = '?tab=tab3';

        Session::flash('Success','<div class="alert alert-success">Document Moved back to '.$cargo->category.' Successfully!</div>');
        return redirect('admin/cargohold/'.$tab);
    }
	
	/////////////////////
    // Moveto Cargo Hold
    /////////////////////
    public function moveToCargoHold(Request $request){

        $cargo = Cargohold::find($request->cargo_id);
        $cargo->folder_id = $request->cargohold_folder_id;
        //$cargo->save();
		
		$Cargohold_folder = Cargohold_folders::find($request->cargohold_folder_id);

		if($cargo->category == 'Template Company Forms') 		$tab = '?tab=tab1';
		if($cargo->category == 'Completed Franchisee Forms') 	$tab = '?tab=tab2';
		if($cargo->category == 'Personal Documents') 			$tab = '?tab=tab3';
		
		if(\File::exists($cargo->file))
		{
			$file_name = \File::name($cargo->file);
			$file_extension = \File::extension($cargo->file);
			$file = $cargo->id.'_cargohold_'.time().'.'.$file_extension;
			$from = public_path()."/storage/cargohold/".$file_name.".".$file_extension;
			$to = public_path().'/storage/cargohold/'.$Cargohold_folder->name.'/'.$file;
			\File::move($from, $to);
			$cargo->file = '/app/public/cargohold/'.$Cargohold_folder->name.'/'.$file;
		}
		$cargo->save();
        
		Session::flash('Success','<div class="alert alert-success">Document Moved to '.$Cargohold_folder->name.' Successfully!</div>');
        return redirect('admin/cargohold/'.$tab);
    }
	
	///////////////////
    // CREAT FOLDER////
    ///////////////////
    public function createCargoHoldFolder(Request $request){

        $tab = '';
		if($request->has('action') && $request->get('action') ){
			$cargohold_folders = new Cargohold_folders();
	        $cargohold_folders->name = $request->create_folder_name;
	        $cargohold_folders->category = $request->create_folder_category;
	        $cargohold_folders->save();
			
			//Create Cargohold Folder
			if (!file_exists(storage_path().'/app/public/cargohold/'.$cargohold_folders->name)) 
			{
				mkdir(storage_path().'/app/public/cargohold/'.$cargohold_folders->name, 0777, true);
			}
			
			if($cargohold_folders->category == 'Template Company Forms') 	 $tab = '?tab=tab1';
			if($cargohold_folders->category == 'Completed Franchisee Forms') $tab = '?tab=tab2';
			if($cargohold_folders->category == 'Personal Documents') 		 $tab = '?tab=tab3';
			
			Session::flash('Success','<div class="alert alert-success">Folder Created Successfully!</div>');
		}
		
		return redirect('admin/cargohold'.$tab);
	}
	
	public function removeCargoHoldFolder($folder_id){

        $folder = Cargohold_folders::find($folder_id);
	    if($folder){

	        if(file_exists( storage_path().'app/public/cargohold/'.$folder->name)){
				unlink(storage_path().'app/public/cargohold/'.$folder->name);
			}

			if($folder->category == 'Template Company Forms') 		$tab = '?tab=tab1';
			if($folder->category == 'Completed Franchisee Forms') 	$tab = '?tab=tab2';
			if($folder->category == 'Personal Documents') 			$tab = '?tab=tab3';

			$folder->delete();

			Session::flash('Success','<div class="alert alert-success">Folder Deleted successfully</div>');
			return redirect('admin/cargohold/'.$tab);
						
		}
	}
} 