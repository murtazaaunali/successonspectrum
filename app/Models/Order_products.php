<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order_products extends Model
{
     protected $table = 'order_products';
     protected $primaryKey = 'id';
     
	public function product(){
		return $this->hasOne('App\Models\Products', 'product_id', 'id');
	}
}