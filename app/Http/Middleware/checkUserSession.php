<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use Session;
use Request;
use App\Model\UserActivity;


class checkUserSession {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (Session::get('userId') == "" && Session::get('userName') == "" ) {
			Session::flash('error', 'Please connect metamask to continue!!');
			return Redirect::to('/');
		} 
		return $next($request);
	}
}
