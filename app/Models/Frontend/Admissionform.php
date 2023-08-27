<?php

/*namespace App\Models\Frontend;
use Illuminate\Database\Eloquent\Model;
 class Admissionform extends Model
{
     protected $table = 'admission_form';
     protected $primaryKey = 'id';
     
}*/ 

namespace App\Models\Frontend;

use App\Notifications\ParentResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admissionform extends Authenticatable
{
    use Notifiable;
	
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admission_form';
	protected $primaryKey = 'id';
 
    protected $fillable = [
        'name', 'email', 'password',
    ];
	
	//protected $table = 'admission_form';

    protected $hidden = [
        'password', 'remember_token',
    ];


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ParentResetPassword($token));
    }
}