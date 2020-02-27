<?php 
/*
$resp = file_get_contents('http://localhost:3000/users?role=Student');

$response = json_decode($resp);


var_dump($response["2"]);
*/
$url = "http://localhost:3000/users?role=Student";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);

$response = json_decode($result);
print_r($response);
curl_close($ch);

?>
