<?php

namespace App\Http\Controllers\Parent;

use Illuminate\Http\Request;
use App\Http\Requests\Parent\Cargohold\UploadDocumentRequest;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

use App\Models\Cargohold;

//Franchise Models
use App\Models\Franchise;
use App\Models\Franchise\Client;

use App\Models\State;
use Session;
use Illuminate\Support\Facades\Storage;

class CargoholdController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard('parent')->user();
		$users[] = Auth::guard('parent')->user();
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
        
		$client_id = Auth::guard('parent')->user()->id;

        //If ID IS NULL THEN REDIRECT
        if(!$client_id) return redirect('parent/dashboard');
        
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('parent/dashboard');
		}
		
		$franchise_id = Auth::guard('parent')->user()->franchise_id;
		
        //$cargoholds = Cargohold::paginate(30);
        $Documents = Cargohold::where('category','Personal Documents')->where(array('archive'=>'0','user_id'=>$client_id,'franchise_id'=>$franchise_id))->get();
        $Parent_Training = Cargohold::where('category','Parent Training')->where(array('archive'=>'0','franchise_id'=>$franchise_id))->get();
		$SOS_Forms = Cargohold::where('category','SOS Parent Forms')->where(array('archive'=>'0','franchise_id'=>$franchise_id))->get();
		$Parent_Forms = Cargohold::where('category','Parent Default Forms')->where(array('archive'=>'0','user_type'=>'Parent'))->get();
        $Archives = Cargohold::where(array('archive'=>'1','user_id'=>$client_id,'franchise_id'=>$franchise_id))->get();
        
        //$data['cargoholds'] = $cargoholds;
        $data['Documents'] = $Documents;
        $data['Parent_Training'] = $Parent_Training;
		$data['SOS_Forms'] = $SOS_Forms;
		$data['Parent_Forms'] = $Parent_Forms;
        $data['Archives'] = $Archives;
		$data['Client'] = $Client;
		
	    return view('parent.cargohold.cargohold',$data);
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
		
		$client_id = Auth::guard('parent')->user()->id;

        //If ID IS NULL THEN REDIRECT
        if(!$client_id) return redirect('parent/dashboard');
        
        $Client = Client::find($client_id);
        
        if(!$Client){
			return redirect('parent/dashboard');
		}

        $franchises = Franchise::all();
        $data['franchises'] = $franchises;

		$data['title'] = '';
		$data['franchise_id'] = '';
		$data['expiration'] = '';
		$data['category'] = '';
		$data['user_type'] = array();
		$data['action'] = url('parent/cargohold/add-document');
		$data['type'] = 'add';
		$data['Client'] = $Client;
		if($request->has('cargo_id') && $request->get('cargo_id') ){
			$cargohold = Cargohold::find($request->get('cargo_id'));
			if($cargohold->user_type != 'Parent'){
				return redirect('parent/cargohold');
			}

            $user_types = array();
            /*if($cargohold->shared_with_everyone) $user_types[] = 'Everyone';
            if($cargohold->shared_with_franchise_admin) $user_types[] = 'Franchise Admin(s)';
            if($cargohold->shared_with_employees) $user_types[] = 'Employees';
            if($cargohold->shared_with_clients) $user_types[] = 'Clients';
            if($cargohold->shared_with_self) $user_types[] = 'Self';*/
            if($cargohold->shared_with_self) $user_types[] = 'Parent';

			//echo '<pre>';print_r($cargohold);exit;
			if(!$cargohold) return redirect('parent/cargohold');
			$data['title'] 			= $cargohold->title;
			$data['franchise_id'] 	= $cargohold->franchise_id;
			$data['expiration'] 	= $cargohold->expiration_date;
			$data['category'] 		= 'Personal Documents';
			$data['user_type'] 		= $user_types;
			$data['action'] 		= url('parent/cargohold/edit-document/'.$cargohold->id);
			$data['type'] = 'edit';
		}
		return view('parent.cargohold.cargoholdUpload', $data);
	}
	
	////////////////
	// Add document
	////////////////
	public function addDocument(UploadDocumentRequest $request){
	    $allowed_types                          = !empty($request->user_type) ? $request->user_type : array();
	    $cargohold                              = new Cargohold();
		$cargohold->franchise_id                = Auth::guard('parent')->user()->franchise_id;
		$cargohold->title                       = $request->title;
		$cargohold->expiration_date             = date('Y-m-d',strtotime($request->expiration));
		$cargohold->category                    = 'Personal Documents';
		$cargohold->user_type                   = 'Parent';
        $cargohold->user_id                     = Auth::guard('parent')->user()->id;
        $cargohold->shared_with_everyone        = in_array('Everyone',$allowed_types) ? 1 : 0;
        $cargohold->shared_with_franchise_admin = 0;
        $cargohold->shared_with_employees       = in_array('Employees',$allowed_types) ? 1 : 0;
        $cargohold->shared_with_clients         = in_array('Clients',$allowed_types) ? 1 : 0;
        //$cargohold->shared_with_self            = 0;
		$cargohold->shared_with_self            = 1;
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
    		return redirect('parent/cargohold');
		}
	}
	
	////////////////
	// Edit Document
	////////////////
	public function editDocument(Request $request, $cargo_id){

        $allowed_types                          = !empty($request->user_type) ? $request->user_type : array();
		$cargohold                              = Cargohold::find($cargo_id);
		$cargohold->franchise_id                = Auth::guard('parent')->user()->franchise_id;
		$cargohold->title                       = $request->title;
		$cargohold->expiration_date             = date('Y-m-d',strtotime($request->expiration));
		$cargohold->category                    = 'Personal Documents';
        $cargohold->shared_with_everyone        = in_array('Everyone',$allowed_types) ? 1 : 0;
        $cargohold->shared_with_franchise_admin = 0;
        $cargohold->shared_with_employees       = in_array('Employees',$allowed_types) ? 1 : 0;
        $cargohold->shared_with_clients         = in_array('Clients',$allowed_types) ? 1 : 0;
        $cargohold->shared_with_self            = 0;
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
		
		Session::flash('Success','<div class="alert alert-success">Document updated successfully</div>');
		return redirect('parent/cargohold');

	}
	
	///////////////////////
	// View cargo hold
	///////////////////////
	public function cargoHoldView($cargo_id){
	    //View PDF 
	    $cargo = Cargohold::find($cargo_id);
        $franchise_id = Auth::guard('parent')->user()->franchise_id;
        $user_id = Auth::guard('parent')->user()->id;
		$cat = array('SOS Parent Forms', 'Personal Documents', 'Parent Training', 'Parent Default Forms');
		
	    if($cargo){
	    	if($cargo->category == 'Parent Default Forms'){
				$franchise_id = 0;
			}
	    	if(($cargo->user_type == 'Parent' || $cargo->user_type == 'Franchise') && $cargo->franchise_id == $franchise_id && in_array($cargo->category,$cat) ){
			    if(($cargo->category == 'Personal Documents' && $cargo->user_id == $user_id) || ($cargo->category == 'SOS Parent Forms' || $cargo->category == 'Parent Training' || $cargo->category == 'Parent Default Forms') ){

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
			    	
			    }else{
					return redirect('parent/cargohold');
				}
			    
			}else{
				return redirect('parent/cargohold');
			}
			
		}else{
			return redirect('parent/cargohold');
		}
	}
	
	///////////////////////
	// Download cargo hold
	///////////////////////
	public function cargoHoldDownload($cargo_id){
	    //DOWNLOAD PDF 
	    $cargo = Cargohold::find($cargo_id);
        $franchise_id = Auth::guard('parent')->user()->franchise_id;
        $user_id = Auth::guard('parent')->user()->id;
		$cat = array('SOS Parent Forms', 'Personal Documents', 'Parent Training', 'Parent Default Forms');
		
	    if($cargo){
	    	if($cargo->category == 'Parent Default Forms'){
				$franchise_id = 0;
			}
	    	if(($cargo->user_type == 'Parent' || $cargo->user_type == 'Franchise') && $cargo->franchise_id == $franchise_id && in_array($cargo->category,$cat) ){
			    if(($cargo->category == 'Personal Documents' && $cargo->user_id == $user_id) || ($cargo->category == 'SOS Parent Forms' || $cargo->category == 'Parent Training' || $cargo->category == 'Parent Default Forms') ){

				    $file = storage_path(). $cargo->file;
				    $ext = pathinfo($file, PATHINFO_EXTENSION);
				    $headers = array('Content-Type: application/pdf',);
				    return Response::download($file, $cargo->title.'.'.$ext, $headers);
			    	
			    }else{
					return redirect('parent/cargohold');
				}
			    
			}else{
				return redirect('parent/cargohold');
			}
			
		}else{
			return redirect('parent/cargohold');
		}
	}
	
	/////////////////////
	// Delete Cargo Hold
	/////////////////////
	public function deleteCargoHold($cargo_id){
		
	    $cargo = Cargohold::find($cargo_id);
        $franchise_id = Auth::guard('parent')->user()->franchise_id;
        $user_id = Auth::guard('parent')->user()->id;

	    if($cargo){
	    	if($cargo->user_type == 'Parent' && $cargo->franchise_id == $franchise_id && $cargo->category == 'Personal Documents' && $cargo->user_id == $user_id){
		        if(file_exists( storage_path().$cargo->file)){
					unlink(storage_path().$cargo->file);
				}
				$cargo->delete();
				Session::flash('Success','<div class="alert alert-success">Document Deleted successfully</div>');
				return redirect('parent/cargohold');
			}
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
        return redirect('parent/cargohold');
    }

    /////////////////////
    // Active Cargo Hold
    /////////////////////
    public function activeCargoHold($cargo_id){
        $cargo = Cargohold::find($cargo_id);
        $cargo->archive = 0;
        $cargo->save();
        Session::flash('Success','<div class="alert alert-success">Document Moved back to '.$cargo->category.' Successfully!</div>');
        return redirect('parent/cargohold');
    }
} 