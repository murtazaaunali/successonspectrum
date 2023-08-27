<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Franchise_owners extends Model
{
     protected $table = 'franchise_owners';
     protected $primaryKey = 'id';
     
	public function franchise(){
		return $this->hasOne('App\Franchise', 'franchise_id', 'id');
	}     
}