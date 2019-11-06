<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport;
use Illuminate\Support\Facades\DB;
use App\Asset;

use Illuminate\Http\Request;

class AssetController extends Controller
{
    //
    public function import(Request $request){
    	$datanya = Excel::toArray(new ExcelImport, $request->file('file'));
    	$data = $datanya[0];
        if($data[0][1] == "merk"){
        	for($i=1; $i<count($data); $i++){

        		for($j=0; $j<9; $j++){
        			$fact_row = $i+1;
        			$fact_col = $j+1;
        			if(!$data[$i][$j]) return response()->json(['message'=>'Data sebelum baris ke '.$fact_row.' berhasil dimasukkan. Data pada baris '.$fact_row.' dan kolom '. $fact_col. ' ke atas bermasalah. Silakan import ulang mulai baris '.$fact_row.'.'],422);
        		}

        		//check group
        		$group = DB::table('groups')->where('group_name',strtoupper(trim($data[$i][2])))->first();
        		if(!$group){
        			$group_id = DB::table('groups')->insertGetId([
        				'group_name'=>strtoupper(trim($data[$i][2])),
        				'group_created_by'=>1,
        				'group_updated_by'=>1,	
        				'created_at'=>date('Y-m-d H:i:s'),
        				'updated_at'=>date('Y-m-d H:i:s'),			
        			]);
        		}
        		else
        			$group_id = $group->id;

        		//check asset type
        		$assettype = DB::table('assettypes')->where('assettype_name',strtoupper(trim($data[$i][3])))->first();
        		if(!$assettype){
        			$assettype_id = DB::table('assettypes')->insertGetId([
        				'assettype_name'=>strtoupper(trim($data[$i][3])),
        				'assettype_unit'=>trim($data[$i][4]),
        				'group_id'=>$group_id,
        				'assettype_created_by'=>1,
        				'assettype_updated_by'=>1,
        				'created_at'=>date('Y-m-d H:i:s'),
        				'updated_at'=>date('Y-m-d H:i:s'),		
        			]);
        		}
        		else
        			$assettype_id = $assettype->id;

        		//check room
        		$room = DB::table('rooms')->where('room_name',strtoupper(trim($data[$i][5])))->first();
        		if(!$room){
        			$room_id = DB::table('rooms')->insertGetId([
        				'room_name'=>strtoupper(trim($data[$i][5])),
        				'room_created_by'=>1,
        				'room_updated_by'=>1,
        				'created_at'=>date('Y-m-d H:i:s'),
        				'updated_at'=>date('Y-m-d H:i:s'),		
        			]);
        		}
        		else
        			$room_id = $room->id;

        		//olah asset
        		$asset = Asset::where('asset_serial_numb',$data[$i][8])->first();
        		if(!$asset)
        			$asset = new Asset;

        		$asset->asset_name = $data[$i][0];
        		if($data[$i][1]) $asset->asset_brand = strtoupper(trim($data[$i][1]));
        		$asset->room_id = $room_id;
        		if($data[$i][6]) $asset->asset_inventory_code = $data[$i][6];
        		if($data[$i][7]) $asset->asset_inventory_numb = $data[$i][7];
                if($data[$i][8]) $asset->asset_serial_numb = $data[$i][8];
        		if($data[$i][9]) $asset->asset_description = $data[$i][9];
        		$asset->assettype_id = $assettype_id;
                $asset->asset_created_by = 1;
                $asset->asset_updated_by = 1;
        		$asset->save();
        	}
            return response()->json(['message'=>'Berhasil Import Data']);
        }
        else
        {
            return response()->json(['message'=>'Sepertinya file anda tidak sesuai format yang berlaku'],422);
        }
    }    

