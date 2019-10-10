<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Group;

class GroupController extends Controller
{
	public function assettypeAutocomplete(){
		$autocompletes = DB::table('groups')->select('group_name as text','id as value')->orderBy('group_name')->get();
	   	
	   	foreach ($autocompletes as $autocomplete) {
	   		$autocomplete->children = DB::table('assettypes')->select('assettype_name as text','id as value')->where('group_id',$autocomplete->value)->orderBy('assettype_name')->get();
	   	}
	   	return response()->json(['autocompletes' => $autocompletes]);
	}
}