<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Cargohold_folders extends Model
{
     protected $table = 'cargohold_folders';
     protected $primaryKey = 'id';
	 
	 public function cargohold_files(){
		return $this->hasMany('App\Models\Cargohold', 'folder_id', 'id');
	}
}