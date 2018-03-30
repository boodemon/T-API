<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Request as Req;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\User;


class MemberController extends Controller
{
	public function __construct(Request $request){
		$this->token = $request->input( 'token ' );
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
