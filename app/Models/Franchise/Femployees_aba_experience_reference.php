<?php
namespace App\Models\Franchise;
use Illuminate\Database\Eloquent\Model;

class Femployees_aba_experience_reference extends Model
{
    protected $table = 'femployees_aba_experience_reference';
    protected $primaryKey = 'id';
     
	public function employees(){
		return $this->hasMany('App\Franchise\Femployee', 'admin_id','id');
	}     
}