<?php
namespace App\Http\Controllers;

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
use App\Models\Orders;
use App\Models\Products;
use App\Models\Franchise;
use App\Models\Notifications;
use App\Models\Order_products;

class Cart extends Controller
{
	function __construct(){
		$users[] = Auth::user();
		$users[] = Auth::guard()->user();
		$users[] = Auth::guard('franchise')->user();
	}
	
	public function index(REQUEST $request){
		$product_id = $request->product_id;
		$product = Products::find($product_id);
		if($product){
			
			if($product->stock_quantity > 0 && $product->stock_status == 'In Stock'){
				if($request->quantity > $product->stock_quantity){
					$msg = '';
					if($product->stock_quantity > 1){
						$msg = $product->stock_quantity.' products';
					}else{
						$msg = $product->stock_quantity.' product';
					}
					return response()->json(['message'=> 'error', 'error_message' => "Sorry! Only ".$product->stock_quantity." products available in stock"]);
				}
			}else{
				return response()->json(['message'=> 'error', 'error_message' => 'No products available in stock']);
			}
			
			$cart = array(); $count = 0; $tax = 0;
			$getCart = $request->session()->get('cart');
			$checkProduct = true;
			if( is_array($getCart) && !empty($getCart) ){
				
				foreach($getCart as $cartVal){
					
					if($cartVal['product_id'] == $product_id){
						$checkProduct = false;
						
						$currProduct = Products::find($cartVal['product_id']);
						$tax = $tax + $this->tax($currProduct->tax, $cartVal['price'] * $cartVal['quantity']);
						$cartVal['quantity'] = $cartVal['quantity'] + $request->quantity;
						$cartVal['selling_price'] = number_format((float)$cartVal['price'] * $cartVal['quantity'], 2, '.', '');
						$count++;
						
						if($cartVal['quantity'] > $product->stock_quantity){
							$msg = '';
							if($product->stock_quantity > 1){
								$msg = $product->stock_quantity.' products';
							}else{
								$msg = $product->stock_quantity.' product';
							}
							return response()->json(['message'=> 'error', 'error_message' => "Sorry! Only ".$msg." available in stock"]);
						}
					}else{
						$count++;
					}
					$cart[] = $cartVal;
				}
				
				$tax = $tax + $request->session()->get('tax');
			}
			
			if($checkProduct){
				$tax = $tax + $this->tax($product->tax, $product->selling_price * $request->quantity);
				$cart[] = array('product_id' => $product_id, 'name' => $product->product_name, 'price' => $product->selling_price, 'selling_price'=> number_format((float)$product->selling_price * $request->quantity, 2, '.', ''), 'image'=> $product->image, 'quantity'=>$request->quantity);
				$count++;
			}
			
			$request->session()->put('cart',$cart);
			
			//Count plus one for new product
			$request->session()->put('products_count',$count);
			$request->session()->put('tax',$tax);
			
			return response()->json(['message'=> 'success', 'products' => $cart]);
		}
		
	}

    ///////////
    //VIEW CART
    ///////////
    public function viewCart(REQUEST $request){
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */
        $page_title                     = "Catalog";
        $sub_title                      = "Catalog";
        $inner_title                    = "Cart";
        $menu                           = "catalog";
        $sub_menu                       = "";
        /*
         * Required parameters for all views to active in active menus and to set the page title with main title of specific page
        */

        $products = array();
        if(Session::has('cart')){
			$products = $request->session()->get('cart');
		}
		
        $data = array(
            "page_title"                            => $page_title,
            "sub_title"                             => $sub_title,
            "inner_title"                           => $inner_title,
            "menu"                                  => $menu,
            "sub_menu"                              => $sub_menu,
            "products"								=> $products
        );
 		
	    return view('franchise.catalog.list',$data);		
	}	
	
