<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conditiontype extends Model
{
    public function setAssetBrandAttribute($value){
    	$this->attributes['asset_brand'] = strtoupper($value);
    }
}
