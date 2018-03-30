<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use App\User;

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
            $user = User::toUser($request->input('token'));
            //echo 'token = ' . $request->input('token');
        } catch (Exception $e) {
            
                $result = [
                    'code'      => 203,
                    'result'    => 'error',
                    'msg'       => 'Something is wrong'
                ];
            return response()->json($result);
            
       }
        return $next($request);    
    }
}
