<?php
namespace App\Models\Franchise;
use Illuminate\Database\Eloquent\Model;

class Femployees_certifications extends Model
{
    protected $table = 'femployees_certifications';
    protected $primaryKey = 'id';
     
	public function employees(){
		return $this->hasMany('App\Franchise\Femployee', 'admin_id','id');
	}     
}