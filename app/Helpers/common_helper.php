<?php

use App\Models\Cart;
use App\Models\General\Country;
use App\Models\General\State;
use App\Models\Wishlist;
use Illuminate\Support\Facades\DB;

if (!function_exists('get_settings')) {
    function get_settings($key = '')
    {
        return DB::table('settings')->where('key', $key)->first()->value ?? null;
    }
}

if (!function_exists('get_frontend_settings')) {
    function get_frontend_settings($key = '')
    {
        return DB::table('frontend_settings')->where('key', $key)->first()->value ?? null;
    }
}

if (!function_exists('csvToArray')) {
    function csvToArray($filename = '', $delimiter = ',')
    {

        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, null, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else
                if (count(array_map('strtolower', $header)) != count($row)) {
                    dd(array_map('strtolower', $header), $row);
                }
                $data[] = array_combine(array_map('strtolower', $header), $row);
            }
            fclose($handle);
        }

        return $data;
    }
}

if (!function_exists('check')) {
    function check($table, $column, $code)
    {
        if (DB::table($table)->where($column, $code)->exists()) {
            return 0;
        } else {
            return 1;
        }
    }
}

if (!function_exists('unique')) {
    function unique($table, $column, $length, $type = 'alphanumeric')
    {
        $code = $type == 'int' ? substr(str_shuffle('0123456789'), 0, $length) : \Str::random($length);
        if (check($table, $column, $code) == 1) {
            return $code;
        } else {
            unique($table, $column, $length, $type);
        }
    }
}

function uniqueUserToken($table, $column, $length)
{
    $code = substr(sha1(microtime()), 0, $length);
    if (check($table, $column, sha1($code)) == 1) {
        return $code;
    } else {
        uniqueUserToken($table, $column, $length);
    }
}

if (!function_exists('slugify')) {
    function slugify($text)
    {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        //$text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}

if (!function_exists('get_video_extension')) {
    // Checks if a video is youtube, vimeo or any other
    function get_video_extension($url)
    {
        if (strpos($url, '.mp4') > 0) {
            return 'mp4';
        } elseif (strpos($url, '.webm') > 0) {
            return 'webm';
        } else {
            return 'unknown';
        }
    }
}

if (!function_exists('ellipsis')) {
    // Checks if a video is youtube, vimeo or any other
    function ellipsis($long_string, $max_character = 30)
    {
        $short_string = strlen($long_string) > $max_character ? substr($long_string, 0, $max_character) . "..." : $long_string;
        return $short_string;
    }
}

if (!function_exists('trimmer')) {
    function trimmer($text)
    {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}

// RANDOM NUMBER GENERATOR FOR ELSEWHERE
if (!function_exists('random')) {
    function random($length_of_string)
    {
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shufle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }
}

// RANDOM NUMBER GENERATOR FOR ELSEWHERE
if (!function_exists('phpFileUploadErrors')) {
    function phpFileUploadErrors($error_code)
    {
        $phpFileUploadErrorsArray = array(
            0 => 'There is no error, the file uploaded with success',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk.',
            8 => 'A PHP extension stopped the file upload.',
        );
        return $phpFileUploadErrorsArray[$error_code];
    }
}

if (!function_exists('full_url')) {
    function full_url()
    {
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        return preg_replace('/\/\d+/', '', $url);
    }
}

if (!function_exists('get_offset')) {
    function get_offset()
    {
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        preg_match('/\/\d+/', $url, $match);
        return isset($match[0]) ? str_replace('/', '', $match[0]) : "";
    }
}

if (!function_exists('get_plural')) {
    function get_plural($count, $word)
    {
        $str = new Str();
        return $str->plural($count, $word);
    }
}

if (!function_exists('get_pluralize')) {
    function get_pluralize($count, $word)
    {
        $str = new Str();
        return $str->pluralize_if($count, $word);
    }
}

function get_ip()
{
    $ipAddress = '';
    
    switch (true) {
        case !empty($_SERVER['HTTP_CLIENT_IP']):
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
            break;
        
        case !empty($_SERVER['HTTP_X_FORWARDED_FOR']):
            $ipAddressList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($ipAddressList as $ip) {
                if (!empty($ip)) {
                    $ipAddress = $ip;
                    break;
                }
            }
            break;
        
        case !empty($_SERVER['HTTP_X_FORWARDED']):
            $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
            break;
        
        case !empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']):
            $ipAddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
            break;
        
        case !empty($_SERVER['HTTP_FORWARDED_FOR']):
            $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
            break;
        
        case !empty($_SERVER['HTTP_FORWARDED']):
            $ipAddress = $_SERVER['HTTP_FORWARDED'];
            break;
        
        case !empty($_SERVER['REMOTE_ADDR']):
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            break;
    }
    
    return $ipAddress;
}

function compressImage($source_url, $destination_url, $quality = 40)
{
    $info = getimagesize($source_url);

    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source_url);
    } elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($source_url);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source_url);
    }

    //save file
    imagejpeg($image, $destination_url, $quality);

    //return destination file
    return $destination_url;
}

