<?php

namespace App\Http\Middleware;

use App\Model\WhitelistIP;
use Closure;
use Redirect;

class whiteList {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$remote = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
		$ip = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $remote;
		$checkIp = WhitelistIP::where('ip_addr', $ip)->where('status','active')->count();
		if ($checkIp == 0) {
			echo "Your IP is not whitelisted"; exit;
		}
		return $next($request);
	}
}
