<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\User;
use Auth;


class MemberController extends Controller
{
	public function __construct(Request $request){
		$this->token = $request->input( 'token ' );
	}

	public function changPassword(Request $request){
		$user = User::toUser( $request->input('token') );
		$password = $request->input('password');
		$row = User::where('id', $user->id)->first();
		$row->password = bcrypt($password);
		$row->save();
		$username 	= ['username' => $user->username, 'password' => $password];
		if( Auth::guard('api')->attempt($username) ){
                $token = json_encode( Auth::guard('api')->user() );
				$result = [
					'result' 	=> 'successful' , 
					'code'		=> 200,
					'auth' 		=> base64_encode( $token ),
                    'data'		=> Auth::guard('api')->user(),
                    'msg'       => 'Login from Username'
				];
			}else{
				$result = [
					'result' => 'error',
					'message' => 'Username/Password false Please try again '
					];
			}
			return Response()->json($result);
	}

    public function user(Request $request){
		return User::toUser( $request->input('token') );
	}
	
    public function check(Request $request){
		//echo 'this token = '. $this->token ;
		$user = User::toUser(  $request->input('token') );
		//echo '<pre>',print_r( $user ),'</pre>';
		if( $user ){
			
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
