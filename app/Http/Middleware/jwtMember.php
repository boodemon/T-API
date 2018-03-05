<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;

class jwtMember
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
                $result = [
                    'code'      => 201,
                    'result'    => 'error',
                    'msg'       => 'Token is Invalid'
                ];
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){               
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
        return $next($request);    
    }
}
