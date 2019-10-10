<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Condition;

class ConditiontypeController extends Controller
{
	public function autocomplete(){
		$conditiontypes = DB::table('conditiontypes')->select('id as value','conditiontype_name as text')->orderBy('conditiontype_name')->get();
		return response()->json(['conditiontypes'=>$conditiontypes]);
	}
}