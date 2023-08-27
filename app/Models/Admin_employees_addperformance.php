<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Admin_employees_addperformance extends Model
{
     protected $table = 'admins_performances_reviews';
     protected $primaryKey = 'id';
     
	public function admin_employee(){
		return $this->hasOne('App\Admins_employees', 'admin_employee_id', 'id');
	}     
}