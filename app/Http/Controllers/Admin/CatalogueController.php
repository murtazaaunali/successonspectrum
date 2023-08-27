<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\Franchise\CreateFranchiseRequest;
use App\Http\Requests\Admin\Franchise\EditFranchiseRequest;
use App\Http\Requests\Admin\Franchise\EditFeeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

use App\Models\Orders;
use App\Models\Products;
use App\Models\Cargohold;
use App\Models\Products_images;
use App\Models\Product_categories;
use App\Models\Products_attributes;
use App\Models\Product_images_temp;


//Franchise Models
use App\Models\Franchise;

use Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\ImageManager;

class CatalogueController extends Controller
{

	function __construct()
	{
		$users[] = Auth::user();
		$users[] = Auth::guard()->user();
		$users[] = Auth::guard('admin')->user();
	}

	
	///////////////////
	// PRODUCTS LIST
	//////////////////
    public function index(Request $request)
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Catalogue";
        $sub_title                      = "Catalogue";
        $menu                           = "catalogue";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $products = Products::when($request->stock, function ($query, $stock_status) {
            return $query->where('stock_status', $stock_status);
        })
         ->when($request->category, function ($query, $category) {
            return $query->where('product_category_id',$category);
         })->paginate($this->pagelimit);

        $all_categories = Product_categories::where("status","Active")->get();

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "products"                              => $products,
            "categories"                            => $all_categories
        );
 		
	    return view('admin.catalogue.catalogue',$data);
    }
    
    
    ////////////////////
    // PRODUCT FORM
    ////////////////////
    public function productForm(){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Add New Product";
        $sub_title                      = "Corporate Catalogue";
        $menu                           = "catalogue";
        $sub_menu                       = "catalogue_product";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $all_categories = Product_categories::where("status","Active")->get();
        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "categories"							=> $all_categories
        );
		
	    return view('admin.catalogue.addproduct',$data);		
	}
	
	///////////////////////
	// ADD PRODUCT
	//////////////////////
	public function saveProduct(Request $request){
		
		$product = new Products();
		$product->product_name 			= $request->name;
		$product->product_description 	= $request->description;
		$product->product_category_id 	= $request->category;
		$product->stock_quantity 		= $request->stock_quantity;
		$product->cost_price 			= $request->cost_price;
		$product->selling_price 		= $request->selling_price;
		$product->tax 					= $request->tax;
		$product->creater_id 			= Auth::guard('admin')->user()->id;
		$product->creater_type 			= 'Super Admin';
		$product->stock_status 			= ($request->stock_quantity > 0) ? 'In Stock' : 'Out of Stock';;
		$product->save();
		
		//ADDING PRODUCCT ATTRIBUTES
		if($request->has('p_attributes')){
			foreach($request->p_attributes as $attr){
				$newAttr = new Products_attributes();
				$newAttr->attribute_description = $attr;
				$newAttr->product_id = $product->id;
				$newAttr->save();
			}
		}

		//PRODUCT THUMBNAIL UPLOADING
		if ($request->has('product_image') ){
	    		//Save product gallery
	    		$getImageTemp = Product_images_temp::find($request->product_image);
	    		$newPath = 'public/products_images/'.basename($getImageTemp->image_path);
	    		
	    		//Moving the file from temporary folder to new folder
	    		Storage::move($getImageTemp->image_path, $newPath);
	    		$product->image = Storage::url($newPath);
	    		$product->save();
	    		
				//Deleting Temporary Date from table
				$getImageTemp->delete();
		}
		
		//PRODUCT GALLERY UPLOADINGS
		if ($request->has('product_gallery') ){
			foreach($request->product_gallery as $image){
	    		//Save product gallery
	    		$getImageTemp = Product_images_temp::find($image);
	    		
	    		//creating new path for product gallery
	    		$newPath = 'public/products_gallery/'.basename($getImageTemp->image_path);
	    		
	    		//Moving the file from temporary folder to new folder
	    		Storage::move($getImageTemp->image_path, $newPath);
	    		
	    		//adding product images
	    		$product_images = new Products_images();
	    		$product_images->image_path = Storage::url($newPath);
	    		$product_images->product_id = $product->id;
				$product_images->save();
				
				//Deleting Temporary Date from table
				$getImageTemp->delete();
			}
		}
		
		Session::flash('Success','<div class="alert alert-success">Product added successfully</div>');
		return redirect('admin/catalogue');
	}
	
	
	////////////////////
	// PRODUCT GALLERY 
	////////////////////
	public function storeGallery(Request $request){

		$image_ids = array();
		// UPLOADING PRODUCT GALLERY
        if($request->product_gallery)
        {
        	$file = $request->product_gallery;
            $file_storage   = 'public/products_gallery/temp';
            $put_data       = Storage::put($file_storage, $file);
            //$full_path      = Storage::url($put_data);
            
            $product_temp = new Product_images_temp();
            $product_temp->image_path = $put_data;
            $product_temp->save();
            $image_ids[$file->getClientOriginalName()] = $product_temp->id;
            
            return response()->json(['image_ids' => $image_ids]);
        }else{
			return response()->json(['error' => 'Something wents wrong']); 
		}
		
	}


	////////////////////
	// PRODUCT IMAGE 
	////////////////////
	public function storeImage(Request $request){

		$image_ids = array();
		// UPLOADING PRODUCT IMAGE
        if($request->product_image)
        {
        	$file = $request->product_image;
            $file_storage   = 'public/products_images/temp';
            $put_data       = Storage::put($file_storage, $file);
            //$full_path      = Storage::url($put_data);
            
            $product_temp = new Product_images_temp();
            $product_temp->image_path = $put_data;
            $product_temp->save();
            $image_ids[$file->getClientOriginalName()] = $product_temp->id;
            
            return response()->json(['image_ids' => $image_ids]);
        }else{
			return response()->json(['error' => 'Something wents wrong']); 
		}
		
	}	

	////////////////
	// VIEW PRODUCT 
	////////////////
	public function viewProduct($product_id){
  
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "View Product";
        $sub_title                      = "View Catalogue";
        $menu                           = "catalogue";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $product = Products::find($product_id);
        if(!$product) return redirect('admin/catalogue');
        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "product"								=> $product
        );

        return view('admin.catalogue.viewproduct',$data);		
	}

    ////////////////////
    // PRODUCT FORM EDIT
    ////////////////////
    public function productEditForm($product_id){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Edit Product";
        $sub_title                      = "Edit Product";
        $menu                           = "catalogue";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
		$all_categories = Product_categories::where("status","Active")->get();
        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "categories"                             => $all_categories
        );
		
		$product = Products::find($product_id);
		if(!$product) return redirect('admin/catalogue');
		
		$data['product'] = $product;
		
	    return view('admin.catalogue.editproduct',$data);		
	}


	///////////////////////
	// UPDATES PRODUCT
	//////////////////////
	public function updateProduct(Request $request){
		
		$product = Products::find($request->product_id);
		$product->product_name 			= $request->name;
		$product->product_description 	= $request->description;
		$product->product_category_id 	= $request->category;
		$product->stock_quantity 		= $request->stock_quantity;
		$product->cost_price 			= $request->cost_price;
		$product->selling_price 		= $request->selling_price;
		$product->tax 					= $request->tax;
		$product->creater_id 			= Auth::guard('admin')->user()->id;
		$product->creater_type 			= 'Super Admin';
		$product->stock_status 			= ($request->stock_quantity > 0) ? 'In Stock' : 'Out of Stock';
		$product->save();
		
		//ADDING PRODUCCT ATTRIBUTES
		Products_attributes::where('product_id',$request->product_id)->delete();
		if($request->has('p_attributes')){
			foreach($request->p_attributes as $attr){
				$newAttr = new Products_attributes();
				$newAttr->attribute_description = $attr;
				$newAttr->product_id = $product->id;
				$newAttr->save();
			}
		}

		//PRODUCT THUMBNAIL UPLOADING
		if ($request->has('product_image') ){
				//Deleting Previous Images
				Storage::delete('public/products_images/'.basename($product->image));
				
	    		//Save product gallery
	    		$getImageTemp = Product_images_temp::find($request->product_image);
	    		$newPath = 'public/products_images/'.basename($getImageTemp->image_path);
	    		
	    		//Moving the file from temporary folder to new folder
	    		Storage::move($getImageTemp->image_path, $newPath);
	    		$product->image = Storage::url($newPath);
	    		$product->save();
	    		
				//Deleting Temporary Date from table
				$getImageTemp->delete();
		}
		
		//PRODUCT GALLERY UPLOADINGS
		if ($request->has('product_gallery') ){
			foreach($request->product_gallery as $image){
	    		//Save product gallery
	    		$getImageTemp = Product_images_temp::find($image);
	    		
	    		//creating new path for product gallery
	    		$newPath = 'public/products_gallery/'.basename($getImageTemp->image_path);
	    		
	    		//Moving the file from temporary folder to new folder
	    		Storage::move($getImageTemp->image_path, $newPath);
	    		
	    		//adding product images
	    		$product_images = new Products_images();
	    		$product_images->image_path = Storage::url($newPath);
	    		$product_images->product_id = $product->id;
				$product_images->save();
				
				//Deleting Temporary Date from table
				$getImageTemp->delete();
			}
		}
		
		Session::flash('Success','<div class="alert alert-success">Product Updated successfully</div>');
		return redirect('admin/catalogue');
	}
	
	////////////////
	//DELETE IMAGE
	////////////////
	public function deleteImage(Request $request){
		if($request->image_id){
			
			$P_image = Products_images::find($request->image_id);
			
			//Deleting Image
			Storage::delete('public/products_gallery/'.basename($P_image->image_path));
			
			$P_image->delete();
			
			return response()->json('success');
		}
	}


	////////////////
	//Get Orders
	////////////////
	public function getOrders(Request $request)
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Catalogue Orders";
        $inner_title                    = "Orders List";
        $sub_title                      = "Orders";
        $menu                           = "catalogue";
        $sub_menu                       = "order";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $orders = Orders::when($request->order, function ($query, $id) {
            return $query->where('id', $id);
        })
        ->when($request->franchise, function ($query, $franchise) {
            return $query->where('franchise_id',$franchise);
        })
        ->when($request->status, function ($query, $status) {
            return $query->where('status',$status);
        })
        ->when($request->start_date, function ($query, $start_date) {
            $start_date = str_replace('/','-',$start_date);
            return $query->where('created_at','>=',date("Y-m-d 00:00:00",strtotime($start_date)));
        })
        ->when($request->end_date, function ($query, $end_date) {
            $end_date = str_replace('/','-',$end_date);
            return $query->where('created_at','<=',date("Y-m-d 23:59:59",strtotime($end_date)));
        })
        ->paginate(1);

        $all_franchises = Franchise::get();

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "inner_title"                           => $inner_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "orders"                                => $orders,
            "all_franchises"                        => $all_franchises,
        );

        return view('admin.orders.list',$data);
    }

    //////////////////
    //ORDER VIEW
    //////////////////
    public function viewOrder($id)
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Catalogue Orders";
        $inner_title                    = "Order Details";
        $sub_title                      = "View Order";
        $menu                           = "catalogue";
        $sub_menu                       = "order";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $order = Orders::find($id);

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "inner_title"                           => $inner_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "order"                                 => $order,
        );


        return view('admin.orders.view',$data);
    }

    //////////////////
    //ORDER EDIT
    //////////////////
    public function edit_order($id)
    {
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Catalogue Orders";
        $inner_title                    = "Order Details";
        $sub_title                      = "Edit Order";
        $menu                           = "catalogue";
        $sub_menu                       = "order";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $order = Orders::find($id);

        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "inner_title"                           => $inner_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "order"                                 => $order,
        );


        return view('admin.orders.edit',$data);
    }

    //////////////////
    //ORDER SAVE
    //////////////////
    public function order_save(Request $request)
    {
        $order_id = $request->order_id;
        $getOrder = Orders::find($order_id);
        if($getOrder)
        {
            $getOrder->status   = $request->status;
            $getOrder->comment  = $request->comment;
            $getOrder->save();

            Session::flash('Success','<div class="alert alert-success">Order Updated successfully</div>');
            return redirect(route('admin.orders_list'));
        }
        else
            return redirect()->back()->withErrors(['Ops Something went wrong!']);
    }
    
    //////////////////
    //DELETE PRODUCT 
    //////////////////
    public function deleteProduct($product_id){
		$Pro = Products::find($product_id);
		$Pro->delete();
		
		Products_images::where('product_id',$product_id)->delete();
		Products_attributes::where('product_id',$product_id)->delete();		

		Session::flash('Success','<div class="alert alert-success">Product successfully deleted</div>');
		return redirect('/admin/catalogue');
	}
    
}
