<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\Currency;
use App\Model\Pairs;
use App\Model\Presale;
use App\Model\SiteSettings;
use App\Model\Transactions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DateTime;
use DB;
use Redirect;
use Response;
use Session;
use URL;
use Validator;

class Dex extends Controller {
	public function __construct() {
		$this->Url = ADMINURL;
	}

	public function connectWallet() {
		if (session('adminId') != '') {
			return view('admin.wallet.connectWallet')->with('redirectUrl', $this->Url);
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function unlockWallet(Request $request) {
		$address = strtolower(strip_tags($request['address']));
		$type = strip_tags($request['type']);
		if ($address != "") {
			$length = strlen($address);
			if ($length == 42) {
				session(['adminMetaName' => $address, 'adminNetwork' => 'BSC']);
				echo "success";
			} else {
				echo "Invalid address!";
			}
		} else {
			echo "Invalid address!";
		}
	}

	public function saveAdminNetwork(Request $request) {
		if (session('adminId') != '') {
			$network = strip_tags($request['network']);
			if ($network != "") {
				$userId = session('userId');
				$chainId = array('BSC' => 56, 'ETC' => 61);
				$chainHexId = array('BSC' => '0x38', 'ETC' => '0x3D');
				$id = $chainId[$network];
				$hex = $chainHexId[$network];
				session(['adminNetwork' => $network, 'adminchainId' => $id, 'adminchainHexId' =>$hex]);
				echo 1;
			} else {
				echo 0;
			}
		} else {
			echo 0;
		}
	}

	public function viewPairs() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 2);
			if ($permission == true) {
				$pairs = Pairs::select('id', 'pair', 'status')->get();
				return view('admin.pairs.pairs')->with('pairs', $pairs)->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		} else {
			return view('admin.common.login')->with('redirectUrl', $this->Url);
		}
	}

	public function pairHistory($nw_type, $pair_type) {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 2);
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
					$sort_col = 'network';
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
				$pairHis = Pairs::where('network', $nw_type)->where('pair_type', $pair_type);
				if ($search != '') {
					$pairHis = $pairHis->where(function ($q) use ($search) {
						$q->where('pair', 'like', '%' . $search . '%')->orWhere('created_at', 'like', '%' . $search . '%');}
					);
				}

				if ($from_date) {
					$pairHis = $pairHis->where('updated_at', '>=', date('Y-m-d 00:00:00', strtotime($from_date)));
				}

				if ($to_date) {
					$pairHis = $pairHis->where('updated_at', '<=', date('Y-m-d 23:59:59', strtotime($to_date)));
				}

				$pairHis_count = $pairHis->count();
				if ($pairHis_count) {

					$pairHis = $pairHis->select('id', 'pair', 'status');

					$orders = $pairHis->skip($start)->take($length)->orderBy($sort_col, $sort_type)->get()->toArray();
				}

				$data = array();
				$no = $start + 1;

