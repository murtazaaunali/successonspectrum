<?php

/*namespace App\Models\Frontend;
use Illuminate\Database\Eloquent\Model;
class Employmentform extends Model
{
     protected $table = 'employment_form';
     protected $primaryKey = 'id';
     
}*/

namespace App\Models\Frontend;

use App\Notifications\FemployeeResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class Employmentform extends Authenticatable
{
    use Notifiable;
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $primaryKey = 'id';
    protected $table = 'employment_form';

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
        $this->notify(new FemployeeResetPassword($token));
    }
	
	public function getEmailForPasswordReset()
    {
        return $this->personal_email;
    }

    public function routeNotificationFor($driver)
    {
        if (method_exists($this, $method = 'routeNotificationFor'.Str::studly($driver))) {
            return $this->{$method}();
        }

        switch ($driver) {
            case 'database':
                return $this->notifications();
            case 'mail':
                return $this->personal_email;
            case 'nexmo':
                return $this->personal_phone;
        }
    }
}