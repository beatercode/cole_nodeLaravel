<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubAdmin extends Model {
	protected $table = 'PEpdZuqEcB_sub';

	protected $guarded = [];

	public static $faqRule = array(
		'question' => 'required',
		'description' => 'required',
	);

	public static $cmsRule = array(
		'title' => 'required',
		'content' => 'required',
	);

	public static $roadmapRule = array(
		'title' => 'required',
		'description' => 'required',
	);

	public static $metaRule = array(
		'title' => 'required',
		'meta_keywords' => 'required',
		'meta_description' => 'required',
	);

	public static $profileRule = array(
		'admin_username' => 'required',
		'admin_phno' => 'required',
		'admin_address' => 'required',
		'admin_city' => 'required',
		'admin_state' => 'required',
		'admin_postal' => 'required',
		'country' => 'required',
	);

	public static $pwdRule = array(
		'current_pwd' => 'required',
		'new_pwd' => 'required|min:8',
		'confirm_pwd' => 'required|min:8',
	);

	public static $siteRule = array(
		'site_name' => 'required',
		'contact_no' => 'required',
		'contact_address' => 'required',
		'city' => 'required',
		'state' => 'required',
		'country' => 'required',
		'copy_right_text' => 'required',
		'tele_url' => 'required',
		'twitter_url' => 'required',
		'medium_url' => 'required',
		'postal' => 'required',
	);

	public static $addSubadminRule = array(
		'username' => 'required',
		'email_addr' => array('required', 'email'),
		'pattern_code' => 'required',
		'permission' => 'required',
	);

	public static $emailRule = array(
		'name' => 'required',
		'subject' => 'required',
		'template' => 'required',
	);
	
	public static function getProfile($id) {
		$profilePicture['admin'] = SubAdmin::where('id', $id)
			->select('admin_profile', 'admin_username')->first();
		return $profilePicture;
	}

	public static function getPermission($id) {
		$permission = SubAdmin::where('id', $id)->select('admin_permission')->first();
		return $permission->admin_permission;
	}

	public static function getNotificationCount() {
		$count = AdminNotification::where('status', 'unread')->count();
		return $count;
	}

	public static function getAdminNotifcation() {
		$result = AdminNotification::orderBy('id', 'desc')->limit(10)->get();
		if ($result->isEmpty()) {
			return "";
		} else {
			return $result;
		}
	}

	public static function getTimeAgo($date_time) {
		$date2 = date_create(date('Y-m-d H:i:s'));
		$date1 = date_create($date_time);
		$diff = date_diff($date1, $date2);

		$left = '0 sec ago';
		$sec = 'sec ago';
		$min = 'mins ago';
		$hur = 'hours ago';
		$day = 'days ago';
		$mon = 'months ago';
		$yer = 'years ago';

		if ($date1 < $date2) {
			if ($diff->s != 0) {
				$left = $diff->s . ' ' . $sec;
			}

			if ($diff->i != 0) {
				$left = $diff->i . ' ' . $min;
			}

			if ($diff->h != 0) {
				$left = $diff->h . ' ' . $hur;
			}

			if ($diff->d != 0) {
				$left = $diff->d . ' ' . $day;
			}

			if ($diff->m != 0) {
				$left = $diff->m . ' ' . $mon;
			}

			if ($diff->y != 0) {
				$left = $diff->y . ' ' . $yer;
			}

		}
		return $left;
	}

}
