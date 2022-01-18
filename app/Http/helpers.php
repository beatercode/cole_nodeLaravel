<?php
use App\Model\Cms;
use App\Model\SiteSettings;
use App\Model\User;

function encrypText($string) {
	$encrypt_method = "AES-256-CBC";
	$secret_key = 'CHSWHQSJFwuPByMmkaNhsqaJSgT';
	$secret_iv = 'PdRDAVMUstTDKjshfQymUDzEQtp';
	$key = hash('sha256', $secret_key);
	$iv = substr(hash('sha256', $secret_iv), 0, 16);
	$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	$output = base64_encode($output);
	return $output;
}

function decrypText($string) {
	$encrypt_method = "AES-256-CBC";
	$secret_key = 'CHSWHQSJFwuPByMmkaNhsqaJSgT';
	$secret_iv = 'PdRDAVMUstTDKjshfQymUDzEQtp';
	$key = hash('sha256', $secret_key);
	$iv = substr(hash('sha256', $secret_iv), 0, 16);
	$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	return $output;
}

function getLocalTime($time, $fromTz = 'UTC', $toTz = 'Asia/Kolkata') {
	$date = new DateTime($time, new DateTimeZone($fromTz));
	$date->setTimezone(new DateTimeZone($toTz));
	$time = $date->format('Y-m-d H:i:s');
	return $time;
}

//To get random referal string
function randomString($length) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function randomInteger($length) {
	$characters = '0123456789';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function randomcode($length) {
	$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomcode = substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
	return $randomcode;
}

function coingecko($name) {
	$price = 0;
	$url = "https://api.coingecko.com/api/v3/simple/price?ids=" . $name . "&vs_currencies=usd";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$output = curl_exec($ch);
	curl_close($ch);
	$output = json_decode($output, true);
	if (!empty($output[$name])) {
		$price = 1 / $output[$name]['usd'];
	}
	return $price;
}

function coinmarket($from, $token) {
	$result['tokenPrice'] = $result['usdPrice'] = 0;
	$apiKey = decrypText(COINMARKETCAP);
	$to = "USD";
	$cmc_url = "https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?CMC_PRO_API_KEY=" . $apiKey . "&symbol=" . $from . "&convert=" . $to;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $cmc_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$output = curl_exec($ch);
	curl_close($ch);
	$response = json_decode($output);
	if (isset($response->data) && $response->status->credit_count == 1) {
		$preres = $response->data->$from->quote->$to;
		$result['usdPrice']   = $usdPrice = $preres->price;
		$result['tokenPrice'] =  1 / $token;
	}
	return $result;
}