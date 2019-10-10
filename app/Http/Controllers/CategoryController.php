<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Category;

class CategoryController extends Controller
{
	public function indexAutocomplete($group_id){
		$categories = DB::table('categories')->select('category_name as text','category_id as value')->where('group_id',$group_id)->orderBy('category_name')->get();
		return response()->json(['categories'=>$categories]);
	}
}
