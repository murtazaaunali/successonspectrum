<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'settings';
	
	public function get_state_by_code($code){
		return State::where('code', $code)->first();
	}  
}