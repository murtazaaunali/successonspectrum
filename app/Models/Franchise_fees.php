<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Franchise_fees extends Model
{
    protected $table = 'franchise_fees';
    protected $primaryKey = 'id';
     
	public function franchise(){
		return $this->hasOne('App\Models\Franchise', 'franchise_id', 'id');
	}     
}