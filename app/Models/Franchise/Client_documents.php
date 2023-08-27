<?php

namespace App\Models\Franchise;

use App\Notifications\FranchiseResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client_documents extends Authenticatable
{
    use Notifiable;
	
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
	protected $table = 'admission_form_documents';

    public function clients(){
		return $this->hasMany('App\Franchise\Client', 'client_id','id');
	} 
}