function is_slug($str)
{
    return preg_match('/^[a-z][-a-z0-9]*$/', $str);
}


function fileExtension($file)
{
    $tmp = explode('.', $file);
    $fileExtension = strtolower(end($tmp));
    return $fileExtension;
}


function csv_file($columns, $data, string $filename = 'export')
{
    $file      = fopen('php://memory', 'wb');
    $csvHeader = [...$columns];

    fputcsv($file, $csvHeader);

    foreach ($data as $line) {
        fputcsv($file, $line);
    }

    fseek($file, 0);

    $uid = uniqid();

    \Storage::disk('local')->put("public/$uid", $file);

    return response()->download(storage_path('app/public/'.$uid), $filename)->deleteFileAfterSend(true);

}

function cleanCsvValue($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

if (!function_exists('wish_num')) {
    function wish_num($userId = null, $ip = null)
    {
        return $userId ?
            Wishlist::where('user_id', $userId)->orWhere('ip',$ip)->count() :
            Wishlist::where('ip', $ip)->count();
    }
}

if (!function_exists('cart_num')) {
    function cart_num($userId, $ip)
    {
        return Cart::where('is_ordered', false)->where(function ($query) use ($userId, $ip) {
            $query->where('user_id', $userId)
                ->orWhere('ip', $ip);
        })->sum('quantity');
    }
}

if (!function_exists('state_name')) {
    function state_name($stateId)
    {
        return State::find($stateId)?->state ?? State::find(State::DEFAULT)->state;
    }
}

if (!function_exists('country_name')) {
    function country_name($countryId)
    {
        return Country::find($countryId)?->country ?? Country::find(Country::DEFAULT)->country;
    }
}

if (!function_exists('is_in_wish_list')) {
    function is_in_wish_list($productId, $userId = null, $ip = null)
    {
       if($userId){
            return Wishlist::where('product_id', $productId)
                ->where('user_id', $userId)
                ->count();
        } else {
            return Wishlist::where('product_id', $productId)
                ->where(function ($query) use ($userId, $ip) {
                    $query->where('user_id', $userId)
                        ->orWhere('ip', $ip);
                })->count();
        }
    }
}

if (!function_exists('sizes_array')) {
    function sizes_array()
    {
        return [
            "XS","S","M","L","XL","XXL",
            35,35.5,36,36.5,37,37.5,38,
            38.5,39,39.5,40,40.5,41,41.5,
            42,42.5,43,43.5,44,44.5,45,
            45.5
        ]; 
    }
}

if (!function_exists('check_multi')) {
    function check_multi($needle, $haystack, $field){
        $key = array_search($needle, array_column($haystack, $field ));
        return $key;
    }
}

if(!function_exists('past_tense'))
{
    function past_tense($word)
    {
        if (preg_match('/e$/i', $word)) {
            return $word . 'd';
        } elseif (preg_match('/y$/i', $word)) {
            return preg_replace('/y$/i', 'ied', $word);
        } else {
            return $word . 'ed';
        }
    }
}

if(!function_exists('file')){
    function file($txt,$path,$base="assets/"){
		if($_FILES[$txt]["error"] == 0){
		    $photo=$path.sha1(microtime().rand(0,100)).$_FILES[$txt]['name'];
		    move_uploaded_file($_FILES[$txt]['tmp_name'], $base.$photo);
	       
	    }else{
	    	$photo=""; 
	    }
		
		return $photo;
	}
}

if(!function_exists('photo')){
    function photo($txt,$path,$base="assets/"){
        if($_FILES[$txt]["error"] == 0){
            $types = array('image/jpeg','image/gif','image/png','image/webp');
            if (in_array($_FILES[$txt]['type'], $types)==1) {
                $photo=$path.sha1(microtime().rand(0,100)).$_FILES[$txt]['name'];
                move_uploaded_file($_FILES[$txt]['tmp_name'], $base.$photo);
            }else{
                $photo="";
            }
        }else{
            $photo=""; 
        }
        
        return $photo;
    }
}