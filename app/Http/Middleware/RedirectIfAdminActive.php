<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Redirect;
use App\Model\SubAdmin;

class RedirectIfAdminActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function __construct() {
        $this->Url = ADMINURL;
    }

    public function handle($request, Closure $next)
    {
        if(Session::get('adminId') != "") {
            $adminId = Session::get('adminId');
            $getUser = SubAdmin::where('id', $adminId)->select('status')->first();
            if($getUser->status != "active") {
                Session::flash('error','Your account deactivated by Admin');
                return Redirect::to($this->Url.'/logout');
            }
        }
        return $next($request);
    }
}
