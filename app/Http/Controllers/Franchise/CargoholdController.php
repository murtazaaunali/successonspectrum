<?php

namespace App\Http\Controllers\Franchise;

use Illuminate\Http\Request;

use App\Http\Requests\Franchise\Cargohold\UploadDocumentRequest;

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
		$users[] = Auth::guard('franchise')->user();
		$users[] = Auth::guard('franchise')->user();
		$this->middleware(function ($request, $next) {
		    $this->user = auth()->user();
			//If user type is not owner or manager then redirecting to dashboard
			if($this->user->type != 'Owner' && $this->user->type != 'Manager'){
				return redirect('franchise/dashboard');
			}
		    return $next($request);
		});
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
        $franchise_id = Auth::guard('franchise')->user()->franchise_id;
        
        $data['Template_Company_Forms'] 		= Cargohold::where('category','Template Company Forms')
        											->orWhere('category','Completed Franchisee Forms')
        											->where(array('archive'=>'0','user_type'=>'Admin', 'franchise_id'=>$franchise_id))
        											->orWhere(array('archive'=>'0','user_type'=>'Franchise', 'franchise_id'=>0))->paginate(40);
        $data['Personal_Documents'] 			= Cargohold::where('category','Personal Documents')->where(array('archive'=>'0','user_type'=>'Franchise', 'franchise_id'=>$franchise_id))->paginate(40);
        $data['Employee_Training'] 				= Cargohold::where('category','Employee Training')->where(array('archive'=>'0','user_type'=>'Franchise', 'franchise_id'=>$franchise_id))->paginate(40);
        $data['Parent_Training'] 				= Cargohold::where('category','Parent Training')->where(array('archive'=>'0','user_type'=>'Franchise', 'franchise_id'=>$franchise_id))->paginate(40);
        $data['SOS_Employee_Forms'] 			= Cargohold::where('category','SOS Employee Forms')->where(array('archive'=>'0','user_type'=>'Franchise', 'franchise_id'=>$franchise_id))->paginate(40);
        $data['SOS_Parent_Forms'] 				= Cargohold::where('category','SOS Parent Forms')->where(array('archive'=>'0','user_type'=>'Franchise', 'franchise_id'=>$franchise_id))->paginate(40);
		$data['SOS_Reports'] 					= Cargohold::where('category','SOS Reports')->where(array('archive'=>'0', 'franchise_id'=>$franchise_id))->whereIn('user_type',array('Franchise','Parent'))->paginate(40);
        $data['Archives'] 						= Cargohold::where(array('archive'=>1, 'user_type' => 'Franchise', 'franchise_id'=>$franchise_id))->paginate(40);
        

        //echo '<pre>';print_r($cargoholds);exit;
		
	    return view('franchise.cargohold.cargohold',$data);
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
		$data['action'] = url('franchise/cargohold/add-document');
		$data['type'] = 'add';
		if($request->has('cargo_id') && $request->get('cargo_id') ){
			
			$cargohold = Cargohold::find($request->get('cargo_id'));
			
			if($cargohold){
				if($cargohold->user_type != 'Franchise'){
					return redirect('franchise/cargohold');
				}

	            $user_types = array();
				$user_types[] = 'Franchise';

				if(!$cargohold) return redirect('franchise/cargohold');
				$data['title'] 			= $cargohold->title;
				$data['franchise_id'] 	= $cargohold->franchise_id;
				$data['expiration'] 	= $cargohold->expiration_date;
				$data['category'] 		= $cargohold->category;
				$data['user_type'] 		= $user_types;
				$data['action'] 		= url('franchise/cargohold/edit-document/'.$cargohold->id);
				$data['type'] = 'edit';				
			}
		}

		return view('franchise.cargohold.cargoholdUpload', $data);
	}
	
	////////////////
	// Add document
	////////////////
	public function addDocument(UploadDocumentRequest $request){

	    $allowed_types                          = !empty($request->user_type) ? $request->user_type : array();
	    $cargohold                              = new Cargohold();
		$cargohold->franchise_id                = Auth::guard('franchise')->user()->franchise_id;
		$cargohold->title                       = $request->title;
		$cargohold->expiration_date             = date('Y-m-d',strtotime($request->expiration));
		$cargohold->category                    = $request->category;
		$cargohold->user_type                   = 'Franchise';
        $cargohold->user_id                     = Auth::guard('franchise')->user()->id;
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
    		return redirect('franchise/cargohold');
    		
		}
	}
	
	////////////////
	// Edit Document
	////////////////
	public function editDocument(Request $request, $cargo_id){

        $allowed_types                          = !empty($request->user_type) ? $request->user_type : array();
		$cargohold                              = Cargohold::find($cargo_id);
		
		if($cargohold){
			$cargohold->franchise_id                = Auth::guard('franchise')->user()->franchise_id;
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

			$tab = '';
			if($request->category == 'Personal Documents') 			$tab = '?tab=tab1';
			if($request->category == 'Employee Training') 			$tab = '?tab=tab2';
			if($request->category == 'Parent Training') 			$tab = '?tab=tab3';
			if($request->category == 'SOS Employee Forms') 			$tab = '?tab=tab4';
			if($request->category == 'SOS Parent Forms') 			$tab = '?tab=tab5';
			if($request->category == 'SOS Reports') 				$tab = '?tab=tab7';
					
			Session::flash('Success','<div class="alert alert-success">Document updated successfully</div>');
			return redirect('franchise/cargohold/'.$tab);			
		}else{
			return redirect('franchise/cargohold/');		
		}

	}
	
	///////////////////////
	// View cargo hold
	///////////////////////
	public function cargoHoldView($cargo_id){
	    //View PDF 
	    $cargo = Cargohold::find($cargo_id);
		$F_id = Auth::guard('franchise')->user()->franchise_id;
		if(($cargo->user_type == 'Franchise' || $cargo->user_type == 'Admin') && $cargo->franchise_id == $F_id || $cargo->franchise_id == 0){
			if($cargo){
				$file = storage_path(). $cargo->file;
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				/*return Response::make(file_get_contents($file), 200, [
					'Content-Type' => 'application/pdf',
					'Content-Disposition' => 'inline; filename="'.$cargo->title.'.'.$ext.'"'
				]);*/
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
			return redirect('franchise/cargohold/');
		}
	}
	
	///////////////////////
	// Download cargo hold
	///////////////////////
	public function cargoHoldDownload($cargo_id){
	    //DOWNLOAD PDF 
	    $cargo = Cargohold::find($cargo_id);
	    $F_id = Auth::guard('franchise')->user()->franchise_id;
	    if(($cargo->user_type == 'Franchise' || $cargo->user_type == 'Admin') && $cargo->franchise_id == $F_id || $cargo->franchise_id == 0){
		    if($cargo){
			    $file = storage_path(). $cargo->file;
			    $ext = pathinfo($file, PATHINFO_EXTENSION);
			    $headers = array('Content-Type: application/pdf',);
			    return Response::download($file, $cargo->title.'.'.$ext, $headers);					
			}
		}else{
			return redirect('franchise/cargohold/');
		}
	}
	
	/////////////////////
	// Delete Cargo Hold
	/////////////////////
	public function deleteCargoHold($cargo_id){
		
	    $cargo = Cargohold::find($cargo_id);
	    $F_id = Auth::guard('franchise')->user()->franchise_id;
	    if($cargo->user_type == 'Franchise' && $cargo->franchise_id == $F_id){
		    if($cargo){

		        if(file_exists( storage_path().$cargo->file)){
					unlink(storage_path().$cargo->file);
				}

				$tab = '';
				if($cargo->category == 'Personal Documents')$tab = '?tab=tab1';
				if($cargo->category == 'Employee Training') $tab = '?tab=tab2';
				if($cargo->category == 'Parent Training') 	$tab = '?tab=tab3';
				if($cargo->category == 'SOS Employee Forms')$tab = '?tab=tab4';
				if($cargo->category == 'SOS Parent Forms') 	$tab = '?tab=tab5';
				if($cargo->category == 'SOS Reports') 		$tab = '?tab=tab7';
			
				$cargo->delete();

				Session::flash('Success','<div class="alert alert-success">Document Deleted successfully</div>');
				return redirect('franchise/cargohold/'.$tab);
							
			}else{
				return redirect('franchise/cargohold');
			}			
		}else{
			return redirect('franchise/cargohold');
		}
	    
	}

    /////////////////////
    // Archive Cargo Hold
    /////////////////////
    public function archiveCargoHold($cargo_id){

	    $cargo = Cargohold::find($cargo_id);
        if($cargo->user_type == 'Franchise' && $cargo->franchise_id == Auth::guard('franchise')->user()->franchise_id){
	        $cargo->archive = 1;
	        $cargo->save();

	        Session::flash('Success','<div class="alert alert-success">Document Moved to Archive Successfully!</div>');
	        return redirect('franchise/cargohold/?tab=tab8');
		}else{
			return redirect('franchise/cargohold');
		}
    }

    /////////////////////
    // Active Cargo Hold
    /////////////////////
    public function activeCargoHold($cargo_id){

        $cargo = Cargohold::find($cargo_id);
	    
        if($cargo->user_type == 'Franchise' && $cargo->franchise_id == Auth::guard('franchise')->user()->franchise_id){
	        $cargo->archive = 0;
	        $cargo->save();

			$tab = '';
			if($cargo->category == 'Personal Documents')$tab = '?tab=tab1';
			if($cargo->category == 'Employee Training') $tab = '?tab=tab2';
			if($cargo->category == 'Parent Training') 	$tab = '?tab=tab3';
			if($cargo->category == 'SOS Employee Forms')$tab = '?tab=tab4';
			if($cargo->category == 'SOS Parent Forms') 	$tab = '?tab=tab5';
			if($cargo->category == 'SOS Reports') 		$tab = '?tab=tab7';

	        Session::flash('Success','<div class="alert alert-success">Document Moved back to '.$cargo->category.' Successfully!</div>');
	        return redirect('franchise/cargohold/'.$tab);
		}
    }
} 