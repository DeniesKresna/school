<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
    //
    public function setReceiveAtAttribute($value){
    	$this->attributes['receive_at'] = date('Y-m-d h:i:s', strtotime($value));
    }
}
