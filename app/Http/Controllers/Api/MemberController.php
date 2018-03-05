<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Models\Member;

class MemberController extends Controller
{
    public function user(Request $request){
        $token = $request->input('token');

    }
    public function check(Request $request){
		if($user = JWTAuth::toUser($request->input('token'))){
			$result = [
				'result' 	=> 'successful',
				'code'		=> 200,
				'data'		=> $user
			];
		}else{
			$result = [
				'result' 	=> 'error',
				'data'		=> false,
				'code'		=> 204
			];
		}
		return Response()->json($result);
	}
}
