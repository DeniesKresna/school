<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Receive;
use App\Conditiontype;
use App\Condition;
use App\Move;

class ReceiveController extends Controller
{
    //
    public function store(Request $request, $asset_id){
    	$receive = new Receive;
        $req = $request->editedItem;
        //return response()->json(['req'=>$req],422);
    	$receive->asset_id = $asset_id;
    	$receive->receive_sender_identity = $req['receive_sender_identity'];
    	$receive->receive_at = $req['receive_at'];
    	$receive->receive_bill_date = $req['receive_bill_date'];
    	$receive->receive_bill_number = $req['receive_bill_number'];
    	$receive->receiver_id = $req['receiver_id'];
    	$receive->receive_created_by = 1;
    	$receive->receive_updated_by = 1;
    	$receive->save();

        $conditiontype = Conditiontype::findOrFail($req['conditiontype_id']);
        $condition =  new Condition;
        $condition->asset_id = $asset_id;
        $condition->condition_description = $conditiontype['conditiontype_name'];
        $condition->conditiontype_id = $conditiontype['id'];
        $condition->condition_at = $req['receive_at'];
        $condition->condition_created_by = 1;
        $condition->condition_updated_by = 1;
        $condition->save();

        $move =  new Move;
        $move->asset_id = $asset_id;
        $move->move_description = "Penerimaan Barang";
        $move->move_at = $req['receive_at'];
        $move->mover_id = $req['receiver_id'];
        $move->room_id = $req['room_id'];
        $move->move_created_by = 1;
        $move->move_updated_by = 1;
        $move->save();

    	return response()->json(['message'=>"Berhasil tambah penerimaan barang"]);
    }

    public function showAsset($asset_id){
        $receive = DB::table('receives as r')->where('asset_id',$id)
                ->join('users as u','u.id','=','r.receiver_id')
                ->join('users as cru','cru.id','=','r.receive_created_by')
                ->join('users as upu','upu.id','=','r.receive_updated_by')
                ->select('r.*','u.name as receiver_name','cru.name as created_by','upu.name as updated_by')
                ->first();
        return response()->json(['message'=>"Berhasil ambil penerimaan barang",'receive'=>$receive]);
    }
}
