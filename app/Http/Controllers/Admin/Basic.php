<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\AdminActivity;
use App\Model\AdminNotification;
use App\Model\BlockIP;
use App\Model\Cms;
use App\Model\Faq;
use App\Model\Googleauthenticator;
use App\Model\LoginAttempt;
use App\Model\Roadmap;
use App\Model\SiteSettings;
use App\Model\SubAdmin;
use App\Model\User;
use App\Model\WhitelistIP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;
use DateTime;
use DB;
use Mail;
use Redirect;
use Response;
use Session;
use URL;
use Validator;

class Basic extends Controller {
	public function __construct() {
		$this->Url = ADMINURL;
		if ($_SERVER['HTTP_HOST'] != "localhost") {
			if (!isset($_SERVER['PHP_AUTH_USER']) || (isset($_SERVER['PHP_AUTH_USER']) && ($_SERVER['PHP_AUTH_USER'] != 'CZrvqEfzpDNRXfnr' || $_SERVER['PHP_AUTH_PW'] != 'PKuxXFCwugdCTFHJ'))) {
				header('WWW-Authenticate: Basic realm=" Auth"');
				header('HTTP/1.0 401 Unauthorized');
				echo 'Authentication Failed';exit;
			}
		}
	}

	public function index() {
		if (session('adminId') != '') {
			$cur_date = date('Y-m-d');
			$data['new_users'] = User::where(DB::raw('DATE(created_at)'), $cur_date)->count();
			$data['total_users'] = User::count();
			return view('admin.common.dashboard')->with('data', $data)->with('redirectUrl', $this->Url);
		} else {
			return view('admin.common.login')->with('redirectUrl', $this->Url);
		}
	}

	public function adminLogin() {
		$data = Input::all();
		$Validation = Validator::make($data, User::$adminLoginRule);
		if ($Validation->fails()) {
			Session::flash('error', $Validation->messages());
			return Redirect::to($this->Url);
		}
		if ($data == array_filter($data)) {
			$email = explode('@', strip_tags($data['username']));
			$first = encrypText($email[0]);
			$second = encrypText($email[1]);
			$password = encrypText(strip_tags($data['user_pwd']));
			$pattern = encrypText(strip_tags($data['pattern_code']));

			$ip = Controller::getIpAddress();
			$browser = Controller::getBrowser();
			$platform = Controller::getPlatform();

			$login = SubAdmin::where('admin_desc', $first)->where('admin_sub_key', $second)->where('admin_key', $password)->where('admin_pattern', $pattern)->first();
			if ($login) {
				if ($login->status == "deactive") {
					Session::flash('error', 'You have been deactivated by Admin.');
					return Redirect::to($this->Url);
				}

				if ($login->tfa_status == "enable") {
					return Redirect::to($this->Url.'/tfaVerification/'.encrypText($login->id));
				}

				LoginAttempt::where('ip_address', $ip)->where('status', 'new')->update(['status' => 'old']);
				SubAdmin::where('id', $login['id'])->update(['login_status' => 'active']);

				$activity['ip_address'] = $ip;
				$activity['browser_name'] = $browser;
				$activity['os'] = $platform;
				$activity['activity'] = "Logged in";
				$activity['admin_id'] = $login['id'];
				AdminActivity::create($activity);

				session(['adminId' => $login['id'], 'adminName' => $login['admin_username'], 'adminRole' => $login['admin_role']]);
				Session::flash('success', 'Login Success');
			} else {
				$getCount = LoginAttempt::where('ip_address', $ip)->where('status', 'new')->count();
				if ($getCount >= 2) {
					$getBlockCount = BlockIP::where('ip_addr', $ip)->count();
					if ($getBlockCount == 0) {
						$updata = array('ip_addr' => $ip, 'status' => 'active');
						BlockIP::create($updata);
					} else {
						BlockIP::where('ip_addr', $ip)->update(['status' => 'active']);
					}
				}
				$createAttempt = array('ip_address' => $ip, 'os' => $platform, 'browser' => $browser, 'status' => 'new', 'username' => encrypText($data['username']), 'password' => encrypText($data['user_pwd']));
				LoginAttempt::create($createAttempt);
				Session::flash('error', 'Invalid login credentials!');
			}
			return Redirect::to($this->Url);
		} else {
			Session::flash('error', 'Please fill all fields!');
			return Redirect::to($this->Url);
		}
	}

	public function tfaVerification($id) {
		if (session('adminId') != '') {
			return Redirect::to($this->Url);
		} else {
			return view('admin.common.tfa_login')->with('aid', $id)->with('redirectUrl', $this->Url);
		}
	}

	public function tfaLogin() {
		$data = Input::all();
		if ($data == array_filter($data)) { 
			$adminId = decrypText(strip_tags($data['aid']));
			$ip = Controller::getIpAddress();
			$browser = Controller::getBrowser();
			$platform = Controller::getPlatform();

			$tfaDetails = Subadmin::where('id', $adminId)->select('secret', 'tfa_status', 'admin_username', 'admin_role')->first(); 
			$secret = $tfaDetails->secret;
			$code = $data['auth_key']; 
			require_once app_path('Model/Googleauthenticator.php');
			$googleAuth = new Googleauthenticator();
			$verify = $googleAuth->verifyCode($secret, $code, $discrepancy = 1);
			if ($verify == 1) { 
				$notf_msg1 = 'Hi!';
				$activity['ip_address'] = $ip;
				$activity['browser_name'] = $browser;
				$activity['os'] = $platform;
				$activity['activity'] = "Logged in";
				$activity['admin_id'] = $adminId;
				AdminActivity::create($activity);
				session(['adminId' => $adminId, 'adminName' => $tfaDetails['admin_username'], 'adminRole' => $tfaDetails['admin_role']]);
				Session::flash('success', 'Login Success');
				return Redirect::to($this->Url);
			} else { 
				Session::flash('error', 'Invalid authentication key.');
				return Redirect::to($this->Url.'/tfaVerification/'.encrypText($adminId));
			}
		} else {
			Session::flash('error', 'Please try again later');
			return Redirect::to($this->Url.'/tfaVerification/'.encrypText($adminId));
		}
	}

