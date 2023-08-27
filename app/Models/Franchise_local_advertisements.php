<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Franchise_local_advertisements extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'franchise_local_advertisements';
     
	public function franchise(){
		return $this->hasOne('App\Models\Franchise', 'franchise_id', 'id');
	}     
}