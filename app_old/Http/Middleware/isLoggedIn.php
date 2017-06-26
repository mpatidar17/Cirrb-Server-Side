<?php

namespace App\Http\Middleware;

use App\User;

use Closure;

class isLoggedIn
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

        $token = $request->header("Authorization");

        $user = User::where("auth_token","=",$token)->get();

        if( empty($token) || count($user) == 0){

          die(json_encode(array('status' => 'success', 'message' => 'Invalid Token')));

        }

        return $next($request);

    }
}
