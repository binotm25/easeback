<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ClientMiddleware
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
        if(Auth::user()->type == 3 || Auth::user()->type == 4){
            return $next($request);
        }else{
            return response([
                'message'   =>  'You are not authorised to process this request!'
            ], 401);
        }

    }
}
