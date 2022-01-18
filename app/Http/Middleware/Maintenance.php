<?php

namespace App\Http\Middleware;
use App\Http\Controllers\Controller;
use App\Model\SiteSettings;
use Closure;
use Redirect;


class Maintenance {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$status = SiteSettings::where('id', 1)->select('site_status')->first();
		$ip = Controller::getIpAddress();
		if($ip != '103.87.105.218') {
			if ($status->site_status == "0") {
				return Redirect::to('site_under_maintenance');
			}
		}
		return $next($request);
	}
}
