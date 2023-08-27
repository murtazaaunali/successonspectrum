<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Franchise_insurance extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'franchise_insurance';
     
	public function franchise(){
		return $this->hasOne('App\Models\Franchise', 'franchise_id', 'id');
	}     
}