<?php
namespace App\Models\Franchise;
use Illuminate\Database\Eloquent\Model;

class Client_insurance_policy_authorizations extends Model
{
	protected $primaryKey = 'id';
    protected $guarded = ['_token'];
	protected $table = 'parent_insurance_policy_authorizations';
     
	public function clients_insurance_policy(){
		return $this->hasOne('App\Franchise\Client_insurance_policy', 'client_insurance_id','id');
	}  
}