<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Assettype;

class AssettypeController extends Controller
{
	public function indexAutocomplete($group_id){
		$categories = DB::table('assettypes')->select('assettype_name as text','id as value')->where('group_id',$group_id)->get();
		return response()->json(['categories'=>$categories]);
	}
}