				if ($pairHis_count) {
					foreach ($orders as $r) {
						$pairId = encrypText($r['id']);
						$statusUrl = URL::to($this->Url.'/pairStatus/'.$pairId);
						$editUrl = URL::to($this->Url.'/pairEdit/'.$pairId);
						$removeImg = URL::to('public/AVKpqBqmVJ/images/remove-user-icon.png');
						$editImg = URL::to('public/AVKpqBqmVJ/images/edit-icon.png');
						if ($r['status'] == "1") {
							$staCls = "clsActive"; $sta = 'Active';
						} else {
							$staCls = "clsDeactive"; $sta = 'Inactive'; 
						}
						$status = '<a href="#" class="clsCtlr '.$staCls.'">'.$sta.'</a>';
						$changeStatus = '<a href="'.$statusUrl.'" class="userRemove"><img src="'.$removeImg.'" title="Remove" /></a>';
						$edit = '<a href="'.$editUrl.'" class="editUser"><img src="'.$editImg.'" title="Edit"  /></a>';
						array_push($data, array(
							$no,
							$r['pair'],
							$status,
							$changeStatus.' '.$edit,
						));
						$no++;
					}
					echo json_encode(array('draw' => intval($draw), 'recordsTotal' => $pairHis_count, 'recordsFiltered' => $pairHis_count, 'data' => $data));
				} else {
					echo json_encode(array('draw' => intval($draw), 'recordsTotal' => $pairHis_count, 'recordsFiltered' => $pairHis_count, 'data' => array()));
				}
			} 
		}
	}

	public function pairEdit($id = '') {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 2);
			if ($permission == true) {
				if ($id != "") {
					$id = decrypText(strip_tags($id));
					$data = Pairs::where('id', $id)->first();
					$data['type'] = "edit";
					return view('admin.pairs.pairEdit')->with('pair', $data)->with('redirectUrl', $this->Url);
				} else {
					if(session('adminMetaName') != '') {
						$data['pair'] = "";
						$data['type'] = 'add';
						return view('admin.pairs.pairAdd')->with('redirectUrl', $this->Url);
					} else {
						Session::flash('error', 'Please connect metamask');
						return Redirect::back();
					}
				}
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function updatePair() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 2);
			if ($permission == true) {
				$adminId = session('adminId');
				$data = Input::all();
				$id = decrypText($data['id']);
				$from_symbol = $data['from_symbol'];
				$to_symbol = $data['to_symbol'];
				if ($_FILES['from_image']['name'] == "") {
					$from_image = strip_tags($data['from_image_old']);
				} else if ($_FILES['from_image']['name'] != "") {
					$fileExtensions = ['jpeg', 'jpg', 'png', 'svg'];
					$fileName = $_FILES['from_image']['name'];
					$fileType = $_FILES['from_image']['type'];
					$explode = explode('.', $fileName);
					$extension = end($explode);
					$fileExtension = strtolower($extension);
					$mimeImage = mime_content_type($_FILES["from_image"]['tmp_name']);
					$explode = explode('/', $mimeImage);

					if (!in_array($fileExtension, $fileExtensions)) {
						Session::flash('error', 'Invalid file type. Only image files are accepted.');
						return Redirect::to($this->Url.'/viewPairs');
					} else {
						if ($explode[0] != "image") {
							Session::flash('error', 'Invalid file type. Only image files are accepted.');
							return Redirect::to($this->Url.'/viewPairs');
						}
						$imageUpload = Controller::imageUpload($data['from_image'], $fileName, $fileExtensions);
						if ($imageUpload) {
							$from_image = $imageUpload;
						} else {
							Session::flash('error', 'Error uploading image');
							return Redirect::to($this->Url.'/viewPairs');
						}
					}
				}
				if ($_FILES['to_image']['name'] == "") {
					$to_image = strip_tags($data['to_image_old']);
				} else if ($_FILES['to_image']['name'] != "") {
					$fileExtensions = ['jpeg', 'jpg', 'png', 'ico'];
					$fileName = $_FILES['to_image']['name'];
					$fileType = $_FILES['to_image']['type'];
					$explode = explode('.', $fileName);
					$extension = end($explode);
					$fileExtension = strtolower($extension);
					$mimeImage = mime_content_type($_FILES["to_image"]['tmp_name']);
					$explode = explode('/', $mimeImage);

					if (!in_array($fileExtension, $fileExtensions)) {
						Session::flash('error', 'Invalid file type. Only image files are accepted.');
						return Redirect::to($this->Url.'/viewPairs');
					} else {
						if ($explode[0] != "image") {
							Session::flash('error', 'Invalid file type. Only image files are accepted.');
							return Redirect::to($this->Url.'/viewPairs');
						}
						$imageUpload = Controller::imageUpload($data['to_image'], $fileName, $fileExtensions);
						if ($imageUpload) {
							$to_image = $imageUpload;
						} else {
							Session::flash('error', 'Error uploading image');
							return Redirect::to($this->Url.'/viewPairs');
						}
					}
				}

				$upData = array(
					'from_image' => $from_image,
					'to_image' => $to_image,
				);
				$result = Pairs::where('id', $id)->update($upData);
				$fromCur = Currency::where('symbol', $from_symbol)->count();
				if($fromCur) {
					Currency::where('symbol', $from_symbol)->update(['image' => $from_image]);
				}
				$toCur = Currency::where('symbol', $to_symbol)->count();
				if($toCur) {
					Currency::where('symbol', $to_symbol)->update(['image' => $to_image]);
				}
				if ($result) {
					Session::flash('success', 'Image Updated Successfully');
				} else {
					Session::flash('error', 'Failed to update.');
				}
				return Redirect::back();
			}
		}
		Session::flash('error', 'Session Expired');
		return Redirect::to($this->Url);
	}

	public function createPair(Request $request) {
		if ($request != "") {
			$permission = Controller::checkPermission(session('adminId'), 2);
			if ($permission == true) {
				$fromAddr = strip_tags($request['fromAddr']);
				$toAddr = strip_tags($request['toAddr']);
				$pairAddr = strip_tags($request['pairAddr']);
				$fromSymbol = strip_tags($request['fromSymbol']);
				$toSymbol = strip_tags($request['toSymbol']);
				$poolLimit = isset($request['poolLimit']) ? strip_tags($request['poolLimit']) : 0;
				$transactionHash = strip_tags($request['transactionHash']);
				$pair_type = strip_tags($request['pair_type']);
				$count = Pairs::where('pair_address', $pairAddr)->count();
				if($count == 0) {
					$create = array(
						'pair' => $fromSymbol.'/'.$toSymbol,
						'pair1' => $fromSymbol.'_'.$toSymbol,
						'pair_address' => $pairAddr,
						'from_symbol' => $fromSymbol,
						'to_symbol' => $toSymbol,
						'from_address' => $fromAddr,
						'to_address' => $toAddr,
						'pool_limit' => $poolLimit,
						'status' => 1,
						'pair_type' => $pair_type,
						'txid' => $transactionHash,
						'network' => session('adminNetwork'),
					);
					Pairs::create($create);
					echo 1;exit;
				} else {
					echo 0;exit;
				}
			} else {
				echo 0;exit;
			}
		} else {
			echo 0;exit;
		} 
	}

	public function addStakingPair(Request $request) {
		if ($request != "") {
			$permission = Controller::checkPermission(session('adminId'), 2);
			if ($permission == true) {
				$stakeId = decrypText(strip_tags($request['stakeId']));
				$data = Pairs::where('id', $stakeId)->first();
				if($data) {
					$transactionHash = strip_tags($request['transactionHash']);
					$poolId = strip_tags($request['poolId']);
					Pairs::where('id', $stakeId)->update(['stake_status' => 1, 'txid' => $transactionHash, 'pool_id' => $poolId]);
					echo 1;exit;
				} else {
					echo 0;exit;
				}
			} else {
				echo 0;exit;
			}
		} else {
			echo 0;exit;
		} 
	}

	public function staking_history() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 2);
			if ($permission == true) {
				return view('admin.transaction.stake')->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		} else {
			return view('admin.common.login')->with('redirectUrl', $this->Url);
		}
	}

	public function swap_history() {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 2);
			if ($permission == true) {
				return view('admin.transaction.swap')->with('redirectUrl', $this->Url);
			} else {
				Session::flash('error', 'Permission Denied!');
				return Redirect::to($this->Url);
			}
		} else {
			return view('admin.common.login')->with('redirectUrl', $this->Url);
		}
	}

	public function transaction_history($type) {
		if (session('adminId') != '') {
			$permission = Controller::checkPermission(session('adminId'), 2);
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
					$sort_col = 'pair';
				} else if ($sort_col == '2') {
					$sort_col = 'from_amount';
				} else if ($sort_col == '3') {
					$sort_col = 'txid';
				} else if ($sort_col == '4') {
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
				$transHis = Transactions::where('type', $type);
				if ($search != '') {
					$transHis = $transHis->where(function ($q) use ($search) {
						$q->where('pair', 'like', '%' . $search . '%')->orWhere('from_amount', 'like', '%' . $search . '%')->orWhere('txid', 'like', '%' . $search . '%')->orWhere('created_at', 'like', '%' . $search . '%');}
					);
				}

				if ($from_date) {
					$transHis = $transHis->where('updated_at', '>=', date('Y-m-d 00:00:00', strtotime($from_date)));
				}

				if ($to_date) {
					$transHis = $transHis->where('updated_at', '<=', date('Y-m-d 23:59:59', strtotime($to_date)));
				}

				$transHis_count = $transHis->count();
				if ($transHis_count) {

					$transHis = $transHis->select('pair', 'from_amount', 'txid', 'network', 'created_at');

					$orders = $transHis->skip($start)->take($length)->orderBy($sort_col, $sort_type)->get()->toArray();
				}

				$data = array();
				$no = $start + 1;

				$txUrl = array(
					'BSC' => 'https://testnet.bscscan.com/tx/',
					'ETC' => 'https://rinkeby.etherscan.io/tx/',
				);

				if ($transHis_count) {
					foreach ($orders as $r) {
						$txid = substr($r['txid'], 0, 10);
						$network = $r['network'];
						$redirect = $txUrl[$network] . $r['txid'];
						$txId = '<a href="' . $redirect . '" target="_blank">' . $txid . '...</a>';
						$status = '<a href="#" class="clsCtlr clsActive">Completed</a>';
						array_push($data, array(
							$no,
							$r['pair'],
							$r['from_amount'],
							$txId,
							$r['created_at'],
							$status,
						));
						$no++;
					}

					echo json_encode(array('draw' => intval($draw), 'recordsTotal' => $transHis_count, 'recordsFiltered' => $transHis_count, 'data' => $data));
				} else {

					echo json_encode(array('draw' => intval($draw), 'recordsTotal' => $transHis_count, 'recordsFiltered' => $transHis_count, 'data' => array()));
				}
			}
		}
	}

	public function presale() {
		if (session('adminId') != '') {
			if(session('adminMetaName') != '') {
				$permission = Controller::checkPermission(session('adminId'), 2);
				if ($permission == true) {
					$network = session('adminNetwork');
					$presale = Presale::where('id', 1)->select($network.'_start_time', $network.'_end_time', $network.'_price', $network.'_token', $network.'_min', $network.'_max', $network.'_usdprice')->first();
					$start_time = (session('adminNetwork') == 'BSC') ? $presale->BSC_start_time : $presale->ETC_start_time;
					$end_time = (session('adminNetwork') == 'BSC') ? $presale->BSC_end_time : $presale->ETC_end_time;
					$equiv_usdPrice = (session('adminNetwork') == 'BSC') ? $presale->BSC_price : $presale->ETC_price;
					$token = (session('adminNetwork') == 'BSC') ? $presale->BSC_token : $presale->ETC_token;
					$min = (session('adminNetwork') == 'BSC') ? $presale->BSC_min : $presale->ETC_min;
					$max = (session('adminNetwork') == 'BSC') ? $presale->BSC_max : $presale->ETC_max;
					$usd_price = (session('adminNetwork') == 'BSC') ? $presale->BSC_usdprice : $presale->ETC_usdprice;
					$data['startdatetime'] = date('m/d/Y H:i:s', strtotime($start_time));
					$data['enddatetime'] = date('m/d/Y H:i:s', strtotime($end_time));
					$data['token'] = $token;
					$data['min'] = $min;
					$data['max'] = $max;
					$data['usd_price'] = $usd_price;
					$data['equiv_usdPrice'] = $equiv_usdPrice;
					return view('admin.presale.presale')->with('redirectUrl', $this->Url)->with('presale', $data);
				} else {
					Session::flash('error', 'Permission Denied!');
					return Redirect::to($this->Url);
				}
			} else {
				Session::flash('error', 'Please connect metamask');
				return Redirect::back();
			}			
		} else {
			return view('admin.common.login')->with('redirectUrl', $this->Url);
		}
	}

	public function setpresaleTime(Request $request) {
		if ($request != "") {
			if(session('adminMetaName') != '') {
				$permission = Controller::checkPermission(session('adminId'), 2);
				if ($permission == true) {
					$network = session('adminNetwork');
					$start = strip_tags($request['start']);
					$end = strip_tags($request['end']);
					$startdatetime = date('Y-m-d H:i:s', $start);
					$enddatetime = date('Y-m-d H:i:s', $end);
					$update = Presale::where('id', 1)->update([$network.'_start_time' => $startdatetime, $network.'_end_time' => $enddatetime]);
					if($update) {
						echo 1; exit;
					} else {
						echo 0;exit;
					}
				} else {
					echo 0;exit;
				}
			} else {
				echo 0;exit;
			}
		}
	}

	public function setpresalePrice(Request $request) {
		if ($request != "") {
			if(session('adminMetaName') != '') {
				$permission = Controller::checkPermission(session('adminId'), 2);
				if ($permission == true) {
					$network = session('adminNetwork');
					$token = strip_tags($request['token']);
					$price = strip_tags($request['price']);
					$update = Presale::where('id', 1)->update([$network.'_token' => $token, $network.'_usdprice' => $price]);
					if($update) {
						echo 1; exit;
					} else {
						echo 0;exit;
					}
				} else {
					echo 0;exit;
				}
			} else {
				echo 0;exit;
			}
		}
	}

	public function setMinmax(Request $request) {
		if ($request != "") {
			if(session('adminMetaName') != '') {
				$permission = Controller::checkPermission(session('adminId'), 2);
				if ($permission == true) {
					$network = session('adminNetwork');
					$min = strip_tags($request['min']);
					$max = strip_tags($request['max']);
					$update = Presale::where('id', 1)->update([$network.'_min' => $min, $network.'_max' => $max]);
					if($update) {
						echo 1; exit;
					} else {
						echo 0;exit;
					}
				} else {
					echo 0;exit;
				}
			} else {
				echo 0;exit;
			}
		}
	}

	public function disconnectWallet() {
		if (session('adminId') != '') {
			session()->forget('adminMetaName');
			session()->forget('adminNetwork');
			Session::flash('success', 'Disconnected successfully');
			return Redirect::to($this->Url);
		} else {
			Session::flash('error', 'Logged out!');
			return Redirect::to($this->Url);
		}
	}
}