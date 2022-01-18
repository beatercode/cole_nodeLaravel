<?php

namespace App\Http\Controllers;
use App\Model\SiteSettings;
use App\Model\SubAdmin;
use Config;
use DB;
use GeoIp2\Database\Reader;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Mail;
use Redirect;
use Session;
use App;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        $this->Url = ADMINURL;
    }

    public static function checkPermission($id, $per) {
        if ($id != "") {
            $admin = SubAdmin::where('id', $id)->select('admin_permission', 'admin_role')->first();
            if ($admin->admin_role == "admin") {
                return true;
            } else if ($admin->admin_role == "subadmin") {
                $permission = explode(',', strip_tags($admin->admin_permission));
                if (in_array($per, $permission)) {
                    return true;
                } else {
                    Session::flash('error', 'Authorization Failed!');
                    return Redirect::to(ADMINURL)->send();
                }
            }
        } else {
            Session::flash('error', 'Session Expired!');
            return Redirect::to(ADMINURL);
        }
    }

    public static function getIpAddress() {
        $remote = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
        $ip = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $remote;
        return $ip;
    }

    public static function getBrowser() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $browser = "Unknown Browser";
        $browser_array = array('/msie/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/edge/i' => 'Edge',
            '/opera/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i' => 'Handheld Browser');

        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }
        return $browser;
    }

    public static function getPlatform() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $platform = 'Unknown';
        if (preg_match('/linux/i', $user_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $user_agent)) {
            $platform = 'windows';
        }
        return $platform;
    }

    public function imageUpload($attachments, $fileName, $fileExtensions){
        $randcode = randomString(5);
        $filename = SITENAME . $randcode . $fileName;
        $path = $attachments->move(public_path('/IuMzmYaMZE'), $filename);
        return $filename;
    }

    //get url contents
    public static function getContents($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $html = curl_exec($ch);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    //get swift contents
    public static function getSwiftContent($path) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $retValue = curl_exec($ch);
        curl_close($ch);
        return $retValue;
    }

    public function getLocation() {
        $ip = self::getIpAddress();
        try {
            $reader = new Reader(app_path('Model/GeoLite2-City.mmdb'));
            $record = $reader->city($ip);
            $country = $record->country->name;
            $city = ($record->city->name == "") ? $country : $record->city->name;
            $result = $country . "##" . $city;
        } catch (\Exception $e) {
            $result = "India##Madurai";
        }
        return $result;
    }
}