	public function updateCart(REQUEST $request){
		if($request->has('quantity')){
			
			$cart = array(); $count = 0; $tax = 0;

			foreach($request->quantity as $product_id => $qty){
				
				//Checking how many products available in stock
				$product = Products::find($product_id);
				if($product){
					if($product->stock_quantity > 0 && $product->stock_status == 'In Stock'){
						if($qty > $product->stock_quantity){
							$msg = '';
							if($product->stock_quantity > 1){
								$msg = $product->stock_quantity.' products';
							}else{
								$msg = $product->stock_quantity.' product';
							}
							Session::flash('Error', "<div class='alert alert-danger'>Sorry! Only ".$product->stock_quantity." products available in stock</div>");
							return redirect('franchise/viewcart');
						}
					}else{
						Session::flash('Error', '<div class="alert alert-danger">No products available in stock</div>');
						return redirect('franchise/viewcart');
					}
				}//Checking how many products available in stock
				
				foreach($request->session()->get('cart') as $product){
					
					if($qty > 0 && $qty != ''){
						if($product_id == $product['product_id']){
							//$getProduct = Products::find($product['product_id']);

							$currProduct = Products::find($product['product_id']);
							$tax = $tax + $this->tax($currProduct->tax, $product['price'] * $qty);

							$product['quantity'] = $qty;
							
							$product['selling_price'] = number_format((float)$product['price'] * $qty, 2, '.', '');
							$cart[] = $product;
							$count++;
						}
					}else{
						$count - 1;
					}
				}
				
			}
			$request->session()->forget('cart');
			if($count) {
				$request->session()->put('cart',$cart);
				$request->session()->put('tax',$tax);
				$request->session()->put('products_count',$count);
			}else{
				$request->session()->forget('products_count');
				$request->session()->forget('tax',$tax);
			}
			return redirect('franchise/viewcart');
		}
	}
	
	public function checkout(REQUEST $request){
		if($request->session()->has('cart') && is_array($request->session()->get('cart')) ){

			$total_amount = 0;
			$franchise_id = Auth::guard('franchise')->user()->franchise_id;
			$Franchise = Franchise::find($franchise_id);
			
			foreach($request->session()->get('cart') as $product){
				$total_amount = $total_amount + $product['selling_price'];
			}

			$order = new Orders();
			$order->franchise_id = $franchise_id;
			$order->location = $Franchise->location;
			$order->total_amount = $total_amount;
			$order->status = 'Pending';
			$order->save();
			
			foreach($request->session()->get('cart') as $product){
				$total_amount = $total_amount + $product['selling_price'];
				$getProduct = Products::find($product['product_id']);
				
				//Adding order products
				$order_products = new Order_products();
				$order_products->order_id 		= $order->id;
				$order_products->product_id 	= $product['product_id'];
				$order_products->product_name 	= $product['name'];
				$order_products->quantity 		= $product['quantity'];
				$order_products->cost_price 	= $getProduct->cost_price;
				$order_products->selling_price 	= $getProduct->selling_price;
				$order_products->tax 			= $this->tax($getProduct->tax, $product['price'] * $product['quantity']);
				$order_products->total 			= $product['selling_price'];
				$order_products->save();
			}
			
			$GetOrder = Orders::find($order->id);
			$Franchise = Franchise::find($order->franchise_id);

	        //EMAIL FOR FRANCHISE WHO ORDERED
	        $messgeEmail = 'Your Order has been placed.<br>';
	        $data = array("name" => $Franchise->location, "email" => $Franchise->email, "messages" => $messgeEmail);
	        \Mail::send('email.order_email', [ "link"=>url('franchise/login'), 'order'=>$GetOrder, 'messages' => $messgeEmail], function ($message) use ($data) {
	            $message->from('sos@testing.com', 'SOS');
	            $message->to($data['email'])->subject("New Order Placed!");
	        });	

	        //EMAIL FOR ADMIN
	        $messgeEmail = 'New order has been placed by ('.$Franchise->location.')<br>';
	        $Admin = Admin::where('type','Super Admin')->first();
	        if($Admin){
		        $data = array("name" => $Admin->fullname, "email" => $Admin->email, "messages" => $messgeEmail);
		        \Mail::send('email.order_email', [ "link"=>url('admin/login'), 'order'=>$GetOrder, 'messages' => $messgeEmail], function ($message) use ($data) {
		            $message->from('sos@testing.com', 'SOS');
		            $message->to($data['email'])->subject("New Order Placed!");
		        });	
			}

	        $newNoti = new Notifications();
	        $newNoti->title = '<a href="/admin/catalogue/orders/view_order/'.$order->id.'">New order!</a>';
	        $newNoti->description = 'New order has been placed by ('.$Franchise->location.')';
	        $newNoti->type = 'Notice';
	        $newNoti->send_to_admin = '1';
	        $newNoti->user_id = Auth::user()->id;
	        $newNoti->franchise_id = 0;
	        $newNoti->user_type = 'Administration';
	        $newNoti->send_to_type = 'Director of Administration';
	        $newNoti->notification_type = 'System Notification';
	        $newNoti->save();			
			
			$request->session()->forget(['products_count','cart','tax']);
			return redirect('franchise/catalog/prothankyou');
		}else{
			echo 'cart is empty';exit;
		}
	}

    //Calculating tax
    public function tax($tax, $price){
    	if($tax){
			return $price / 100 * $tax;
		}else{
			return 0;
		}
		
	}

}