	public function checkResetEmail(Request $request) {
		$email = explode('@', strip_tags($request['email_addr']));
		$first = encrypText($email[0]);
		$second = encrypText($email[1]);
		$getCount = SubAdmin::where('admin_desc', $first)->where('admin_sub_key', $second)->count();
		echo ($getCount == 1) ? "true" : "false";
	}

	public function forgotPassword(Request $request) {
		$data = $request->all();
		$validate = Validator::make($data, [
			'useremail' => "required|indisposable",
		], [
			'useremail.required' => 'Please Enter email',
		]);

		if ($validate->fails()) {
			foreach ($validate->messages()->getMessages() as $val => $msg) {
				$result_data = array('status' => '0', 'msg' => $msg[0]);
				echo json_encode($result_data); exit;
			}
		}

		if ($data == array_filter($data)) {
			$useremail = strip_tags($data['useremail']);
			$email = explode('@', $useremail);
			$first = encrypText($email[0]);
			$second = encrypText($email[1]);

			$getDetail = SubAdmin::select('id', 'admin_username')->where('admin_desc', $first)->where('admin_sub_key', $second)->first();
			if ($getDetail) {
				$id = encrypText($getDetail->id);
				$generateCode = User::randomString(8);
				$randomCode = encrypText($generateCode);
				$update = SubAdmin::where('id', $getDetail->id)->update(['admin_forgot_code' => $randomCode, 'admin_forgot_status' => 'active']);
				
				if ($update) {
					$result_data = array('status' => '1', 'msg' => 'Reset password Link has sent to Your Mail Id');
				} else {
					$result_data = array('status' => '0', 'msg' => 'Please Try Again');
				}
			} else {
				$result_data = array('status' => '0', 'msg' => 'Invalid Email ID');
			}
		}
		echo json_encode($result_data);
	}

	public function forgotPattern(Request $request) {
		$data = $request->all();
		$validate = Validator::make($data, [
			'useremail' => "required|indisposable",
		], [
			'useremail.required' => 'Please Enter email',
		]);

		if ($validate->fails()) {
			foreach ($validate->messages()->getMessages() as $val => $msg) {
				$result_data = array('status' => '0', 'msg' => $msg[0]);
				echo json_encode($result_data); exit;
			}
		}
		if ($data == array_filter($data)) {
			$useremail = trim(strip_tags($data['useremail']));
			$email = explode('@', $useremail);
			$first = encrypText($email[0]);
			$second = encrypText($email[1]);

			$getDetail = SubAdmin::select('id', 'admin_username')->where('admin_desc', $first)->where('admin_sub_key', $second)->first();
			if ($getDetail) {
				$id = encrypText($getDetail->id);
				$generateCode = User::randomString(8);
				$randomCode = encrypText($generateCode);
				$update = SubAdmin::where('id', $getDetail->id)->update(['forgot_pattern_code' => $randomCode, 'forgot_pattern_status' => 'active']);
				if ($update) {
					$result_data = array('status' => '1', 'msg' => 'Reset pattern Link has sent to Your Mail Id');
				} else {
					$result_data = array('status' => '0', 'msg' => 'Please Try Again');
				}
			} else {
				$result_data = array('status' => '0', 'msg' => 'Invalid Email ID');
			}
		}
		echo json_encode($result_data);
	}

	public function resetPassword($arg1, $arg2) {
		$id = decrypText($arg1);
		$getDetail = SubAdmin::select('id', 'admin_forgot_status')
		->where('id', $id)->first();
		if ($getDetail->admin_forgot_status == "active") {
			$data['fcode'] = $arg2;
			$data['ucode'] = $arg1;
			return view('admin.common.reset')->with('data', $data)->with('redirectUrl', $this->Url);
		} else {
			Session::flash('error', 'URL expired');
			return Redirect::to($this->Url);
		}
	}

	public function updatePassword() {
		$data = Input::all();
		$validate = Validator::make($data, User::$passwordRule);
		if ($validate->fails()) {
			foreach ($validate->messages()->getMessages() as $val => $msg) {
				Session::flash('error', $msg[0]);
				return Redirect::to($this->Url);
			}
		}

		if ($data == array_filter($data)) {
			$new_pwd = strip_tags($data['new_pwd']);
			$cnfirm_pwd = strip_tags($data['cnfirm_pwd']);
			$fcode = strip_tags($data['fcode']);
			$userid = decrypText(strip_tags($data['ucode']));
			if ($new_pwd == $cnfirm_pwd) {
				$getDetail = SubAdmin::select('id', 'admin_forgot_status')->where('id', $userid)->first();
				if ($getDetail->admin_forgot_status == "active") {
					$password = encrypText($cnfirm_pwd);
					$update = SubAdmin::where('id', $userid)->update(['admin_key' => $password, 'admin_forgot_code' => "", 'admin_forgot_status' => 'deactive']);
					if ($update) {
						Session::flash('success', 'Password Reset Success');
						return Redirect::to($this->Url);
					} else {
						Session::flash('error', 'Please Try Again');
					}
				} else {
					Session::flash('error', 'Reset Url Expired');
				}
			} else {
				Session::flash('error', 'Password Must match');
			}
		} else {
			Session::flash('error', 'Fill All the Field');
		}
	}

	public function resetPattern($arg1, $arg2) {
		$id = decrypText($arg1);
		$getDetail = SubAdmin::where('forgot_pattern_status', 'active')->where('id', $id)->count();
		if ($getDetail == 1) {
			$data['fcode'] = $arg2;
			$data['ucode'] = $arg1;
			return view('admin.common.resetpattern')->with('data', $data)->with('redirectUrl', $this->Url);
		} else {
			Session::flash('error', 'URL expired');
			return Redirect::to($this->Url);
		}
	}

