<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Orders extends Model
{
     protected $table = 'orders';
     protected $primaryKey = 'id';

    public function order_franchise(){
        return $this->hasOne('App\Models\Franchise', 'id', 'franchise_id');
    }
     
	public function order_products(){
		return $this->hasMany('App\Models\Order_products', 'order_id', 'id');
	}
}