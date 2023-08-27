<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Products extends Model
{
     protected $table = 'products';
     protected $primaryKey = 'id';

	public function order_products(){
		return $this->hasMany('App\Models\order_products', 'product_id', 'id');
	}
	
	public function attributes(){
		return $this->hasMany('App\Models\Products_attributes', 'product_id', 'id');
	}	   
	
	public function gallery(){
		return $this->hasMany('App\Models\Products_images', 'product_id', 'id');
	}	
	
	public function product_category(){
		return $this->hasOne('App\Models\Product_categories', 'id', 'product_category_id');
	}		 
}