    public function filter(Request $request){
        $assets = DB::table('assets as a')
                ->join('assettypes as at','at.id','=','a.assettype_id')
                ->join('groups as g','g.id','=','at.group_id')
                ->join('rooms as r','r.id','=','a.room_id')
                ->where('assettype_id',$request->assettype_id)
                ->select('a.id','a.asset_name','a.asset_brand','g.group_name','at.group_id as group_id','a.assettype_id as assettype_id','at.assettype_name','at.assettype_unit','a.asset_description',
                    'r.room_name','a.room_id','a.asset_inventory_code','a.asset_inventory_numb','a.asset_serial_numb')
                ->orderBy('a.created_at','desc')->orderBy('a.asset_inventory_code')->orderBy('a.asset_inventory_numb')->get();
        return response()->json(['assets'=>$assets]);
    }

    public function updateAll(Request $request, $id){
        $asset = Asset::findOrFail($id);
        $asset->fill($request->editedItem["asset"]);
        $asset->asset_updated_by = 1;
        $asset->save();
        return response()->json(['message'=>"Berhasil update asset"]);
    }

    public function store(Request $request){
        $cekasset = DB::table('assets')->where('asset_serial_numb',$request->editedItem['asset_serial_numb'])->first();
        if($cekasset){
            return response()->json(['message'=>"Maaf tapi asset dengan SN tersebut sudah ada, yaitu " . $cekasset->asset_name],422);
        }
        $asset = new Asset;
        $asset->fill($request->editedItem);
        $asset->asset_updated_by = 1;
        $asset->asset_created_by = 1;
        $asset->save();
        return response()->json(['message'=>"Berhasil tambah asset", 'asset_id'=>$asset->id]);
    }

    public function delete($id){
        $asset = Asset::findOrFail($id);
        $asset->delete();
        return response()->json(['message'=>"Berhasil hapus asset"]);
    }

    public function detail($id){
        $asset_detail = [];
        $asset = DB::table('assets as a')->join('assettypes as at','at.id','=','a.assettype_id')
                ->join('groups as g','g.id','=','at.group_id')->join('rooms as r','r.id','=','a.room_id')
                ->join('users as cru','cru.id','=','a.asset_created_by')
                ->join('users as upu','upu.id','=','a.asset_updated_by')
                ->select('a.*','at.assettype_name','at.assettype_unit','g.group_name','at.group_id','r.room_name','r.room_alias','cru.name as created_by','upu.name as updated_by')->where('a.id',$id)->first();
        $receive = DB::table('receives as r')->where('r.asset_id',$id)
                ->join('users as u','u.id','=','r.receiver_id')
                ->join('users as cru','cru.id','=','r.receive_created_by')
                ->join('users as upu','upu.id','=','r.receive_updated_by')
                ->select('r.*','u.name as receiver_name','cru.name as created_by','upu.name as updated_by')->first();
        $conditions = DB::table('conditions as c')
                ->join('conditiontypes as ct','ct.id','=','c.conditiontype_id')
                ->join('users as cru','cru.id','=','c.condition_created_by')
                ->join('users as upu','upu.id','=','c.condition_updated_by')
                ->select('c.*','cru.name as created_by','upu.name as updated_by','ct.conditiontype_name')
                ->where('asset_id',$id)->get();
        $moves = DB::table('moves as m')->join('users as u','u.id','=','m.mover_id')
                ->join('users as cru','cru.id','=','m.move_created_by')
                ->join('users as upu','upu.id','=','m.move_updated_by')
                ->join('rooms as r','r.id','=','m.room_id')
                ->join('users as mvr','mvr.id','=','m.mover_id')
                ->select('m.*','cru.name as created_by','mvr.name as mover_name','r.room_name','upu.name as updated_by')
                ->where('asset_id',$id)->orderBy('m.move_at','desc')->get();
        $asset_detail = [
            'asset'=>$asset,
            'receive'=>$receive,
            'conditions'=>$conditions,
            'moves'=>$moves
        ];
        return response()->json(['message'=>"Berhasil ambil detail aset", 'asset_detail'=>$asset_detail]);
    }
}