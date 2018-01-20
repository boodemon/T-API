<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;

class authJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::toUser($request->input('token'));
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                //return response()->json(['result'=>'error','msg'=>'Token is Invalid']);
                $result = [
                    'code'      => 201,
                    'result'    => 'error',
                    'msg'       => 'Token is Invalid'
                ];
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
               // return response()->json(['result'=>'error','msg'=>'Token is Expired']);
                $result = [
                    'code'      => 202,
                    'result'    => 'error',
                    'msg'       => 'Login time out. Please Login again'
                ];
            }else{
                $result = [
                    'code'      => 203,
                    'result'    => 'error',
                    'msg'       => 'Something is wrong'
                ];
            }

            return response()->json($result);
       }
        return $next($request);    }
}
