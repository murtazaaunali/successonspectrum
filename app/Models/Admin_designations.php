<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Admin_designations extends Model
{
     protected $table = 'admin_designations';
     protected $primaryKey = 'id';
     
	public function admins(){
		return $this->hasMany('App\Models\Admin', 'dasignation_id','id');
	}     
}