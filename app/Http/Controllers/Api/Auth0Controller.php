<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\memberRequest;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Request as Req;
use Auth;
use Mail;

class Auth0Controller extends Controller
{
    public function __construct(){
        
    }


    public function register(memberRequest $request)
    {
        $row = new User;
        $row->name      = $request->input('name');
        $row->username  = $request->input('username');
        $row->email     = $request->input('email');
        $row->password  = bcrypt($request->input('password'));
        $row->tel       = $request->input('tel') != '' ? $request->input('tel') : '';
        $row->user_type = 'member';
        $row->level     = 'member';
        if( $row->save() ){
            $data = [
                'code'      => 200,
                'result'    => 'successful',
            ];
            $subject = 'Welcom to FOOD@SET member';
            $fromMail = 'info@foodatset.com';
            $fromName = 'FOOD @ SET';        
            Mail::send('emails.signup',['request' 	=> $request,'subject'	=> $subject,
				], function ( $message ) use ($request,$subject,$fromMail,$fromName){
                    $message->from($fromMail,$fromName );
                    $message->sender($fromMail,$fromName);
                    $message->replyTo($fromMail, 'No Reply email');
                    $message->to([$request->input('email') ]);
					$message->subject( $subject );
				});
        }else{
            $data = [
                'code'      => 202,
                'result'    => 'error'
            ];
        }
        return response()->json( $data );
    }

	public function login(Request $request){
           	
			$user = $request->input('username');
			$password = $request->input('password');
			$email 	= ['email' => $user, 'password' => $password];
			$username 	= ['username' => $user, 'password' => $password];
            $result = [];
			// if($token = auth()->attempt($username) ){
			if( Auth::guard('api')->attempt($username) || Auth::guard('api')->attempt( $email) ){
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

    public function checkuser(Request $request){
        if( $request->input('type') == 'username'){
            $row = User::where('username',$request->input('text'))->count();
        }elseif( $request->input('type') == 'email') {
            $row = User::where('email',$request->input('text'))->count();
        }else{
            $row = 0;
        }
        return $row ;
    }

    public function facebook_app( Request $request ){
        //echo '<pre>',print_r( $request->all() ),'</pre>';
        $chk =  User::where('facebook_id',$request->input('id') )
                        ->where('facebook_id','!=','')
                        ->where('user_type','member')->first();
        $row =  $chk ? $chk : new User;
        $password       = $this->randomPassword();
        $row->name      = $request->input('name');
        $row->username  = $request->input('email');
        $row->email     = $request->input('email');
        $row->facebook_id     = $request->input('id');
        $row->password  = bcrypt( $password );
        $row->user_type = 'member';
        $row->level     = 'member';
        if( $row->save() ){
            $username = [ 'username' => $request->input('email'),'password' => $password ];
            Auth::guard('api')->attempt($username);
            $token = json_encode( Auth::guard('api')->user() );
            $data = [
                'code'      => 200,
                'result'    => 'successful',
                'auth'     => base64_encode( $token ),
                'data'      => Auth::guard('api')->user()
            ];
            if( !$chk ){
                $subject = 'Welcom to FOOD@SET member';
                $fromMail = 'info@foodatset.com';
                $fromName = 'FOOD @ SET';        
                Mail::send('emails.signup-fb',[	'request' 	=> $request,'subject'	=> $subject, 'password' => $password,'social' => 'facebook'], 
                    function ( $message ) use ($request,$subject,$fromMail,$fromName ,$password){
                    $message->from($fromMail,$fromName );
                    $message->sender($fromMail,$fromName);
                    $message->replyTo($fromMail, 'No Reply email');
                    $message->to([$request->input('email') ]);
                    $message->subject( $subject );
                });
            }
        }else{
            $data = [
                'code'      => 202,
                'result'    => 'error'
            ];
        }
        return response()->json( $data );
    }

    public function google_app( Request $request ){
        $chk =  User::where('email',$request->input('email') )
                        ->where('user_type','member')->first();
        $row =  $chk ? $chk : new User;
        $password       = $this->randomPassword();
        $row->name      = $request->input('displayName');
        $row->username  = $request->input('email');
        $row->email     = $request->input('email');
        $row->google_id     = $request->input('userId');
        $row->password  = bcrypt( $password );
        $row->user_type = 'member';
        $row->level     = 'member';
        if( $row->save() ){
            $username = [ 'username' => $request->input('email'),'password' => $password ];
            Auth::guard('api')->attempt($username);
            $token = json_encode( Auth::guard('api')->user() );
            $data = [
                'code'      => 200,
                'result'    => 'successful',
                'auth'     => base64_encode( $token ),
                'data'      => Auth::guard('api')->user()
            ];
            if( !$chk ){
                $subject = 'Welcom to FOOD@SET member';
                $fromMail = 'info@foodatset.com';
                $fromName = 'FOOD @ SET';        
                Mail::send('emails.signup-fb',[	'request' 	=> $request,'subject'	=> $subject, 'password' => $password,'social' => 'google'], 
                    function ( $message ) use ($request,$subject,$fromMail,$fromName ,$password){
                    $message->from($fromMail,$fromName );
                    $message->sender($fromMail,$fromName);
                    $message->replyTo($fromMail, 'No Reply email');
                    $message->to([$request->input('email') ]);
                    $message->subject( $subject );
                });
            }
        }else{
            $data = [
                'code'      => 202,
                'result'    => 'error'
            ];
        }
        return response()->json( $data );    
    }

    public function forgot(Request $request){
        $row =  User::where('email',$request->input('email') )
                        ->where('user_type','member')->first();
        if( $row ){
            $password       = $this->randomPassword();
            $row->password  = bcrypt( $password );
            $row->save();
            $data = [
                'code'      => 200,
                'result'    => 'successful',
            ];        
            $subject = 'Reset member password FOOD@SET member';
            $fromMail = 'support@foodatset.com';
            $fromName = 'FOOD @ SET';        
            Mail::send('emails.forgot',[	'request' 	=> $request,'subject'	=> $subject, 'password' => $password,'social' => 'google'], 
                function ( $message ) use ($request,$subject,$fromMail,$fromName ,$password){
                $message->from($fromMail,$fromName );
                $message->sender($fromMail,$fromName);
                $message->replyTo($fromMail, 'No Reply email');
                $message->to([$request->input('email') ]);
                $message->subject( $subject );
            });
        }else{
            $data = [
                'code'      => 202,
                'result'    => 'error'
            ];
        }
        return response()->json( $data );    

    }

    public function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function testMail(){
        $subject = 'Welcom to www.railworldwide.com member';
        $fromMail = 'info@railworldwide.com';
        $fromName = 'Railworldwide Co., Ltd.';
        Mail::send('emails.test',[], 
            function ( $message ) use ($subject,$fromMail,$fromName){
            $message->from($fromMail,$fromName );
            $message->to(['nong.wasantasiri@gmail.com' ]);
            $message->subject( $subject );
        });

    }

    public function createText(Request $request){
		$file = storage_path().'/_tmp/' . time() . '.txt';
        File::put( $file, json_encode( $request->all() ) );
    }
}