<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Admin_employees_payroll extends Model
{
	protected $table = 'admin_employees_payroll';
	protected $primaryKey = 'id';
     
	public function admin_employee(){
		return $this->hasOne('App\Admins_employees', 'admin_employee_id','id');
	}   
}