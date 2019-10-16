<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    //
    public function setMoveAtAttribute($value){
    	$this->attributes['move_at'] = date('Y-m-d h:i:s', strtotime($value));
    }
}
