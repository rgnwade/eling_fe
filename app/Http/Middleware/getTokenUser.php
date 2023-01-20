<?php

namespace FleetCart\Http\Middleware;
// use Illuminate\Support\Facades\Auth;
use Modules\User\Entities\User;
use Closure;
use Auth;


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
        $user = auth()->user();

        dd($user);

        $cur_url = $request->nonce;
        
        $user = User::where('api_token', $cur_url)->firstOrFail();

            if($user){
                Auth::login($user); // login user automatically
                // return redirect()->back()->withMessage('Profile saved!');
          }
            return $next($request);
        
    }
}
