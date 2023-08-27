<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Products_attributes extends Model
{
     protected $table = 'product_attributes';
     protected $primaryKey = 'id';
     
	public function product(){
		return $this->hasOne('App\Products', 'product_id', 'id');
	}
}