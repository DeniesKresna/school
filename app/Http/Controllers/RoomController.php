<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Room;

class RoomController extends Controller
{
    //
    public function autocomplete(){
    	$rooms = DB::table('rooms')->select('id as value','room_name as text', 'room_alias as alias')->orderBy('room_name')->get();
    	return response()->json(['rooms'=>$rooms]);
    }
}
