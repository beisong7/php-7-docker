<?php

namespace App\Http\Middleware;

use App\Traits\Role\Privilege;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Access
{
    use Privilege;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){

            if(!Auth::user()->active){
                Auth::logout();
                return redirect()->route('login')->withErrors(['Account Disabled']);
            }

            if(!$this->hasAccess('emails')){
                Auth::logout();
                return redirect()->route('login')->withErrors(['Permissions Unauthorised']);
            }

            View::share('person', Auth::user());
            return $next($request);
        }

        return redirect()->route('admin.login');
    }
}
