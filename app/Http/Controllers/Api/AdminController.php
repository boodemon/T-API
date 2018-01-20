<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\userUpdateRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $rows = User::orderBy('name')->get();
      if( $rows ){
          $result = [
              'code'    => 200,
              'result'  => 'successful',
              'data'    => $rows
          ];
      }else{ 
          $result = [
              'code'    => 204,
              'result'  => 'error',
              'data'    => false,
          ]
      }
      return Response()->json($rows);  //
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
    public function store(UserRequest $request)
    {        
        $user 			= new User;
        $user->username = $request->input('username');
        $user->email    = $request->input('email');
        $user->password = bcrypt( $request->input('password') );
        $user->name 	= $request->input('name');
        $user->tel 	    = $request->input('tel');
        $user->active   = $request->input('active') != '' ? 'Y' : 'N';
        if( $user->save()){
            $result = [
                'result' => 'successful',
                'data'   => $user,
                'code'  =>  200,
            ];
        }else{
            $result = [
                'result'    => 'error',
                'msg'       =>  'Cannot save user please try again',
                'code'      =>  204
            ];
        }

        return Response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = User::where('id',$id)->first();
        if( $row ){
            $result = [
                'result' => 'successful',
                'data'  =>  $row,
                'code'      => 200
            ];
        }else{
            $result = [
                'result' => 'error',
                'msg'    => 'User not found!',
                'code'  =>  204
            ];
        }
        return Response()->json($result);
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
    public function update(userUpdateRequest $request, $id)
    {
            $user 		    = User::where('id',$id)->first();
            if( $user ){
                $user->name 	= $request->input('name');
                $user->tel 	    = $request->input('tel');
                $user->active   = $request->input('active') != '' ? 'Y' : 'N';
        
                if($request->input('password') != ''){
                    $user->password = bcrypt($request->input('password'));
                }

                $username 	= $user->username;
                $email	 	= $user->email;
                
                if($request->input('email') != $email){
                    $c = User::where('email',$request->input('email'))->first();
                    if(!$c){
                        $user->email = $request->input('email');
                    }else{
                        $result = [
                            'result'        => 'error',
                            'username'      => 'Error!! Email นี้ถูกใช้ไปก่อนหน้านี้แล้ว โปรดใช้ Email อื่น',
                            'code'          => 204
                        ];
                        return Response()->json($result);
                    }
                }
                
                if($request->input('username') != $username){
                    $c = User::where('username',$request->input('username'))->first();
                    if(!$c){
                        $user->username = $request->input('username');
                    }else{
                        $result = [
                            'result'    => 'error',
                            'username'  => 'Error!! Username นี้ถูกใช้ไปก่อนหน้านี้แล้ว โปรดใช้ Username อื่น',
                            'code'      => 204
                        ];
                        return Response()->json($result);
                    }
                }
                if( $user->save() ){
                    $result = [
                        'result'    => 'successful',
                        'data'      => $user,
                        'code'      => 204,
                    ];
                }
            }else{
                $result = [
                    'result'    => 'error',
                    'msg'       => 'Error!! This user account not found. Please try again',
                    'code'      => 204
                ];
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count = User::count();
        if( $id == 1 || $count == 1){
            $result = [
                'result'    => 'error',
                'msg'       => 'ไม่สามารถทำการลบได้ เนื่องจาก User นี้เป็น User หลักหรือท่านเหลือเพียง 1 User',
                'code'      =>  204
            ];
        }else{
            if( User::where('id',$id)->delete() ){
                $result = [
                    'result'    => 'successful',
                    'code'      => 200
                ];
            }else{
                $result = [
                    'result'    => 'error',
                    'msg'       => 'เกิดข้อผิดพลาดจากระบบไม่สามารถทำการลบข้อมูลได้ โปรดลองใหม่ภายหลัง',
                    'code'      => 204
                ];
    
            }
        }
        return Response()->json($result);
    }
}
