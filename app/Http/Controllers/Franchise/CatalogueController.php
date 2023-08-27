<?php

namespace App\Http\Controllers\Franchise;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\Franchise\CreateFranchiseRequest;
use App\Http\Requests\Admin\Franchise\EditFranchiseRequest;
use App\Http\Requests\Admin\Franchise\EditFeeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

use App\Models\Cargohold;
use App\Models\Products;
use App\Models\Product_categories;
use App\Models\Products_images;
use App\Models\Products_attributes;
use App\Models\Product_images_temp;
use App\Models\Orders;

//Franchise Models
use App\Models\Franchise;

use Session;
use Illuminate\Support\Facades\Storage;

class CatalogueController extends Controller
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

	
	///////////////////
	// PRODUCTS LIST
	//////////////////
    public function index(Request $request)
    {
    	//$request->session()->forget(['products_count','cart','tax']);
    	//echo '<pre>';print_r(session()->all());exit;
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Catalog";
        $sub_title                      = "Catalog";
        $menu                           = "catalog";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $products = Products::paginate($this->pagelimit);

        $all_categories = Product_categories::where("status","Active")->get();

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "products"                              => $products,
            "categories"                            => $all_categories
        );
        
	    return view('franchise.catalog.catalog',$data);
    }

	////////////////
	// VIEW PRODUCT 
	////////////////
	public function viewProduct($product_id){
  
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "View Product";
        $sub_title                      = "View Catalog";
        $menu                           = "catalog";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $product = Products::find($product_id);
        if(!$product) return redirect('franchise/catalogue');
        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "product"								=> $product
        );

        return view('franchise.catalog.viewproduct',$data);		
	}
	
	public function thankyou(){
       /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Catalog";
        $sub_title                      = "Catalog";
        $menu                           = "catalog";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
        );

        return view('franchise.catalog.thankyou',$data);				
	}
    
}
