<?php

namespace App\Model;
use DateTime;
use DateTimeZone;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
	use Notifiable;

	protected $table = 'PEpdZuqEcB_us';

	protected $guarded = [];

	public static function randomString($length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public static function randomReferNumber($length) {
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	//validation rules

	public static $adminLoginRule = array(
		'username' => array('required', 'email', 'indisposable'),
		'user_pwd' => 'required',
		'pattern_code' => 'required',
	);

	public static $userSignupRule = array(
		'user_name' => 'required',
		'email' => array('required', 'email', 'unique_email', 'indisposable'),
		'pwd' => 'required',
		'confirm_pwd' => 'required',
	);

	public static $userSignupMsg = array(
		'email.unique_email' => "Email address already exits",
		'email.email' => "Enter valid email",
	);

	public static $userLoginRule = array(
		'email' => array('required', 'email','indisposable'),
		'password' => 'required',
	);

	public static $forgotRule = array(
		'email' => array('required', 'indisposable'),
	);

	public static $resetRule = array(
		'pwd' => 'required',
		'confirm_pwd' => 'required',
	);

	public static $passwordRule = array(
		'new_pwd' => 'required',
		'cnfirm_pwd' => 'required',
	);

	public static $changePasswordRule = array(
		'current_pwd' => 'required',
		'new_pwd' => 'required',
		'confirm_pwd' => 'required',
	);

	public static $profileRule = array(
		'firstname' => 'required',
		'lastname' => 'required',
		'phone' => 'required',
		'address' => 'required',
		'city' => 'required',
		'dob' => 'required',
		'country' => 'required',
	);

	//get site details for footer
	public static function getSiteDetails() {
		$getSiteDetails = SiteSettings::where('id', 1)->select('contact_email', 'contact_number', 'contact_address', 'city', 'state', 'country', 'fb_url', 'twitter_url', 'linkedin_url', 'googleplus_url', 'copy_right_text', 'skype_id')->first();
		return $getSiteDetails;
	}

	//get site logo for header
	public static function getSiteLogo() {
		$getSiteDetails = SiteSettings::where('id', 1)->select('site_logo', 'site_favicon')->first();
		return $getSiteDetails;
	}

	//get copy right for footer
	public static function getCopyRight() {
		$getSiteDetails = SiteSettings::where('id', 1)->select('copy_right_text')->first();
		return $getSiteDetails;
	}

	//get footer content and image
	public static function getStaticContent($id) {
		$getSiteDetails = Cms::where('id', $id)->first();
		return $getSiteDetails;
	}

	//Associations
	//associte with user activities
	public function activity() {
		return $this->hasMany('App\Model\UserActivity');
	} 

	public static function getlanguage($var) {
		if ($var != '') {
			$languages = Session::get('languagefiles');
			if (isset($languages[$var])) {
				return $languages[$var];
			} else {
				return $var;
			}
		} else {
			return '';
		}
	}

	public static function getLocalTime($time, $fromTz = 'UTC', $toTz = 'Asia/Kolkata') {
		$date = new DateTime($time, new DateTimeZone($fromTz));
		$date->setTimezone(new DateTimeZone($toTz));
		$time = $date->format('Y-m-d H:i:s');
		return $time;
	}

}
