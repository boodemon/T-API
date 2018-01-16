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
		public function login(Request $request){
			//echo '<pre>',print_r($request->all()),'</pre>';

				$user = $request->input('username');
				$password = $request->input('password');
				$email 	= ['email' => $user, 'password' => $password];
				$username 	= ['username' => $user, 'password' => $password];
				$result = [];
				if($token = JWTAuth::attempt($username) ){
					
					User::where('username',$user)->update(['remember_token' => $token ]);
					// Auth::guard('web')->user()->token = $request->input('token');
					//echo '<pre>',print_r( $token ),'</pre>';
					$result = [
						'result' => 'successful' , 
						'auth' => $token
					];
				}else{
					$result = ['result' => 'error','message' => 'Username or Password fails Please try again'];
				}
				return Response()->json($result);


		}
		public function signin(Request $request){
			//echo '<pre>',print_r($request->all()),'</pre>';
				$result = [];
				$user = $request->input('username');
				$password = $request->input('password');
				$email 	= ['email' => $user, 'password' => $password];
				$username 	= ['username' => $user, 'password' => $password];
				$log = User::where(function($query)use($user,$password){
					$query->where('username',$user)->
							orWhere('email',$user);
					})->where('password',bcrypt($password))->first();
				if( $log ){
					$log->remember_token = $request->input('token');
					$log->save();
					$result = [
						'result'	=> 'SUCCESS',
						'auth'		=>	$log
					];
				}else{
					$result = ['result' => 'error','message' => 'Username or Password fails Please try again'];
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
						'data'		=> $user
					];
				}else{
					$result = [
						'result' 	=> 'error',
						'data'		=> false
					];
				}
				return Response()->json($result);
		}
}
