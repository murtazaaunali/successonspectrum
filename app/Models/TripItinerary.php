<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TripItinerary extends Model
{
     protected $table = 'franchises_events';
     protected $primaryKey = 'id';
     
	public function franchise(){
		return $this->hasOne('App\Franchise', 'franchise_id', 'id');
	}     
}