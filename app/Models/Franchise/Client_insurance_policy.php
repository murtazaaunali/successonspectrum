<?php
namespace App\Models\Franchise;
use Illuminate\Database\Eloquent\Model;

class Client_insurance_policy extends Model
{
	protected $primaryKey = 'id';
    protected $guarded = ['_token'];
	protected $table = 'parent_insurance_policy';
     
	public function clients(){
		return $this->hasOne('App\Franchise\Client', 'id','client_id');
	}
	
	public function clients_insurance_policy_idcards(){
		return $this->hasMany('App\Franchise\Client_insurance_policy_idcards', 'client_insurance_id','id');
	}
	
	public function clients_insurance_policy_authorizations(){
		return $this->hasMany('App\Franchise\Client_insurance_policy_authorizations', 'client_insurance_id','id');
	}   
}