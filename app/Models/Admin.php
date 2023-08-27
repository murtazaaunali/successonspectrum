<?php

namespace App\Models;

use App\Notifications\AdminResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }
	public function franchise(){
		return $this->hasMany('App\Franchise', 'created_by', 'id');
	}    

	public function designation(){
		return $this->hasOne('App\Admin_designation', 'designation_id', 'id');
	}   
	
	public function product_categories(){
		return $this->hasMany('App\Product_categories', 'created_by', 'id');
	} 	
	

	//Type Employee Functions
	public function employee_emergency_contact(){
		return $this->hasMany('App\Models\Admins_employees_emergency_contacts', 'admin_employee_id' ,'id');
	}     

	public function employees_time_punch(){
		return $this->hasMany('App\Models\Admin_employees_time_punch', 'admin_employee_id','id');
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
	
	public function performance_logs_planned_time_off(){
		return $this->hasMany('App\Models\Admin_employees_performance_log', 'admin_employee_id','id')->where("event","Planned Time Off");
	} 
	
	public function performance_logs_unplanned_call_in(){
		return $this->hasMany('App\Models\Admin_employees_performance_log', 'admin_employee_id','id')->where("event","Unplanned Call In");
	}
	
	public function performance_logs_current_year_unplanned_call_in($Employee){
		//$current_date		   = "2023-01-01";
		$current_date			= date("Y-m-d");		
		$employee_hiring_year_start   = $Employee->hiring_date;
		$employee_hiring_year_end	= date("Y/m/d",strtotime($employee_hiring_year_start . " + 12 months"));

		while( strtotime($employee_hiring_year_end) < strtotime($current_date) )
		{
			$employee_hiring_year_start = $employee_hiring_year_end;
			$employee_hiring_year_end	= date("Y/m/d",strtotime($employee_hiring_year_end . " + 12 months"));
		}
		return $this->hasMany('App\Models\Admin_employees_performance_log', 'admin_employee_id','id')->where("event","Unplanned Call In")->whereBetween('date', [$employee_hiring_year_start, $employee_hiring_year_end]);
	} 	
}
