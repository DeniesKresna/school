<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    //
    public function setConditionAtAttribute($value){
    	$this->attributes['condition_at'] = date('Y-m-d h:i:s', strtotime($value));
    }
}
