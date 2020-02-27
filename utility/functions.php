<?php
//Check if user is loggedin
//TODO: Set actual session parameters
function login()
{
    if(isset($_SESSION['uname']) || isset($_COOKIE['cookie_uname']))
        return true;

    return false;
}

//Do all necessary session start stuff
function StartSession()
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    //Cookie checks
    if(isset($_COOKIE['cookie_uname']) && !isset($_SESSION['uname']))
    {
        $_SESSION['uname'] = $_COOKIE['cookie_uname'];
        $_SESSION['type'] = $_COOKIE['cookie_type'];

        //$_SESSION['name'] = $_COOKIE['cookie_name'];
        //$_SESSION['email'] = $_COOKIE['cookie_email'];
        //$_SESSION['admin'] = $_COOKIE['cookie_admin'];
    }

    //require_once($_SERVER['DOCUMENT_ROOT'].'/WebShop/utility/Classes/CPicture.php');
    //require_once($_SERVER['DOCUMENT_ROOT'].'/WebShop/utility/Classes/CUser.php');
}

//Check if user is administrator
//TODO: vielleicht nicht als session variable speichern, sondern mit datenbankabfrage
function isAdmin()
{   
    if(isset($_SESSION["type"])){
        if($_SESSION["type"] == "1"){
             return TRUE;
        }
    }
    return FALSE;
}

//Check if user is lektor
//TODO: vielleicht nicht als session variable speichern, sondern mit datenbankabfrage
function isLektor()
{
    if($_SESSION['type'] == "2")
        return true;
    return false;
}

//Call JSON API via cURL, method = GET/POST/PUT; url = target URL of API; $data = POST or GET data to send to API
function callJSONAPI($method, $url, $data){
    $curl = curl_init();
    switch ($method){
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'APIKEY: 111111111111111111111',
        'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // EXECUTE:
    $result = curl_exec($curl);
    if(!$result){die("Connection Failure");}
    curl_close($curl);
    return $result;
}

?>
