<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	public function assettype(){
		return $this->hasMany('App\Assettype');
	}
}
