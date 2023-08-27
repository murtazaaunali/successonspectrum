<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Franchises_trip_itenary extends Model
{
	protected $table = 'franchises_trip_itenary';
	protected $primaryKey = 'id';
     
	public function franchise(){
		return $this->hasOne('App\Franchise', 'franchise_id','id');
	}     
}