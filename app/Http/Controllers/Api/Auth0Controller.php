<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Request as Req;

class Auth0Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->login($request);
    }

    public function login($request){
        $user = $request->input('username');
        $password = $request->input('password');
        $email 	= ['email' => $user, 'password' => $password];
        $username 	= ['username' => $user, 'password' => $password];
        if( Auth::guard('web')->attempt($email) || Auth::guard('web')->attempt($username) ){
            User::where('id',Auth::guard('web')->user()->id)->update(['remember_token' => $request->input('token')]);
            Auth::guard('web')->user()->token = $request->input('token');
            return Response()->json( Auth::guard('web')->user() );
        }else{
            return Response()->json( ['response' => 'error','message' => 'Username or Password fails Please try again']);
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
