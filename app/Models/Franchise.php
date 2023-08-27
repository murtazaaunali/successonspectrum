<?php

namespace App\Models;

use App\Notifications\FranchiseResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Franchise extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new FranchiseResetPassword($token));
    }
    
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
		return $this->hasMany('App\Models\Franchise_tasklist', 'franchise_id', 'id');
	}
	
	public function franchise_audit(){
		return $this->hasMany('App\Models\Franchise_audit', 'franchise_id', 'id');
	}
	
	public function franchise_insurance(){
		return $this->hasMany('App\Models\Franchise_insurance', 'franchise_id', 'id');
	}
	
	public function franchise_local_advertisements(){
		return $this->hasMany('App\Models\Franchise_local_advertisements', 'franchise_id', 'id');
	}
	
	public function add_franchise_local_advertisements($franchise_id,$year){
		$required_local_advertisements_data = [
			['franchise_id'=>$franchise_id, 'quarter'=> 1, 'year'=> $year],
			['franchise_id'=>$franchise_id, 'quarter'=> 2, 'year'=> $year],
			['franchise_id'=>$franchise_id, 'quarter'=> 3, 'year'=> $year],
			['franchise_id'=>$franchise_id, 'quarter'=> 4, 'year'=> $year]
		];
		'App\Models\Franchise_local_advertisements'::insert($required_local_advertisements_data);
	}
	
	public function check_franchise_local_advertisements($franchise_id,$year){
		return 'App\Models\Franchise_local_advertisements'::where('franchise_id',$franchise_id)->where('year',$year)->get()->isEmpty();
	}
	
	public function franchise_incomplete_tasklists(){
		return $this->hasMany('App\Models\Franchise_tasklist', 'franchise_id','id')->where("status","Incomplete");
	} 
}
