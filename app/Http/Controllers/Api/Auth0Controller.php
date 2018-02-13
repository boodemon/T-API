<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Models\Member;
use Request as Req;

class Auth0Controller extends Controller
{
    public function index()
    {
        //
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->login($request);
    }

    public function login($request){
	public function login(Request $request){				
			$user = $request->input('username');
			$password = $request->input('password');
			$email 	= ['email' => $user, 'password' => $password];
			$username 	= ['username' => $user, 'password' => $password];
			$result = [];
			if($token = JWTAuth::attempt($username) ){
				Member::where('username',$user)->update(['remember_token' => $token ]);
				$data = JWTAuth::toUser($token);
				$result = [
					'result' 	=> 'successful' , 
					'code'		=> 200,
					'auth' 		=> $token,
					'data'		=> $data
				];
			}else{
				$result = [
					'result' => 'error',
					'message' => 'Username or Password fails Please try again'
					];
			}
			return Response()->json($result);
	}
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
