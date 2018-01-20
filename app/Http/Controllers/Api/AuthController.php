<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\User;
use Request as Req;

class AuthController extends Controller
{
    //
		public function login(Request $request){				$user = $request->input('username');
				$password = $request->input('password');
				$email 	= ['email' => $user, 'password' => $password];
				$username 	= ['username' => $user, 'password' => $password];
				$result = [];
				if($token = JWTAuth::attempt($username) ){
					
					User::where('username',$user)->update(['remember_token' => $token ]);
					$user = JWTAuth::toUser($token);
					$result = [
						'result' 	=> 'successful' , 
						'code'		=> 200,
						'auth' 		=> $token,
						'user'		=> $user
					];
				}else{
					$result = [
						'result' => 'error',
						'message' => 'Username or Password fails Please try again'
						];
				}
				return Response()->json($result);


		}

		public function token(){
			return Response()->json(['_token'=>csrf_token()]);
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
