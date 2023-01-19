<?php

namespace FleetCart\Http\Middleware;

use Closure;

class getTokenUser
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
        // if (Auth::check() && Auth::user()->role == 'admin') {
        //     return $next($request);
        //   }
        //  return redirect('/');   

        $cur_url = $request->nonce();
        
            dd($cur_url);
            return $next($request);
        
    }
}
