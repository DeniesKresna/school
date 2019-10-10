<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //
    public function autocomplete(){
    	$users = DB::table('users')->select('id as value','name as text')->orderBy('name')->get();
    	return response()->json(['users'=>$users]);
    }
}
