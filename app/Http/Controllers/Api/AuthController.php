<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
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
				if( Auth::guard('web')->attempt($email) || Auth::guard('web')->attempt($username) ){
					User::where('id',Auth::guard('web')->user()->id)->update(['remember_token' => $request->input('token')]);
					Auth::guard('web')->user()->token = $request->input('token');
					$result = [
						'result' => 'success' , 
						'auth' => Auth::guard('web')->user() 
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
				//echo '<pre>',print_r($request->all()),'</pre>';
				$row = User::where('username',$request->input('username') )
									 ->where('remember_token', $request->input('token') )
									 ->first();
				$result = $row ? 'true':'false';
				return Response()->json(['result' => $result ]);
		}
}
