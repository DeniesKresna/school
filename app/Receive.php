<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
    //
    protected $fillable = ['asset_id','receive_at','receive_sender_identity','receive_bill_date','receive_bill_number','receiver_id'];

    //
    public function setReceiveAtAttribute($value){
    	$this->attributes['receive_at'] = date('Y-m-d h:i:s', strtotime($value));
    }
}
