<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Notifications_to_franchise extends Model
{
	protected $table = 'notifications_to_franchise';
	protected $primaryKey = 'id';

    public function notificaiton_franchise(){
        return $this->hasOne('App\Models\Franchise', 'id', 'franchise_id');
    }
}