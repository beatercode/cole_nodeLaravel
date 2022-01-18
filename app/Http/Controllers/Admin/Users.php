<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\AdminActivity;
use App\Model\AdminNotification;
use App\Model\BlockIP;
use App\Model\Googleauthenticator;
use App\Model\SiteSettings;
use App\Model\SubAdmin;
use App\Model\User;
use App\Model\UserActivity;
use App\Model\Withdraw;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DateTime;
use DB;
use Mail;
use Redirect;
use Response;
use Session;
use URL;
use Validator;

class Users extends Controller {
	public function __construct() {
		$this->Url = ADMINURL;
	}

	public function viewnewuser() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 1);
			if ($permission == true) {
				$data = 2;
				return view('admin.user.userList')->with('userlist', $data)->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function userList() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 1);
			if ($permission == true) {
				$data = 1;
				return view('admin.user.userList')->with('userlist', $data)->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}
	
	public function userHistory($new) {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 1);
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
					$sort_col = 'consumer_name';
				} else if ($sort_col == '2') {
					$sort_col = 'created_at';
				} else {
					$sort_col = "id";
				}
				if ($sort_type == 'asc') {
					$sort_type = 'desc';
				} else {
					$sort_type = 'asc';
				}
				$data = $orders = $sch = array();
				$userHis = User::where('consumer_name', '!=' , '');
				if ($search != '') {
					$userHis = $userHis->where(function ($q) use ($search) {
						$q->where('consumer_name', 'like', '%' . $search . '%')->orWhere('created_at', 'like', '%' . $search . '%');}
					);
				}

				if ($from_date) {
					$userHis = $userHis->where('updated_at', '>=', date('Y-m-d 00:00:00', strtotime($from_date)));
				}

				if ($to_date) {
					$userHis = $userHis->where('updated_at', '<=', date('Y-m-d 23:59:59', strtotime($to_date)));
				}

				$userHis_count = $userHis->count();
				if ($userHis_count) {

					$userHis = $userHis->select('id', 'consumer_name', 'created_at');

					$orders = $userHis->skip($start)->take($length)->orderBy($sort_col, $sort_type)->get()->toArray();
				}

				$data = array();
				$no = $start + 1;

				if ($userHis_count) {
					foreach ($orders as $r) {
						$userId = encrypText($r['id']);
						$viewUrl = URL::to($this->Url.'/userDetail/'.$userId);
						$viewUser = '<a href="'.$viewUrl.'" class="editUser"><span class="glyphicon glyphicon-eye-open" style="color: #4f5259; vertical-align: middle;" title="View"></span></a>';
						array_push($data, array(
							$no,
							$r['consumer_name'],
							$r['created_at'],
						));
						$no++;
					}
					echo json_encode(array('draw' => intval($draw), 'recordsTotal' => $userHis_count, 'recordsFiltered' => $userHis_count, 'data' => $data));
				} else {
					echo json_encode(array('draw' => intval($draw), 'recordsTotal' => $userHis_count, 'recordsFiltered' => $userHis_count, 'data' => array()));
				}
			} 
		}
	}
}