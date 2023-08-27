<?php
namespace App\Models\Franchise;
use Illuminate\Database\Eloquent\Model;

class Femployees_emergency_contacts extends Model
{
     protected $table = 'femployees_emergency_contacts';
     protected $primaryKey = 'id';
     
	public function employees(){
		return $this->hasMany('App\Franchise\Femployee', 'admin_id','id');
	}     
}