<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Redirect;
use Request;
class checkAdminMetamask
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
        /*if (session('adminMetamask') == '') {
            Session::flash('error','Please connect metamask to continue!');
            return Redirect::to($this->Url.'/connectWallet');
        }*/
        return $next($request);
    }
}
