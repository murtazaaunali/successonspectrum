<?php
namespace App\Models\Franchise;
use Illuminate\Database\Eloquent\Model;

class Client_schedules extends Model
{
	protected $table = 'parent_schedules';
	protected $primaryKey = 'id';
    protected $guarded = ['_token'];
     
	public function clients(){
		return $this->hasOne('App\Franchise\Client', 'client_id','id');
	}   
}