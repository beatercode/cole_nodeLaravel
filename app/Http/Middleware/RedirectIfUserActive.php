<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Redirect;
use App\Model\User;

class RedirectIfUserActive
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
        if(Session::get('userId') != "") {
            $userId = Session::get('userId');
            $getUser = User::where('id',$userId)->select('status')->first();
            if($getUser->status != "active") {
                Session::flash('error','Your account deactivated by Admin');
                return Redirect::to('logout');
            }
        }
        return $next($request);
    }
}
