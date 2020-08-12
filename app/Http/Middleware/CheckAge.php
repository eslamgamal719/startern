<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckAge
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

        //Login middleware

        //Auth::User()  This way give all user data who make login

        //auth('web')::user()->age; => Auth   this is default guard (web)
        
       $age = Auth::user()-> age; 

        if($age < 15) {
            return redirect()->route('not.adult');
        }

        return $next($request);
    }
}
