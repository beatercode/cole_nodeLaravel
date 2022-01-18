<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Cms;
use App\Model\Presale;
use App\Model\Roadmap;
use App\Model\SiteSettings;
use App\Model\User;
use App\Model\UserActivity;
use Session;
use Redirect;

class Home extends Controller {
	public function __construct() {
		$this->site_data = SiteSettings::where('id', '1')->first();
	}

	public function index() {
		$site = Presale::where('id', 1)->select('BSC_start_time', 'ETC_start_time', 'BSC_end_time', 'ETC_end_time')->first();
		$cms = Cms::where('id', 1)->select('content')->first();
		if (session('network') != '' && session('network') == 'ETC') {
			$network = session('network');
			$today = date('Y-m-d H:i:s');
			$start_time = ($network == 'BSC') ? $site->BSC_start_time : $site->ETC_start_time;
		} else {
			$start_time = $site->BSC_start_time;
		}
		return view('front.common.index')->with('site', $this->site_data)->with('start_time', $start_time)->with('cms', $cms);
	}

	public function roadmap() {
		$roadmap = Roadmap::select('title', 'description')->get();
		return view('front.common.roadmap')->with('roadmap', $roadmap)->with('site', $this->site_data);
	}

	public function page404() {
		return view('front.common.page404')->with('site', $this->site_data);
	}

	public function ipblock() {
		$remote = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
		$ip = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $remote;
		$checkIp = BlockIP::where('ip_addr', $ip)->where('status', 'active')->count();
		if ($checkIp > 0) {
			return view('front.common.ipblock')->with('site', $this->site_data);
		} else {
			return Redirect::to('/');
		}
	}

	public function maintenance() {
		$getSite = SiteSettings::where('id', 1)->select('site_status')->first();
		if ($getSite->site_status == 0) {
			return view('front.common.maintenance')->with('site', $this->site_data);
		} else {
			return Redirect::to('');
		}
	}

	public function unlock(Request $request) {
		$address = strtolower(strip_tags($request['address']));
		$type = strip_tags($request['type']);
		if ($address != "") {
			$length = strlen($address);
			if ($length == 42) {
				$user = User::where('consumer_name', $address)->select('id')->first();
				if ($user) {
					$userId = $user->id;
				} else {
					$createUser = User::create(['consumer_name' => $address, 'status' => 'active']);
					if ($createUser) {
						$userId = $createUser->id;
					} else {
						echo "Error while creating user";exit();
					}
				}
				session(['userId' => $userId, 'userName' => $address]);
				if (session('userId') != '') {
					$activity['ip_address'] = Controller::getIpAddress();
					$activity['activity'] = "login";
					$activity['user_id'] = $userId;
					UserActivity::create($activity);
				}
				echo "success";
			} else {
				echo "Invalid address!";
			}
		} else {
			echo "Invalid address!";
		}
	}

	public function saveNetwork(Request $request) {
		if (session('userId') != '') {
			$network = strip_tags($request['network']);
			if ($network != "") {
				$userId = session('userId');
				$chainId = array('BSC' => 56, 'ETC' => 61);
				$chainHexId = array('BSC' => '0x38', 'ETC' => '0x3D');
				$id = $chainId[$network];
				$hex = $chainHexId[$network];
				session(['network' => $network, 'chainId' => $id, 'chainHexId' =>$hex]);
				echo 1;
			} else {
				echo 0;
			}
		} else {
			echo 0;
		}
	}

	public function convPrice($coin) {
		$nameArr = array('ETC' => 'ETC', 'BSC' => 'BNB');
		$name = $nameArr[$coin];
		$select =  $coin.'_token';
		$site = Presale::where('id', '1')->select($select)->first();
		$token = $site->$select;
		$res = coinmarket($name, $token);
		$tokenPrice = $res['tokenPrice'];
		$usdPrice = $res['usdPrice'];
		if($tokenPrice > 0 && $usdPrice > 0) {
			Presale::where('id', '1')->update([$coin.'_price' => $usdPrice, $coin.'_tokenprice' => $tokenPrice]);
			echo "Updated";
		} else {
			echo "Not Updated";
		}
	}

	public function logout() {
		if (session('userId') != '') {
			$ip = Controller::getIpAddress();
			$activity['ip_address'] = $ip;
			$activity['activity'] = "Logout";
			$activity['user_id'] = session('userId');
			UserActivity::create($activity);
			session()->flush();
			Session::flash('success', 'Disconnected successfully');
		} else {
			Session::flash('success', 'Disconnected successfully');
		}
		return Redirect::to('/');
	}

	public function test() {
	}
}