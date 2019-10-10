<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    //
    protected $fillable = ['asset_name','asset_brand','asset_inventory_code','asset_inventory_numb','asset_serial_numb','asset_description','assettype_id','room_id'];

    public function setAssetBrandAttribute($value){
    	$this->attributes['asset_brand'] = strtoupper($value);
    }
}
