<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Redirect;
use Request;
use App\Model\SiteSettings;
class checkAdminSession
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
        if (session('adminId') == '') {
            Session::flash('error','Please login to continue!');
            return Redirect::to($this->Url);
        }
        return $next($request);
    }
}
