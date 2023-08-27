<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Franchise_payments extends Model
{
     protected $table = 'franchise_payments';
     protected $primaryKey = 'id';
     
	public function franchise(){
		return $this->hasOne('App\Franchise', 'franchise_id', 'id');
	}     
}