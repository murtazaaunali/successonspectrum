<?php

namespace App\Models\Franchise;
use Illuminate\Database\Eloquent\Model;

class Femployee extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $primaryKey = 'id';
    protected $table = 'employment_form';
	    
	//Type Employee Functions
	public function employee_emergency_contact(){
		return $this->hasMany('App\Models\Franchise\Femployees_emergency_contacts', 'admin_employee_id' ,'id');
	}     

	public function employees_time_punch(){
		return $this->hasMany('App\Models\Franchise\Femployees_time_punch', 'admin_employee_id','id');
	}  

	public function performance_logs(){
		return $this->hasMany('App\Models\Franchise\Femployees_performance_log', 'admin_employee_id','id');
	}  

	public function employee_payroll(){
		return $this->hasMany('App\Models\Franchise\Femployees_performance_log', 'admin_employee_id','id');
	}  
	
	public function employee_schedules(){
		return $this->hasOne('App\Models\Franchise\Femployees_schedules', 'admin_employee_id','id');
	}
	
	public function tasklist(){
		return $this->hasMany('App\Models\Franchise\Femployees_tasklist', 'employee_id', 'id');
	}
	
	public function timepunches(){
		return $this->hasMany('App\Models\Franchise\Femployees_time_punch', 'admin_employee_id', 'id');
	} 
	
	public function aba_experience_reference(){
		return $this->hasMany('App\Models\Franchise\Femployees_aba_experience_reference', 'admin_employee_id', 'id');
	} 
	
	public function employee_certifications(){
		return $this->hasMany('App\Models\Franchise\Femployees_certifications', 'admin_employee_id', 'id');
	} 
	
	public function employee_login_credentials(){
		return $this->hasMany('App\Models\Franchise\Femployees_login_credentials', 'admin_employee_id', 'id');
	}   
}
