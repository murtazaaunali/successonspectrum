<?php

namespace App\Http\Controllers\Femployee;

use Illuminate\Http\Request;

use App\Http\Requests\Femployee\Cargohold\UploadDocumentRequest;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

use App\Models\Cargohold;

//Franchise Models
use App\Models\Franchise;

use App\Models\State;
use Session;
use Illuminate\Support\Facades\Storage;

class CargoholdController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard('femployee')->user();
		$users[] = Auth::guard('femployee')->user();
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
		
		$femployee_id = Auth::guard('femployee')->user()->id;
		$franchise_id = Auth::guard('femployee')->user()->franchise_id;

        //$cargoholds = Cargohold::paginate(30);
		$Documents = Cargohold::where('category','Personal Documents')->where(array('archive'=>'0','user_id'=>$femployee_id,'franchise_id'=>$franchise_id))->get();
		$Parent_training = Cargohold::where('category','Parent Training')->where(array('archive'=>'0','user_id'=>$femployee_id,'franchise_id'=>$franchise_id))->get();
		$Employee_Training = Cargohold::where('category','Employee Training')->where(array('archive'=>'0','franchise_id'=>$franchise_id))->get();
		$SOS_Forms = Cargohold::where('category','SOS Employee Forms')->where(array('archive'=>'0','franchise_id'=>$franchise_id))->get();
		//EMPLOYEES DEFAULT FORMS
		$Employee_Forms = Cargohold::where('category','Employee Default Forms')->where(array('archive'=>'0', 'user_type' => 'Franchise Employee'))->get();
        $Archives = Cargohold::where(array('archive'=>'1','user_id'=>$femployee_id,'franchise_id'=>$franchise_id))->get();
        
        //$data['cargoholds'] = $cargoholds;
        $data['Documents'] = $Documents;
        $data['Employee_Training'] = $Employee_Training;
        $data['SOS_Forms'] = $SOS_Forms;
        $data['Parent_training'] = $Parent_training;
        $data['Employee_Forms'] = $Employee_Forms;
        $data['Archives'] = $Archives;
		
	    return view('femployee.cargohold.cargohold',$data);
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

		$data['title'] = '';
		$data['franchise_id'] = '';
		$data['expiration'] = '';
		$data['category'] = '';
		$data['user_type'] = array();
		$data['action'] = url('femployee/cargohold/add-document');
		$data['type'] = 'add';
		
		if($request->has('cargo_id') && $request->get('cargo_id') ){
			$cargohold = Cargohold::find($request->get('cargo_id'));
			if($cargohold->user_type != 'Franchise Employee'){
				return redirect('femployee/cargohold');
			}

            $user_types = array();
            if($cargohold->shared_with_everyone) $user_types[] = 'Everyone';
            if($cargohold->shared_with_franchise_admin) $user_types[] = 'Franchise Admin(s)';
            if($cargohold->shared_with_employees) $user_types[] = 'Employees';
            if($cargohold->shared_with_clients) $user_types[] = 'Clients';
            if($cargohold->shared_with_self) $user_types[] = 'Self';

			//echo '<pre>';print_r($cargohold);exit;
			if(!$cargohold) return redirect('femployee/cargohold');
			$data['title'] 			= $cargohold->title;
			$data['franchise_id'] 	= $cargohold->franchise_id;
			$data['expiration'] 	= $cargohold->expiration_date;
			$data['category'] 		= $cargohold->category;
			$data['user_type'] 		= $user_types;
			$data['action'] 		= url('femployee/cargohold/edit-document/'.$cargohold->id);
			$data['type'] = 'edit';
		}
		return view('femployee.cargohold.cargoholdUpload', $data);
	}
	
	////////////////
	// Add document
	////////////////
	public function addDocument(UploadDocumentRequest $request){

	    $allowed_types                          = !empty($request->user_type) ? $request->user_type : array();
	    $cargohold                              = new Cargohold();
		$cargohold->franchise_id                = Auth::guard('femployee')->user()->franchise_id;
		$cargohold->title                       = $request->title;
		$cargohold->expiration_date             = date('Y-m-d',strtotime($request->expiration));
		$cargohold->category                    = $request->category;
		$cargohold->user_type                   = 'Franchise Employee';
        $cargohold->user_id                     = Auth::guard('femployee')->user()->id;
        $cargohold->shared_with_everyone        = in_array('Everyone',$allowed_types) ? 1 : 0;
        $cargohold->shared_with_franchise_admin = 0;
        $cargohold->shared_with_employees       = in_array('Employees',$allowed_types) ? 1 : 0;
        $cargohold->shared_with_clients         = in_array('Clients',$allowed_types) ? 1 : 0;
        $cargohold->shared_with_self            = 0;
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
    		return redirect('femployee/cargohold');
    		
		}
	}
	
	////////////////
	// Edit Document
	////////////////
	public function editDocument(Request $request, $cargo_id){

        $allowed_types                          = !empty($request->user_type) ? $request->user_type : array();
		$cargohold                              = Cargohold::find($cargo_id);
		$cargohold->franchise_id                = Auth::guard('femployee')->user()->franchise_id;
		$cargohold->title                       = $request->title;
		$cargohold->expiration_date             = date('Y-m-d',strtotime($request->expiration));
		$cargohold->category                    = $request->category;
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
		return redirect('femployee/cargohold');

	}
	
	///////////////////////
	// View cargo hold
	///////////////////////
	public function cargoHoldView($cargo_id){
	    //View PDF 
	    $cargo = Cargohold::find($cargo_id);
		
        $franchise_id = Auth::guard('femployee')->user()->franchise_id;
        $user_id = Auth::guard('femployee')->user()->id;
	    $cat = array('SOS Employee Forms', 'Personal Documents', 'Employee Training', 'Parent Training', 'Employee Default Forms');

	    if($cargo)
	    {
	    	if($cargo->category == 'Employee Default Forms'){
				$franchise_id = 0;
			}
	    	if(($cargo->user_type == 'Franchise Employee' || $cargo->user_type == 'Franchise') && $cargo->franchise_id == $franchise_id && in_array($cargo->category,$cat) ){
			    
			    if(($cargo->category == 'Personal Documents' || $cargo->category == 'Parent Training') && $cargo->user_id == $user_id){

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
				
				}elseif($cargo->category == 'SOS Employee Forms' || $cargo->category == 'Employee Training' || $cargo->category == 'Employee Default Forms'){

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
			    
	    	}else{
				return redirect('femployee/cargohold');
			}
			
		}else{
			return redirect('femployee/cargohold');
		}
	}
	
	///////////////////////
	// Download cargo hold
	///////////////////////
	public function cargoHoldDownload($cargo_id){
	    //DOWNLOAD PDF 
	    $cargo = Cargohold::find($cargo_id);
		
        $franchise_id = Auth::guard('femployee')->user()->franchise_id;
        $user_id = Auth::guard('femployee')->user()->id;
	    $cat = array('SOS Employee Forms', 'Personal Documents', 'Employee Training', 'Parent Training', 'Employee Default Forms');

	    if($cargo)
	    {
	    	if($cargo->category == 'Employee Default Forms'){
				$franchise_id = 0;
			}
	    	if(($cargo->user_type == 'Franchise Employee' || $cargo->user_type == 'Franchise') && $cargo->franchise_id == $franchise_id && in_array($cargo->category,$cat) ){
			    
			    if(($cargo->category == 'Personal Documents' || $cargo->category == 'Parent Training') && $cargo->user_id == $user_id){

				    $file = storage_path(). $cargo->file;
				    $ext = pathinfo($file, PATHINFO_EXTENSION);
				    $headers = array('Content-Type: application/pdf',);
				    return Response::download($file, $cargo->title.'.'.$ext, $headers);
				
				}elseif($cargo->category == 'SOS Employee Forms' || $cargo->category == 'Employee Training' || $cargo->category == 'Employee Default Forms'){

				    $file = storage_path(). $cargo->file;
				    $ext = pathinfo($file, PATHINFO_EXTENSION);
				    $headers = array('Content-Type: application/pdf',);
				    return Response::download($file, $cargo->title.'.'.$ext, $headers);
				}
			    
	    	}else{
				return redirect('femployee/cargohold');
			}
			
		}else{
			return redirect('femployee/cargohold');
		}
	}
	
	/////////////////////
	// Delete Cargo Hold
	/////////////////////
	public function deleteCargoHold($cargo_id){
		
	    $cargo = Cargohold::find($cargo_id);
        $franchise_id = Auth::guard('femployee')->user()->franchise_id;
        $user_id = Auth::guard('femployee')->user()->id;

	    if($cargo){
		    if($cargo->user_type == 'Franchise Employee' && $cargo->franchise_id == $franchise_id && $cargo->category == 'Personal Documents' && $cargo->user_id == $user_id){

		        if(file_exists( storage_path().$cargo->file)){
					unlink(storage_path().$cargo->file);
				}
				$cargo->delete();
				Session::flash('Success','<div class="alert alert-success">Document Deleted successfully</div>');
				return redirect('femployee/cargohold');
							
			}else{
				return redirect('femployee/cargohold');
			}
			
		}else{
			return redirect('femployee/cargohold');
		}
		
	}

    /////////////////////
    // Archive Cargo Hold
    /////////////////////
    public function archiveCargoHold($cargo_id){

        $cargo = Cargohold::find($cargo_id);
        $franchise_id = Auth::guard('femployee')->user()->franchise_id;
        $user_id = Auth::guard('femployee')->user()->id;
        
        if($cargo){
	        if($cargo->user_type == 'Franchise Employee' && $cargo->franchise_id == $franchise_id && $cargo->user_id == $user_id){
		        $cargo->archive = 1;
		        $cargo->save();

		        Session::flash('Success','<div class="alert alert-success">Document Moved to Archive Successfully!</div>');
		        return redirect('femployee/cargohold');
	        }else{
				return redirect('femployee/cargohold');
			}
	        
		}else{
			return redirect('femployee/cargohold');
		}
    }

    /////////////////////
    // Active Cargo Hold
    /////////////////////
    public function activeCargoHold($cargo_id){

        $cargo = Cargohold::find($cargo_id);
        $franchise_id = Auth::guard('femployee')->user()->franchise_id;
        $user_id = Auth::guard('femployee')->user()->id;
		
		if($cargo){
			if($cargo->user_type == 'Franchise Employee' && $cargo->franchise_id == $franchise_id && $cargo->user_id == $user_id){
		        $cargo->archive = 0;
		        $cargo->save();

		        Session::flash('Success','<div class="alert alert-success">Document Moved back to '.$cargo->category.' Successfully!</div>');
		        return redirect('femployee/cargohold');				
			}else{
				return redirect('femployee/cargohold');
			}
			
		}else{
			return redirect('femployee/cargohold');
		}

    }
} 