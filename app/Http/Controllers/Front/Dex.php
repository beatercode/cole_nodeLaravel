<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Model\Currency;
use App\Model\Cms;
use App\Model\Pairs;
use App\Model\Presale;
use App\Model\SiteSettings;
use App\Model\Transactions;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Redirect;
use Session;

class Dex extends Controller {
	public function __construct() {
		$this->site_data = SiteSettings::where('id', '1')->first();
		$this->cms_data = Cms::where('status', 'active')->get();
	}

	public function index() {
		if (session('network') != '' && session('network') == 'ETC') {
			return view('front.liquidity.liquidity')->with('site', $this->site_data)->with('cms', $this->cms_data);
		} else {
			Session::flash('error', 'Please connect to the correct network');
			return Redirect::to('/');
		}
	}

	public function addPair(Request $request) {
		if ($request != '') {
			$pair_address = strip_tags($request['pairaddress']);
			$count = Pairs::where('pair_address', $pair_address)->count();
			if($count > 0) {
				echo 0;exit;
			} else {
				$pair = strip_tags($request['pair']);
				$from_symbol = strip_tags($request['from']);
				$to_symbol = strip_tags($request['to']);
				$from_address = strip_tags($request['from_address']);
				$to_address = strip_tags($request['to_address']);
				$create = array(
					'pair' => $from_symbol.'/'.$to_symbol,
					'pair1' => $from_symbol.'_'.$to_symbol,
					'pair_address' => $pair_address,
					'from_symbol' => $from_symbol,
					'to_symbol' => $to_symbol,
					'from_address' => $from_address,
					'to_address' => $to_address,
					'network' => 'ETC',
					'status' => 1,
					'pair_type' => 1,
					'created_at' => date('Y-m-d H:i:s'),
				);
				Pairs::create($create);
				echo 1;exit;
			}
		}
	}

	public function getPair() {
		$pairs = Pairs::where('status', 1)->where('pair_type', 1)->get();
		echo json_encode($pairs);
	}

	public function addLiquidity() {
		// if (session('network') != '' && session('network') == 'ETC') {
		$network = (session('network') != '') ? session('network') : 'BSC';
		$pairs = Pairs::select('from_symbol', 'to_symbol', 'from_image', 'to_image', 'from_address', 'to_address')->where('pair_type', '1')->where('network', $network)->get();
		if(count($pairs) > 0) {
			return view('front.liquidity.addLiquidity')->with('pairs', $pairs)->with('site', $this->site_data);
		} else {
			Session::flash('error', 'Liquidity pool not available');
			return Redirect::to('/');
		}
		// } else {
		// 	Session::flash('error', 'Please connect to the correct network');
		// 	return Redirect::to('/');
		// }
	}

	public function removeLiquidity($address) {
		if (session('network') != '' && session('network') == 'ETC') {
			return view('front.liquidity.removeLiquidity')->with('pair_address', $address)->with('site', $this->site_data);
		} else {
			Session::flash('error', 'Please connect to the correct network');
			return Redirect::to('/');
		}
	}

	public function swap() {
		if (session('network') != '' && session('network') == 'ETC') {
			return view('front.swap.swap')->with('site', $this->site_data)->with('cms', $this->cms_data);
		} else {
			Session::flash('error', 'Please connect to the correct network');
			return Redirect::to('/');
		}
	}

	public function getCurrency() {
		$pairs = Currency::where('network', session('network'))->get();
		echo json_encode($pairs);
	}

	public function swap_history() {
		return view('front.swap.swapHistory')->with('site', $this->site_data);
	}

	public function staking() {
		// if (session('network') != '') {
		$network = (session('network') != '') ? session('network') : 'BSC';
		$pairs = Pairs::select('from_image', 'to_image', 'from_address', 'to_address', 'pair',  'pair_address', 'pool_id', 'total_rewards', 'status')->where('pair_type', '2')->where('network', $network)->get();
		// if(count($pairs) > 0) {
			return view('front.stake.stake')->with('pairs', $pairs)->with('site', $this->site_data);
		// } else {
		// 	Session::flash('error', 'Staking pool not available');
		// 	return Redirect::to('/');
		// }
		// } else {
		// 	Session::flash('error', 'Choose your network');
		// 	return Redirect::to('/');
		// }
	}

	public function stake_history() {
		return view('front.stake.stakeHistory')->with('site', $this->site_data);
	}

