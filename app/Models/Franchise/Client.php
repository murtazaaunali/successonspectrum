<?php

namespace App\Models\Franchise;

use App\Notifications\FranchiseResetPassword;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $primaryKey = 'id';
    protected $table = 'admission_form';
	
	public function franchise_owners(){
		return $this->hasMany('App\Models\Franchise_owners', 'franchise_id', 'id');
	}

	public function franchise_fees(){
		return $this->hasOne('App\Models\Franchise_fees', 'franchise_id', 'id');
	}	

	public function payments(){
		return $this->hasMany('App\Models\Franchise_payments', 'franchise_id', 'id');
	}
	
	public function admin(){
		return $this->hasOne('App\Models\Admin', 'created_by', 'id');
	}  	

	public function getState(){
		return $this->hasOne('App\Models\State', 'id', 'state');
	}  	

	public function tasklist(){
		return $this->hasMany('App\Models\Franchise\Client_tasklist', 'client_id', 'id');
	}
	
	public function documents(){
		return $this->hasMany('App\Models\Franchise\Client_documents', 'client_id', 'id');
	}
	
	public function doc(){
		return $this->hasOne('App\Models\Franchise\Client_documents', 'client_id', 'id');
	}
	
	public function schedules(){
		return $this->hasMany('App\Models\Franchise\Client_schedules', 'client_id', 'id');
	}
	
	public function insurance_policies(){
		return $this->hasMany('App\Models\Franchise\Client_insurance_policy', 'client_id', 'id');
	}

	public function ClientCrew(){
		return $this->hasOne('App\Models\Frontend\Employmentform', 'id', 'client_crew');
	}

}
