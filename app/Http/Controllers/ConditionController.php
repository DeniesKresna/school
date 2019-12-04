<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Condition;
use App\Asset;

class ConditionController extends Controller
{
    public function store(Request $request, $asset_id){
        $req = $request->editedItem;
    	$asset = Asset::findOrFail($asset_id);
    	$asset->save();

    	$condition = new Condition;
    	$condition->asset_id = $asset_id;
    	$condition->condition_description = $req['condition_description'];
    	$condition->conditiontype_id = $req['conditiontype_id'];
    	$condition->condition_created_by = 1;
    	$condition->condition_updated_by = 1;
    	$condition->save();
    	return response()->json(['message'=>'Berhasil menambahkan kondisi asset']);
    }

    public function showAsset($asset_id){
    	$condition = DB::table('conditions as c')
                ->join('users as cru','cru.id','=','c.condition_created_by')
                ->join('users as upu','upu.id','=','c.condition_updated_by')
                ->join('conditiontypes as ct','ct.id','=','c.conditiontype_id')
                ->select('c.*','cru.name as created_by','ct.conditiontype_name','upu.name as updated_by')
                ->where('asset_id',$asset_id)->orderBy('m.condition_at','desc')
                ->get();
        return response()->json(['message'=>"Berhasil ambil history perpindahan", 'conditions'=>$conditions]);
    }

    public function delete($id){
        $condition = Condition::findOrFail($id)->first();
        $condition->delete();
        return response()->json(['message'=>"Berhasil hapus kondisi asset"]);
    }

    public function update(Request $request, $asset_id, $id){
        $req = $request->editedItem;
        $asset = Asset::findOrFail($asset_id);
        $asset->save();

        $condition = Move::findOrFail($id);
        $condition->asset_id = $asset_id;
        $condition->condition_description = $req['condition_description'];
        $condition->conditiontype_id = $req['conditiontype_id'];
        $condition->condition_created_by = 1;
        $condition->condition_updated_by = 1;
        $condition->save();
        return response()->json(['message'=>'Berhasil edit kondisi data asset']);
    }
}
