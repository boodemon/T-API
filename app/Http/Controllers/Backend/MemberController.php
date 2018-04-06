<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class MemberController extends Controller
{
    public function index()
    {
        $rows = User::where('active','!=','D')
                    ->where('user_type','member')
                    ->orderBy('name')->paginate(24);
        $data = [
            'rows' => $rows,
            '_breadcrumb' => 'Administrator',

        ];
        return view('backend.member.index',$data);
    }

        public function edit($id)
    {
        $user = User::where('id',$id)->first();
        if( $user){
		$data = [
			'data'  => $user,
            'id'    => $id,
            'code'  => 200
            ];
        }else{
            $data = [
                'code' => 202,
                'data' => false
            ];
        }
        return response()->json($data);
    }
        public function store(Request $request)
    {
			$id 			= $request->input('id');
			$user 			= new User;
			$user->name 	= $request->input('name');
			$user->tel 		= $request->input('tel');
			$user->active 	= $request->has('active') ? 'Y' : 'N';

			if($request->input('password') != ''){
				$user->password = bcrypt($request->input('password'));
			}

			$ec = User::where('email',$request->input('email'))->first();
			if(!$ec){
				$user->email = $request->input('email');
			}else{
				return redirect()->back()->withErrors(['email' => 'Error! E-mail is already in use Please try again']);
			}

			$uc = User::where('username',$request->input('username'))->first();
			if(!$uc){
				$user->username = $request->input('username');
			}else{
				return redirect()->back()->withErrors(['username' => 'Error! Username is already in use Please try again']);
			}

			$user->save();

			return redirect('user');
    }
        public function update(Request $request, $id)
    {
			$user 		= User::where('id',$id)->first();
			$user->name 	= $request->input('name');
            $user->tel 		= $request->input('tel');
			$username 	    = $user->username;
            $email	 	    = $user->email;
            $user->active 	= $request->has('active') ? 'Y' : 'N';

            if($request->input('password') != ''){
				$user->password = bcrypt($request->input('password'));
			}
            if($request->input('email') != $email){
					$c = User::where('email',$request->input('email'))->first();
					if(!$c){
						$user->email = $request->input('email');
					}else{
						return redirect()->back()->withErrors(['email' => 'Error! E-mail is already in use Please try again']);
					}
			}
			if($request->input('username') != $username){
					$c = User::where('username',$request->input('username'))->first();
					if(!$c){
						$user->username = $request->input('username');
					}else{
						return redirect()->back()->withErrors(['username' => 'Error! Username is already in use Please try again']);
					}
			}

			$user->save();
			return redirect('user');
    }

    public function destroy($id)
    {
        $ids = explode('-',$id);
 
            if( User::whereIn('id',$ids)->update(['active' => 'D']) ){
                $result = [
                    'result'    => 'successful',
                    'code'      => 200
                ];
            }else{
                $result = [
                    'result'    => 'error',
                    'msg'       => 'เกิดข้อผิดพลาดจากระบบไม่สามารถทำการลบข้อมูลได้ โปรดลองใหม่ภายหลัง',
                    'code'      =>  204
                ];
    
            }
        return Response()->json($result);
    }
}
