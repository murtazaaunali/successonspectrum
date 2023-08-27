<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Admins_employees_schedules extends Model
{
	protected $table = 'admins_employees_schedules';
	protected $primaryKey = 'id';
    protected $guarded = ['_token'];
     
	public function admin_employee(){
		return $this->hasOne('App\Models\Admin', 'admin_employee_id','id');
	}   
}