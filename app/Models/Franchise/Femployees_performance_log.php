<?php

namespace App\Models\Franchise;
use Illuminate\Database\Eloquent\Model;
class Femployees_performance_log extends Model
{
     protected $table = 'femployees_performance_log';
     protected $primaryKey = 'id';
     
	public function admin_employee(){
		return $this->hasOne('App\Admins_employees', 'admin_employee_id', 'id');
	}     
}