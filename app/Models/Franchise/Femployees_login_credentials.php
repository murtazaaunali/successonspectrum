<?php
namespace App\Models\Franchise;
use Illuminate\Database\Eloquent\Model;

class Femployees_login_credentials extends Model
{
    protected $table = 'femployees_login_credentials';
    protected $primaryKey = 'id';
     
	public function employees(){
		return $this->hasMany('App\Franchise\Femployee', 'admin_id','id');
	}     
}