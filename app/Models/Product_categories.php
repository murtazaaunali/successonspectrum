<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Product_categories extends Model
{
     protected $table = 'product_categories';
     protected $primaryKey = 'id';
     
	public function admin(){
		return $this->hasOne('App\Models\Admin', 'created_by', 'id');
	}     
	
	public function products(){
		return $this->hasMany('App\Models\Products', 'product_category_id', 'id');
	}	
}