	public function updatePattern() {
		$data = Input::all();
		$validate = Validator::make($data, [
			'pattern_code' => 'required|min:3',
			'pattern_code_confirmation' => 'required|min:3',
		], [
			'pattern_code.required' => 'Enter pattern',
			'pattern_code.min' => 'Enter atleast 3 characters',
			'pattern_code_confirmation.required' => 'Enter confirm pattern',
		]);

		if ($validate->fails()) {
			foreach ($validate->messages()->getMessages() as $val => $msg) {
				Session::flash('error', $msg[0]);
				return Redirect::to($this->Url);
			}
		}
		if ($data == array_filter($data)) {
			$new_pwd = strip_tags($data['pattern_code']);
			$cnfirm_pwd = strip_tags($data['pattern_code_confirmation']);
			$fcode = strip_tags($data['fcode']);
			$userid = decrypText(strip_tags($data['ucode']));
			if ($new_pwd == $cnfirm_pwd) {
				$getDetail = SubAdmin::select('id', 'forgot_pattern_status')->where('id', $userid)->first();
				if ($getDetail->forgot_pattern_status == "active") {
					$pattern = encrypText($cnfirm_pwd);
					$update = SubAdmin::where('id', $userid)->update(['admin_pattern' => $pattern, 'forgot_pattern_code' => "", 'forgot_pattern_status' => 'deactive']);
					if ($update) {
						Session::flash('success', 'Pattern Reset Success');
					} else {
						Session::flash('error', 'Please Try Again');
					}
				} else {
					Session::flash('error', 'Reset Url Expired');
				}
			} else {
				Session::flash('error', 'Pattern Must match');
			}
		} else {
			Session::flash('error', 'Fill All the Field');
		}
		return Redirect::to($this->Url);
	}

