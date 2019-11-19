<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Move;
use App\Asset;

class MoveController extends Controller
{
    //
    public function store(Request $request, $asset_id){
        $req = $request->editedItem;
    	$asset = Asset::findOrFail($asset_id);
    	if(!$asset)
    		return response()->json(['message'=>'Tidak ditemukan asset dengan serial number tersebut'], 422);

    	$asset->room_id = $req['room_id'];
    	$asset->save();

    	$move = new Move;
    	$move->asset_id = $asset_id;
    	$move->move_description = $req['move_description'];
    	$move->move_at = $req['move_at'];
    	$move->room_id = $req['room_id'];
    	$move->mover_id = $req['mover_id'];
    	$move->move_created_by = 1;
    	$move->move_updated_by = 1;
    	$move->save();
    	return response()->json(['message'=>'Berhasil pindah data asset']);
    }

    public function show($asset_id){
    	$moves = DB::table('moves as m')->join('users as u','u.id','=','m.mover_id')
                ->join('users as cru','cru.id','=','m.move_created_by')
                ->join('users as upu','upu.id','=','m.move_updated_by')
                ->join('rooms as r','r.id','=','m.room_id')
                ->join('users as mvr','mvr.id','=','m.mover_id')
                ->select('m.*','cru.name as created_by','mvr.name as mover_name','r.room_name','upu.name as updated_by')
                ->where('asset_id',$asset_id)->orderBy('m.move_at','desc')
                ->get();
        return response()->json(['message'=>"Berhasil ambil history perpindahan", 'moves'=>$moves]);
    }
}
