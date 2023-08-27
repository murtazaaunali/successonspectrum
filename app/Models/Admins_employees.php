<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Admins_employees extends Model
{
	protected $table = 'admins_employees';
	protected $primaryKey = 'id';
     
	public function employee_emergency_contact(){
		return $this->hasMany('App\Models\Admins_employees_emergency_contacts', 'admin_employee_id' ,'id');
	}     

	public function employees_time_punch(){
		return $this->hasMany('App\Admin_employees_time_punch', 'admin_employee_id','id');
	}  

	public function performance_logs(){
		return $this->hasMany('App\Models\Admin_employees_performance_log', 'admin_employee_id','id');
	}  

	public function employee_payroll(){
		return $this->hasMany('App\Models\Admin_employees_performance_log', 'admin_employee_id','id');
	}  
	
	public function employee_schedules(){
		return $this->hasOne('App\Models\Admins_employees_schedules', 'admin_employee_id','id');
	}
	
	public function tasklist(){
		return $this->hasMany('App\Models\Employee_tasklist', 'employee_id', 'id');
	}
	
	public function timepunches(){
		return $this->hasMany('App\Models\Admin_employees_time_punch', 'admin_employee_id', 'id');
	}
}