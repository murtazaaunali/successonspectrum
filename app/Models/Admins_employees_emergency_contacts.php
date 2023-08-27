<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Admins_employees_emergency_contacts extends Model
{
     protected $table = 'admins_employees_emergency_contacts';
     protected $primaryKey = 'id';
     
	public function admin_employee(){
		return $this->hasOne('App\Admins_employees', 'admin_employee_id','id');
	}     
}