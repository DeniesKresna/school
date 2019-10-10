<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Move;
use App\Asset;

class MoveController extends Controller
{
    //
    public function store(Request $request){
        $req = $request->editedItem;
    	$asset = Asset::findOrFail($req['id']);
    	if(!$asset)
    		return response()->json(['message'=>'Tidak ditemukan asset dengan serial number tersebut'], 422);

    	$asset->room_id = $req['room_id'];
    	$asset->save();

    	$move = new Move;
    	$move->asset_id = $req['id'];
    	$move->move_description = $req['move_description'];
    	$move->move_date = $req['move_date'];
    	$move->room_id = $req['room_id'];
    	$move->mover_id = $req['mover_id'];
    	$move->move_created_by = 1;
    	$move->move_updated_by = 1;
    	$move->save();
    	return response()->json(['message'=>'Berhasil pindah data asset']);
    }

    public function show($asset_id){
    	$moves = DB::table('moves as m')->join('assets as a','a.id','=','m.asset_id')
    			->join('users as u','u.id','=','m.mover_id')
    			->join('rooms as r','r.id','=','m.room_id')
    			->where('m.asset_id',$asset_id)->orderBy('m.move_date')
    			->select('m.*','u.name','r.room_name')->get();
    	return response()->json(['message'=>"Berhasil ambil history perpindahan barang",'moves'=>$moves]);
    }
}
