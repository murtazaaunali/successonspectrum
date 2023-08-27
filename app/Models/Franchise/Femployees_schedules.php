<?php
namespace App\Models\Franchise;
use Illuminate\Database\Eloquent\Model;

class Femployees_schedules extends Model
{
	protected $table = 'femployees_schedules';
	protected $primaryKey = 'id';
    protected $guarded = ['_token'];
     
	public function admin_employee(){
		return $this->hasOne('App\Models\Admin', 'admin_employee_id','id');
	}   
}