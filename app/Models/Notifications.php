<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
	protected $table = 'notifications';
	protected $primaryKey = 'id';

    public function franchises(){
        return $this->hasMany('App\Models\Notifications_to_franchise', 'notification_id', 'id');
    }
}