	public function createTransaction(Request $request) {
		if (session('userId') != '') {
			$from = strip_tags($request['from']);
			$to = strip_tags($request['to']);
			$from_amount = strip_tags($request['from_amount']);
			$to_amount = strip_tags($request['to_amount']);
			$from_amt = strip_tags($request['from_amt']);
			$to_amt = strip_tags($request['to_amt']);
			$userAddr = strip_tags($request['userAddr']);
			$transactionHash = strip_tags($request['transactionHash']);
			$transType = strip_tags($request['type']);
			$range = isset($request['range']) ? strip_tags($request['range']) : 0;
			if($transType == 'swap') {
				$from_address = strip_tags($request['from_address']);
				$to_address = strip_tags($request['to_address']);
			} else if($transType == 'buy') {
				$from_address = $to_address = '';
			} else {
				$pairs = Pairs::where('from_symbol', $from)->where('to_symbol', $to)->where('network', session('network'))->select('from_address', 'to_address')->first();
				$from_address = $pairs->from_address;
				$to_address = $pairs->to_address;
			}

			if($transType == 'add') {
				$type = 'AddLiquidity';
				$status = 'active';
				$msg = 'Liquidity added successfully';
			} else if($transType == 'remove') {
				$type = 'RemoveLiquidity';
				$status = 'inactive';
				$msg = 'Liquidity removed successfully';
			} else if($transType == 'swap') {
				$type = 'Swap';
				$status = 'active';
				$msg = 'Swapped successfully';
			} else if($transType == 'deposit') {
				$type = 'Deposit';
				$status = 'active';
				$msg = 'Deposited successfully';
			} else if($transType == 'withdraw') {
				$type = 'Withdraw';
				$status = 'active';
				$msg = 'Withdraw successfully';
			} else if($transType == 'harvest') {
				$type = 'Harvest';
				$status = 'active';
				$msg = 'Harvest successfully';
			} else if($transType == 'buy') {
				$type = 'Buy';
				$status = 'active';
				$msg = 'Buy token was successful';
			}


			$create = array(
				'user' => $userAddr,
				'from_symbol' => $from,
				'to_symbol' => $to,
				'pair' => $from.'/'.$to,
				'pair1' => $from.'_'.$to,
				'from_address' => $from_address,
				'to_address' => $to_address,
				'from_amount' => $from_amount,
				'to_amount' => $to_amount,
				'amount' => $from_amt,
				'price' => $to_amt,
				'txid' => $transactionHash,
				'type' => $type,
				'status' => $status,
				'network' => session('network'),
				'created_at' => date('Y-m-d H:i:s'),
			);
			$result = Transactions::create($create);
			
			if($transType == 'remove' && $range == 100) {
				Transactions::where('from_symbol', $from)->where('to_symbol', $to)->where('type', $type)->where('status', 'active')->update(['status' => 'inactive']);
			}

			if($result) {
				$out = array('status' => 1, 'msg' => $msg);
			} else {
				$out = array('status' => 0, 'msg' => 'Something went wrong');
			}
		} else {
			$out = array('status' => 0, 'msg' => 'Session Expired');
		}
		echo json_encode($out);exit;
	}

	public function transaction_history($type) {
		$id = session('userId');
		if($id != '') {
			$userName = session('userName');
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
			$transHis = Transactions::where('type', $type)->where('user', $userName);
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
					array_push($data, array(
						$r['pair'],
						$r['from_amount'],
						$txId,
						$r['created_at'],
						'Completed',
					));
					$no++;
				}

				echo json_encode(array('draw' => intval($draw), 'recordsTotal' => $transHis_count, 'recordsFiltered' => $transHis_count, 'data' => $data));
			} else {

				echo json_encode(array('draw' => intval($draw), 'recordsTotal' => $transHis_count, 'recordsFiltered' => $transHis_count, 'data' => array()));
			}
		}
	}

	public function presale() {
		$network = (session('network') != '') ? session('network') : 'BSC';
		$site = Presale::where('id', 1)->select('BSC_start_time', 'ETC_start_time', 'BSC_end_time', 'ETC_end_time', 'BSC_tokenprice', 'ETC_tokenprice',  'BSC_price', 'ETC_price')->first();
		$today = date('Y-m-d H:i:s');
		$start_time = ($network == 'BSC') ? $site->BSC_start_time : $site->ETC_start_time;
		$end_time = ($network == 'BSC') ? $site->BSC_end_time : $site->ETC_end_time;
		if(strtotime($start_time) < strtotime($today) && strtotime($end_time) > strtotime($today)) {
			return view('front.common.presale')->with('BSC_tokenprice', $site->BSC_tokenprice)->with('ETC_tokenprice', $site->ETC_tokenprice)->with('BSC_price', $site->BSC_price)->with('ETC_price', $site->ETC_price)->with('site', $this->site_data)->with('cms', $this->cms_data);
		} else {
			Session::flash('error', 'Presale time not yet started or expired');
			return Redirect::to('/');
		}
	}
}