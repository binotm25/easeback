<?php

namespace App\Http\Middleware;

use Closure;

class IsVerified
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
        if(auth()->user()->verified == 1){
            return $next($request);
        }else{
            return response()->json([
                'message'   =>  'The user is not verified yet! Please check your mail for verification details!',
                'error'     =>  'Not Verified!'
            ], 401);
        }

    }
}
