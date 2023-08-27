<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Cargohold extends Model
{
     protected $table = 'cargohold';
     protected $primaryKey = 'id';
	 
	 public function cargohold_folder(){
		return $this->hasOne('App\Models\Cargohold_folders', 'folder_id', 'id');
	}
}