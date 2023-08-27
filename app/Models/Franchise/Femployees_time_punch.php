<?php
namespace App\Models\Franchise;
use Illuminate\Database\Eloquent\Model;

class Femployees_time_punch extends Model
{
	protected $table = 'femployees_time_punch';
	protected $primaryKey = 'id';
	
	public function employees(){
		return $this->hasMany('App\Franchise\Femployee', 'admin_id','id');
	}        
}