	public function viewProfile() {
		if (session('adminId') != '') {
			$data = SubAdmin::where('id', session('adminId'))->first();
			$first = decrypText($data['admin_desc']);
			$second = decrypText($data['admin_sub_key']);
			$useremailid = $first . "@" . $second;

			require_once app_path('Model/Googleauthenticator.php');
			$googleAuth = new Googleauthenticator();
			if ($data->secret == "" && $data->tfa_url == "") {
				$secret = $googleAuth->createSecret();
				$tfaUrl = $googleAuth->getQRCodeGoogleUrl(SITENAME."(" . $useremailid . ")", $secret);
				SubAdmin::where('id', session('adminId'))->update(['secret' => $secret, 'tfa_url' => $tfaUrl, 'tfa_status' => 'disable']);
				$data['secret'] = $secret;
				$data['tfa_url'] = $tfaUrl;
			}
			return view('admin.common.profile')->with('profile', $data)->with('redirectUrl', $this->Url);
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function updateProfile() {
		if (session('adminId') != '') {
			$adminId = session('adminId');
			$data = Input::all();
			$Validation = Validator::make($data, SubAdmin::$profileRule);
			if ($Validation->fails()) {
				Session::flash('error', $Validation->messages());
				return Redirect::to($this->Url.'/profile');
			}
			if ($_FILES['admin_profile']['name'] == "") {
				$image = strip_tags($data['admin_profile_old']);
			} else {
				$fileExtensions = ['jpeg', 'jpg', 'png'];
				$fileName = $_FILES['admin_profile']['name'];
				$fileType = $_FILES['admin_profile']['type'];
				$explode = explode('.', $fileName);
				$extension = end($explode);
				$fileExtension = strtolower($extension);
				$mimeImage = mime_content_type($_FILES["admin_profile"]['tmp_name']);
				$explode = explode('/', $mimeImage);

				if (!in_array($fileExtension, $fileExtensions)) {
					Session::flash('error', 'Invalid file type. Only image files are accepted.');
					return Redirect::to($this->Url.'/profile');
				} else {
					if ($explode[0] != "image") {
						Session::flash('error', 'Invalid file type. Only image files are accepted.');
						return Redirect::to($this->Url.'/profile');
					}
					$imageUpload = Controller::imageUpload($data['admin_profile'], $fileName, $fileExtensions);
					if ($imageUpload) {
						$image = $imageUpload;
					} else {
						Session::flash('error', 'Error uploading image');
						return Redirect::to($this->Url.'/profile');
					}
				}
			}
			$result = SubAdmin::where('id', $adminId)->update(['admin_username' => strip_tags($data['admin_username']), 'admin_profile' => $image, 'admin_phone' => strip_tags($data['admin_phno']), 'admin_address' => strip_tags($data['admin_address']), 'admin_city' => strip_tags($data['admin_city']), 'admin_state' => strip_tags($data['admin_state']), 'admin_postal' => strip_tags($data['admin_postal']), 'country' => strip_tags($data['country'])]);
			if ($result) {
				Session::flash('success', 'Profile Updated Successfully');
			} else {
				Session::flash('error', 'Failed to update.');
			}
			return Redirect::to($this->Url.'/profile');
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function enableDisableTFa() {
		if (session('adminId') != '') {
			$adminId = session('adminId');
			$data = Input::all();
			$getUserDetails = SubAdmin::where('id', $adminId)->select('admin_desc', 'admin_sub_key','tfa_status')->first();
			$first = decrypText($getUserDetails['admin_desc']);
			$second = decrypText($getUserDetails['admin_sub_key']);
			$useremailid = $first . "@" . $second;

			require_once app_path('Model/Googleauthenticator.php');
			$googleAuth = new Googleauthenticator();
			if ($googleAuth->verifyCode($data['secret_code'], $data['auth_key'], 1)) {
				if ($data['tfa_status'] == "disable") {
					$updateData = array('secret' => $data['secret_code'], 'tfa_url' => $data['tfa_url'], 'tfa_status' => 'enable');
					$msg = 'TFA enabled successfully';
					$type = 'TFA enabled';
					$notf_msg3 = 'You have enabled 2FA';
				} else {
					$secret = $googleAuth->createSecret();
					$tfaUrl = $googleAuth->getQRCodeGoogleUrl(SITENAME."(" . $useremailid . ")", $secret);
					$updateData = array('secret' => $secret, 'tfa_url' => $tfaUrl, 'tfa_status' => 'disable');
					$type = 'TFA disabled';
					$msg = 'TFA disabled successfully';
					$notf_msg3 = 'You have disabled 2FA';
				}
				$result = SubAdmin::where('id', $adminId)->update($updateData);
				if ($result) {
					$notf_msg1 = 'Hi!';
					$msg1 = $notf_msg1 . " ," . $notf_msg3 . "!";
					Session::flash('success', $msg);
				} else {
					Session::flash('error', 'Failed to update TFA verification.');
				}
				self::logout();
				return Redirect::back();
			} else {
				Session::flash('error', 'Invalid 6-digit Authentication Code');
				return Redirect::back();
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function checkPassword() {
		if (session('adminId') != '') {
			$pwd = encrypText($_GET['current_pwd']);
			$getCount = SubAdmin::where('id', session('adminId'))->where('admin_key', $pwd)->count();
			echo ($getCount == 1) ? "true" : "false";
		} else {
			echo "false";
		}
	}

	public function changePassword() {
		if (session('adminId') != '') {
			$data = Input::all();
			$adminId = session('adminId');
			$Validation = Validator::make($data, SubAdmin::$pwdRule);
			if ($Validation->fails()) {
				Session::flash('error', $Validation->messages());
				return Redirect::to($this->Url.'/profile');
			}
			if ($data == array_filter($data)) {
				$new_pwd = strip_tags($data['new_pwd']);
				$confirm_pwd = strip_tags($data['confirm_pwd']);
				$pwd = encrypText(strip_tags($data['current_pwd']));
				$getCount = SubAdmin::where('id', $adminId)->where('admin_key', $pwd)->count();
				if ($getCount == 1) {
					if ($new_pwd == $confirm_pwd) {
						$updateData = encrypText($confirm_pwd);
						$result = SubAdmin::where('id', $adminId)->update(['admin_key' => $updateData]);
					}
				}
				if ($result) {
					Session::flash('success', 'password Updated Successfully');
				} else {
					Session::flash('error', 'Failed to update.');
				}
				self::logout();
				return Redirect::to($this->Url.'/profile');
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function adminSettings() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 0);
			if ($permission == true) {
				$data = SiteSettings::first();			
				return view('admin.common.settings')->with('adminsettings', $data)->with('redirectUrl', $this->Url);
			} 
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function updateSite() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 0);
			if ($permission == true) {
				$adminId = session('adminId');
				$data = Input::all();
				$Validation = Validator::make($data, SubAdmin::$siteRule);
				if ($Validation->fails()) {
					Session::flash('error', $Validation->messages());return Redirect::back();
				}
				if ($_FILES['site_logo']['name'] == "") {
					$image = strip_tags($data['site_logo_old']);
				} else if ($_FILES['site_logo']['name'] != "") {
					$fileExtensions = ['jpeg', 'jpg', 'png', 'svg'];
					$fileName = $_FILES['site_logo']['name'];
					$fileType = $_FILES['site_logo']['type'];
					$explode = explode('.', $fileName);
					$extension = end($explode);
					$fileExtension = strtolower($extension);
					$mimeImage = mime_content_type($_FILES["site_logo"]['tmp_name']);
					$explode = explode('/', $mimeImage);

					if (!in_array($fileExtension, $fileExtensions)) {
						Session::flash('error', 'Invalid file type. Only image files are accepted.');
						return Redirect::to($this->Url.'/settings');
					} else {
						if ($explode[0] != "image") {
							Session::flash('error', 'Invalid file type. Only image files are accepted.');
							return Redirect::to($this->Url.'/settings');
						}
						$imageUpload = Controller::imageUpload($data['site_logo'], $fileName, $fileExtensions);
						if ($imageUpload) {
							$image = $imageUpload;
						} else {
							Session::flash('error', 'Error uploading image');
							return Redirect::to($this->Url.'/settings');
						}
					}
				}
				if ($_FILES['site_favicon']['name'] == "") {
					$favimage = strip_tags($data['site_favicon_old']);
				} else if ($_FILES['site_favicon']['name'] != "") {
					$fileExtensions = ['jpeg', 'jpg', 'png', 'ico'];
					$fileName = $_FILES['site_favicon']['name'];
					$fileType = $_FILES['site_favicon']['type'];
					$explode = explode('.', $fileName);
					$extension = end($explode);
					$fileExtension = strtolower($extension);
					$mimeImage = mime_content_type($_FILES["site_favicon"]['tmp_name']);
					$explode = explode('/', $mimeImage);

					if (!in_array($fileExtension, $fileExtensions)) {
						Session::flash('error', 'Invalid file type. Only image files are accepted.');
						return Redirect::to($this->Url.'/settings');
					} else {
						if ($explode[0] != "image") {
							Session::flash('error', 'Invalid file type. Only image files are accepted.');
							return Redirect::to($this->Url.'/settings');
						}
						$imageUpload = Controller::imageUpload($data['site_favicon'], $fileName, $fileExtensions);
						if ($imageUpload) {
							$favimage = $imageUpload;
						} else {
							Session::flash('error', 'Error uploading image');
							return Redirect::to($this->Url.'/settings');
						}
					}
				}

				$siteData = array(
					'site_name' => strip_tags($data['site_name']),
					'maintenance_text' => strip_tags($data['maintenance_text']),
					'site_status' => strip_tags($data['site_status']),
					'site_logo' => $image,
					'site_favicon' => $favimage,
					'contact_number' => strip_tags($data['contact_no']),
					'contact_address' => strip_tags($data['contact_address']),
					'city' => strip_tags($data['city']),
					'state' => strip_tags($data['state']),
					'country' => strip_tags($data['country']),
					'copy_right_text' => strip_tags($data['copy_right_text']),
					'twitter_url' => strip_tags($data['twitter_url']),
					'tele_url' => strip_tags($data['tele_url']),
					'medium_url' => strip_tags($data['medium_url']),
					'postal' => strip_tags($data['postal']),
				);
				$result = SiteSettings::where('id', 1)->update($siteData);
				if ($result) {
					Session::flash('success', 'Site Updated Successfully');
				} else {
					Session::flash('error', 'Failed to update.');
				}
				return Redirect::back();
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function decreaseNotifyCount() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 0);
			if ($permission == true) {
				AdminNotification::where('status', 'unread')->update(['status' => 'read']);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		} else {
			Session::flash('error', 'Session Expired');
			return Redirect::to($this->Url);
		}
	}		

	public function checkUsernameExists(Request $request) {
		$getCount = SubAdmin::where('admin_username', strip_tags($request['username']))->count();
		echo ($getCount == 1) ? "false" : "true";
	}

	public function checkEmailExists(Request $request) {
		$email = explode('@', strip_tags(strtolower($request['email_addr'])));
		$first = encrypText($email[0]);
		$second = encrypText($email[1]);
		$getCount = SubAdmin::where('admin_desc', $first)->where('admin_sub_key', $second)->count();
		echo ($getCount == 1) ? "false" : "true";
	}

	public function loginHistory() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 0);
			if ($permission == true) {
				$data = AdminActivity::where('activity', '!=', 'login')->where('activity', '!=', 'logout')->orderBy('id', 'desc')->limit(50)->get();
				return view('admin.common.history')->with('history', $data)->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function viewSubadmin() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 0);
			if ($permission == true) {
				$data = SubAdmin::where('admin_role', '!=', 'admin')->orderBy('id', 'desc')->get();
				return view('admin.subadmin.subadmin')->with('subadmin', $data)->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function subadminStatus($id) {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 0);
			if ($permission == true) {
				$id = decrypText(strip_tags($id));
				if ($id != session('adminId')) {
					$admin = SubAdmin::where('id', $id)->select('status')->first();
					$new_status = ($admin->status == "active") ? "deactive" : "active";
					$update = SubAdmin::where('id', $id)->update(['status' => $new_status]);
					if ($update) {
						$new_stat = ($admin->status == "active") ? "Deactivated" : "Activated";
						$msg = "Sub Admin " . $new_stat . " Successfully";
						Session::flash('success', $msg);
					} else {
						Session::flash('error', 'Please Try Again');
					}
				} else {
					Session::flash('error', 'You could not change your activity status.');
				}
				return Redirect::to($this->Url.'/viewSubadmin');
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function addSubadmin() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 0);
			if ($permission == true) {
				$data['type'] = "add";
				return view('admin.subadmin.addSubadmin')->with('subadmin', $data)->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function subadminEdit($id) {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 0);
			if ($permission == true) {
				$id = decrypText($id);
				$data = SubAdmin::where('id', $id)->first();
				$data['type'] = "edit";
				return view('admin.subadmin.addSubadmin')->with('subadmin', $data)->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function updateSubadmin() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 0);
			if ($permission == true) {
				$data = Input::all();
				$Validation = Validator::make($data, SubAdmin::$addSubadminRule);
				if ($Validation->fails()) {
					Session::flash('error', $Validation->messages());
					return Redirect::to($this->Url);
				}
				if ($data['type'] == "add") {
					unset($data['id']);
				}
				if ($data['type'] == "edit") {
					$id = decrypText(strip_tags($data['id']));
					$getAdminPwd = SubAdmin::select('admin_key')->where('id', $id)->first();
					$password = $getAdminPwd->admin_key;
				}
				if ($data['password'] != "") {
					$password = encrypText(strip_tags($data['password']));
				}
				$data['password'] = $password;
				if ($data == array_filter($data)) {
					$permission = implode(',', $data['permission']);
					$email = explode('@', strip_tags($data['email_addr']));
					$first = encrypText($email[0]);
					$second = encrypText($email[1]);

					$getAdminCtrl = SubAdmin::select('admin_ctrl', 'admin_pass', 'admin_key')->where('id', 1)->first();

					$securl = $this->Url;
					if (isset($id) && $id != "") {
						$result = SubAdmin::where('id', $id)->update(['admin_permission' => $permission, 'admin_desc' => $first, 'admin_sub_key' => $second, 'admin_key' => $password, 'admin_pattern' => encrypText(strip_tags($data['pattern_code']))]);
						$st = "Updated";
						$user_data = SubAdmin::where('id', $id)->first();
					} else {
						$getCount = SubAdmin::where('admin_desc', $first)->where('admin_sub_key', $second)->count();
						if ($getCount > 0) {
							Session::flash('error', 'Email Already exists.');
							return Redirect::back();
						} 
					}
					if ($result) {
						Session::flash('success', 'Subadmin ' . $st . ' Succeesfully');
						return Redirect::to($this->Url.'/viewSubadmin');
					}
				} else {
					Session::flash('error', 'Failed to add Subadmin.');
					return Redirect::back();
				}
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function deleteSubadmin($id) {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 0);
			if ($permission == true) {
				$id = decrypText($id);
				if ($id != session('adminId')) {
					$delete = SubAdmin::where(['id' => $id])->delete();
					if ($delete) {
						Session::flash('success', "SubAdmin deleted Successfully");
					} else {
						Session::flash('error', 'Please Try Again');
					}
					return Redirect::back();
				} else {
					Session::flash('error', 'You can not delete your own account.');
					return Redirect::back();
				}
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	//Block IP actions
	public function viewBlockIp() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 3);
			if ($permission == true) {
				return view('admin.blockip.blockIp')->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function blockHistory() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 3);
			if ($permission == true) {
				$totalrecords = intval(Input::get('totalrecords'));
				$draw = Input::get('draw');
				$start = Input::get('start');
				$length = Input::get('length');
				$sorttype = Input::get('order');
				$sort_col = $sorttype['0']['column'];
				$sort_type = $sorttype['0']['dir'];
				$search = Input::get('search');
				$from_date = Input::get('from');
				$to_date = Input::get('to');
				$search = $search['value'];

				if ($sort_col == '1') {
					$sort_col = 'ip_addr';
				} else if ($sort_col == '2') {
					$sort_col = 'status';
				} else if ($sort_col == '3') {
					$sort_col = 'created_at';
				} else {
					$sort_col = "id";
				}

				if ($sort_type == 'asc') {
					$sort_type = 'desc';
				} else {
					$sort_type = 'asc';
				}
				$data = $orders = array();

				$blockHis = BlockIP::where('status', '!=', '');
				
				if ($search != '') {
					$blockHis = $blockHis->where(function ($q) use ($search) {
						$q->where('ip_addr', 'like', '%' . $search . '%')->orWhere('status', 'like', '%' . $search . '%')->orWhere('created_at', 'like', '%' . $search . '%');}
					);
				}

				if ($from_date) {
					$blockHis = $blockHis->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime($from_date)));
				}

				if ($to_date) {
					$blockHis = $blockHis->where('created_at', '<=', date('Y-m-d 23:59:59', strtotime($to_date)));
				}

				$blockHis_count = $blockHis->count();
				if ($blockHis_count) {

					$blockHis = $blockHis->select('ip_addr', 'status', 'created_at', 'id');

					$orders = $blockHis->skip($start)->take($length)->orderBy($sort_col, $sort_type)->get()->toArray();
				}

				$data = array();
				$no = $start + 1;

				if ($blockHis_count) {
					foreach ($orders as $r) {
						$id = encrypText($r['id']);

						if ($r['status'] == "active") {
							$stsCls = "clsActive";
						} elseif ($r['status'] == "deactive") {
							$stsCls = "clsDeactive";
						}

						$removeIcon = URL::to('public/AVKpqBqmVJ/images/remove-user-icon.png');
						$deleteIcon = URL::to('public/AVKpqBqmVJ/images/delete-icon.png');
						$removeUrl = URL::to($this->Url.'/ipAddrStatus/'.$id);
						$deleteUrl = URL::to($this->Url.'/ipAddrDelete/'.$id);

						$status = '<a href="#" class="clsCtlr '.$stsCls.'">'.ucfirst($r['status']).'</a>';
						$status1 = '<a href="'.$removeUrl.'" class="userRemove"><img src="'.$removeIcon.'" title="Change Status" /></a>';
						$status2 = '<a href="'.$deleteUrl.'" class="deleteUser"><img src="'.$deleteIcon.'" title="Delete"  /></a>';

						array_push($data, array(
							$no,
							$r['ip_addr'],
							$status,
							$status1." ".$status2,
						));
						$no++;
					}

					echo json_encode(array('draw' => intval($draw), 'recordsTotal' => $blockHis_count, 'recordsFiltered' => $blockHis_count, 'data' => $data));
				} else {

					echo json_encode(array('draw' => intval($draw), 'recordsTotal' => $blockHis_count, 'recordsFiltered' => $blockHis_count, 'data' => array()));
				}
			} 
		}
	}

	public function ipAddrStatus($id) {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 3);
			if ($permission == true) {
				$id = decrypText(strip_tags($id));
				$ipAddr = BlockIP::where('id', $id)->first();
				$new_status = ($ipAddr->status == "active") ? "deactive" : "active";
				if($new_status == 'deactive') {
					LoginAttempt::where('ip_address', $ipAddr->ip_addr)->where('status', 'new')->update(['status' => 'old']);	
				}
				$update = BlockIP::where('id', $id)->update(['status' => $new_status]);
				if ($update) {
					$new_stat = ($ipAddr->status == "active") ? "Deactivated" : "Activated";
					$msg = "IP address " . $new_stat . " Successfully";
					Session::flash('success', $msg);
				} else {
					Session::flash('error', 'Please Try Again');
				}
				return Redirect::to($this->Url.'/viewBlockIp');
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function ipAddrDelete($id) {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 3);
			if ($permission == true) {
				$id = decrypText(strip_tags($id));
				$faq = BlockIP::where(['id' => $id])->delete();
				if ($faq) {
					Session::flash('success', "IP Address deleted Successfully");
				} else {
					Session::flash('error', 'Please Try Again');
				}
				return Redirect::to($this->Url.'/viewBlockIp');
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function addIpAddress() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 3);
			if ($permission == true) {
				$data = Input::all();
				if ($data == array_filter($data)) {
					$data['ip_addr'] = trim($data['ip_addr']);
					$data['ip_addr'] = strip_tags($data['ip_addr']);
					$checkIp = BlockIP::where('ip_addr', $data['ip_addr'])->count();
					if ($checkIp == 0) {
						$insdata = array('ip_addr' => $data['ip_addr'], 'status' => 'active');
						$createIp = BlockIP::create($insdata);
						if ($createIp) {
							Session::flash('success', 'IP Address added successfully');
						} else {
							Session::flash('error', 'IP address already added.');
						}
					} else {
						Session::flash('error', 'Failed to add IP address.');
					}
				} else {
					Session::flash('error', 'Please enter IP address.');
				}
				return Redirect::to($this->Url.'/viewBlockIp');
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	//Whitelist IP actions
	public function viewWhitelistIp() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 4);
			if ($permission == true) {
				$data = WhitelistIP::orderBy('id','desc')->get();
				return view('admin.whitelistip.whitelistIp')->with('ip', $data)->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function whitelistipAddrStatus($id) {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 4);
			if ($permission == true) {
				$id = decrypText(strip_tags($id));
				$ipAddr = WhitelistIP::where('id', $id)->first();
				$new_status = ($ipAddr->status == "active") ? "deactive" : "active";
				$update = WhitelistIP::where('id', $id)->update(['status' => $new_status]);
				if ($update) {
					$new_stat = ($ipAddr->status == "active") ? "Deactivated" : "Activated";
					$msg = "IP address " . $new_stat . " Successfully";
					Session::flash('success', $msg);
				} else {
					Session::flash('error', 'Please Try Again');
				}
				return Redirect::to($this->Url.'/viewWhitelistIp');
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function whitelistipAddrDelete($id) {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 4);
			if ($permission == true) {
				$id = decrypText(strip_tags($id));
				$faq = WhitelistIP::where(['id' => $id])->delete();
				if ($faq) {
					Session::flash('success', "IP Address deleted Successfully");
				} else {
					Session::flash('error', 'Please Try Again');
				}
				return Redirect::to($this->Url.'/viewWhitelistIp');
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function addwhitelistIp() {
		$ip_addr = Controller::getIpAddress();
		$checkIp = WhitelistIP::where('ip_addr', $ip_addr)->count();
		if ($checkIp == 0) {
			$insdata = array('ip_addr' => $ip_addr, 'status' => 'active');
			$createIp = WhitelistIP::create($insdata);
			echo 'IP Address added successfully';
		} else {
			echo 'IP address already added.';
		}
	}

	public function whitelistaddIpAddress() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 4);
			if ($permission == true) {
				$data = Input::all();
				if ($data == array_filter($data)) {
					$data['ip_addr'] = trim($data['ip_addr']);
					$data['ip_addr'] = strip_tags($data['ip_addr']);
					$checkIp = WhitelistIP::where('ip_addr', $data['ip_addr'])->count();
					if ($checkIp == 0) {
						$insdata = array('ip_addr' => $data['ip_addr'], 'status' => 'active');
						$createIp = WhitelistIP::create($insdata);
						if ($createIp) {
							Session::flash('success', 'IP Address added successfully');
						} else {
							Session::flash('error', 'IP address already added.');
						}
					} else {
						Session::flash('error', 'Failed to add IP address.');
					}
				} else {
					Session::flash('error', 'Please enter IP address.');
				}
				return Redirect::to($this->Url.'/viewWhitelistIp');
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function viewFaq() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 5);
			if ($permission == true) {
				$data = Faq::orderBy('id','desc')->get();
				return view('admin.faq.faq')->with('faq_list', $data)->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function faqEdit($id = NULL) {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 5);
			if ($permission == true) {
				if ($id != "") {
					$id = decrypText(strip_tags($id));
					$data = Faq::where('id', $id)->first();
					$data['type'] = "edit";
				} else {
					$data['faq'] = "";
					$data['type'] = 'add';
				}
				return view('admin.faq.faqEdit')->with('faq', $data)->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function faqUpdate() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 5);
			if ($permission == true) {
				$data = Input::all();
				$Validation = Validator::make($data, SubAdmin::$faqRule);
				if ($Validation->fails()) {
					Session::flash('error', $Validation->messages());
					return Redirect::to($this->Url.'/viewfaq');
				}
				if (!empty($data)) {
					$faq['question'] = strip_tags($data['question']);
					$faq['description'] = $data['description'];
					$faq['status'] = 'active';
					$faqId = decrypText(strip_tags($data['id']));
					if ($data['id'] != "") {
						$result = Faq::where('id', $faqId)->update($faq);
					} else {
						$result = Faq::create($faq);
					}
					if ($result) {
						Session::flash('success', 'FAQ Updated Successfully');
					} else {
						Session::flash('error', 'Failed to update.');
					}
					return Redirect::to($this->Url.'/viewfaq');
				}
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function faqStatus($id) {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 5);
			if ($permission == true) {
				$id = decrypText(strip_tags($id));
				$faq = Faq::where('id', $id)->first();
				$new_status = ($faq->status == "active") ? "deactive" : "active";
				$update = Faq::where('id', $id)->update(['status' => $new_status]);
				if ($update) {
					$new_stat = ($faq->status == "active") ? "Deactivated" : "Activated";
					$msg = "FAQ " . $new_stat . " Successfully";
					Session::flash('success', $msg);
				} else {
					Session::flash('error', 'Please Try Again');
				}
				return Redirect::to($this->Url.'/viewfaq');
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function faqDelete($id) {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 5);
			if ($permission == true) {
				$id = decrypText(strip_tags($id));
				$faq = Faq::where(['id' => $id])->delete();
				if ($faq) {
					Session::flash('success', "FAQ deleted Successfully");
				} else {
					Session::flash('error', 'Please Try Again');
				}
				return Redirect::to($this->Url.'/viewfaq');
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function viewCms($type) {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 7);
			if ($permission == true) {
				$data = Cms::where('sub_type', $type)->where('status', 'active')->get();
				return view('admin.cms.cms')->with('cms_list', $data)->with('type', $type)->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function cmsAdd() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 7);
			if ($permission == true) {
				return view('admin.cms.cmsadd')->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function cmsadded() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 7);
			if ($permission == true) {
				$data = Input::all();
				$Validation = Validator::make($data, SubAdmin::$cmsRule);
				if ($Validation->fails()) {
					Session::flash('error', $Validation->messages());
					return Redirect::back();
				}
				unset($data['_token']);

				$title = strip_tags($data['title']);
				$sub_title = $data['title_show'];
				$content = $data['content'];

				$data1['title'] = $title;
				$data1['content'] = $content;
				$data1['sub_type'] = $sub_title;
				$data1['status'] = 'active';
				$result = Cms::insert($data1);

				if ($result) {
					Session::flash('success', 'CMS Added Successfully');
					return Redirect::to($this->Url.'/viewcms/legal');
				} else {
					Session::flash('error', 'Failed to update.');
					return Redirect::to($this->Url.'/viewcms/legal');
				}
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function cmsStatus($id) {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 7);
			if ($permission == true) {
				$id = decrypText(strip_tags($id));
				$cms = Cms::where('id', $id)->first();
				$new_status = ($cms->status == "active") ? "deactive" : "active";
				$update = Cms::where('id', $id)->update(['status' => $new_status]);
				if ($update) {
					$new_stat = ($cms->status == "active") ? "Deactivated" : "Activated";
					$msg = "CMS " . $new_stat . " Successfully";
					Session::flash('success', $msg);
				} else {
					Session::flash('error', 'Please Try Again');
				}
				return Redirect::back();
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function cmsEdit($id) {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 7);
			if ($permission == true) {
				$id = decrypText(strip_tags($id));
				$data = Cms::where('id', $id)->first();
				return view('admin.cms.cmsEdit')->with('cms', $data)->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function cmsUpdate() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 7);
			if ($permission == true) {
				$data = Input::all();
				$Validation = Validator::make($data, SubAdmin::$cmsRule);
				if ($Validation->fails()) {
					Session::flash('error', $Validation->messages());
					return Redirect::back();
				}
				if ($data == array_filter($data)) {
					$title = strip_tags($data['title']);
					$content = $data['content'];
					$id = decrypText(strip_tags($data['id']));
					if(isset($_FILES['cms_image']['name'])) {
						if ($_FILES['cms_image']['name'] == "") {
							$image = strip_tags($data['cms_old']);
						} elseif ($_FILES['cms_image']['name'] != "") {
							$fileExtensions = ['jpeg', 'jpg', 'png'];
							$fileName = $_FILES['cms_image']['name'];
							$fileType = $_FILES['cms_image']['type'];
							$explode = explode('.', $fileName);
							$extension = end($explode);
							$fileExtension = strtolower($extension);
							$mimeImage = mime_content_type($_FILES["cms_image"]['tmp_name']);
							$explode = explode('/', $mimeImage);

							if (!in_array($fileExtension, $fileExtensions)) {
								Session::flash('error', 'Invalid file type. Only image files are accepted.');
								return Redirect::back();
							} else {
								if ($explode[0] != "image") {
									Session::flash('error', 'Invalid file type. Only image files are accepted.');
									return Redirect::back();
								}
								$imageUpload = Controller::imageUpload('cms_image', $fileExtensions);
								if ($imageUpload) {
									$image = $imageUpload;
								} else {
									Session::flash('error', 'Error uploading image');
									return Redirect::back();
								}
							}
						}
					} else {
						$image = "";
					}

					if (!empty($data['id'])) {
						$result = Cms::where('id', $id)->update(['title' => $title, 'content' => $content, 'status' => 'active', 'image' => $image]);
					} else {
						$data['id'] = $id;
						$data['title'] = $title;
						$data['content'] = $content;
						$data['image'] = $image;
						$data['status'] = 'active';
						$result = Cms::insert($data);
					}
					if ($result) {
						Session::flash('success', 'CMS Updated Successfully');
					} else {
						Session::flash('error', 'Failed to update.');
					}
					return Redirect::back();
				}
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function viewRoadmap() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 6);
			if ($permission == true) {
				$data = Roadmap::orderBy('id','desc')->get();
				return view('admin.roadmap.roadmap')->with('roadmap_list', $data)->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function roadmapEdit($id = NULL) {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 6);
			if ($permission == true) {
				if ($id != "") {
					$id = decrypText(strip_tags($id));
					$data = Roadmap::where('id', $id)->first();
					$data['type'] = "edit";
				}
				return view('admin.roadmap.roadmapEdit')->with('roadmap', $data)->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function roadmapUpdate() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 6);
			if ($permission == true) {
				$data = Input::all();
				$Validation = Validator::make($data, SubAdmin::$roadmapRule);
				if ($Validation->fails()) {
					Session::flash('error', $Validation->messages());
					return Redirect::to($this->Url.'/viewRoadmap');
				}
				if (!empty($data)) {
					$faq['title'] = strip_tags($data['title']);
					$faq['description'] = $data['description'];
					$faqId = decrypText(strip_tags($data['id']));
					if ($data['id'] != "") {
						$result = Roadmap::where('id', $faqId)->update($faq);
					} else {
						$result = Roadmap::create($faq);
					}
					if ($result) {
						Session::flash('success', 'Roadmap Updated Successfully');
					} else {
						Session::flash('error', 'Failed to update.');
					}
					return Redirect::to($this->Url.'/viewRoadmap');
				}
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	function csv($table){   
       // User List
		if($table == 'userlist'){
			header('Content-type: application/ms-excel');
			header('Content-Disposition: attachment; filename=user_list_' . date('Y-m-d') . '.csv');
			$fp = fopen("php://output", "w");

			$transactions = DB::table(USERINFO)->select('id', 'consumer_name', 'created_at')->orderBy('id', 'desc')->get();
			fputcsv($fp, array("Id", "Username", "Registered Date"));

			if (count($transactions)) {
				$i = 1;
				foreach ($transactions as $res) {
					$td = array($i, $res->consumer_name, $res->created_at);
					fputcsv($fp, $td);
					$i++;
				}
			}
		} 
	}

	public function logout() {
		if (session('adminId') != '') {
			$ip = Controller::getIpAddress();
			$activity['ip_address'] = $ip;
			$activity['browser_name'] = Controller::getBrowser();
			$activity['os'] = Controller::getPlatform();
			$activity['activity'] = "Logged out";
			$activity['admin_id'] = session('adminId');
			AdminActivity::create($activity);
			Session::flush();
			Session::flash('success', 'Logged out!');
			return Redirect::to($this->Url);
		} else {
			Session::flash('error', 'Logged out!');
			return Redirect::to($this->Url);
		}
	}
}