<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Franchise_audit extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'franchise_audit';
     
	public function franchise(){
		return $this->hasOne('App\Models\Franchise', 'franchise_id', 'id');
	}     
}