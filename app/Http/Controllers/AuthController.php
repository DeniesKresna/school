<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
	    if (Auth::attempt(['code' => $request->code, 'password' => $request->password])){
	        //return redirect()->route('home');
	        return response()->json(['message'=>"Berhasil Login",'user'=>Auth::user()]);
	    }
	    else
	    	return response()->json(['message'=>"Nomor Induk atau Password salah"],404);
	}

	public function logout(Request $request)
	{
	    if(Auth::check())
	    {
	        Auth::logout();
	        $request->session()->invalidate();
	    }
	    return response()->json(['message'=>"Berhasil Logout"]);
	}

	public function userSession(){
		return response()->json(['user'=>Auth::user()]);
	}

	public function userSessionUpdate(Request $request){
		$user = Auth::user();
		$rq = $request->all();
		$validator = Validator::make($rq['userdata'], $user->updateRules);
		if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()],422);
        }
        $user->fill($rq['userdata']);
        $user->save();
		return response()->json(['message'=>'sukses update user']);
	}

	public function userPasswordUpdate(Request $request){
		$user = Auth::user();
		$rq = $request->all();
		$validator = Validator::make($rq['userpassword'], $user->updatePasswordRules);
		if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()],422);
        }
        if (Hash::check($rq['userpassword']['oldpassword'],$user->password)) {
        	$user->password = bcrypt($rq['userpassword']['newpassword1']);
	        $user->save();
			return response()->json(['message'=>'sukses update password']);   
		}
		return response()->json(['error'=>"Password Lama Salah"],403);             
	}
}
