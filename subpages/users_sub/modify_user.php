<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/INN/utility/functions.php');
//Send user data to backend via URL
//TODO: Insert Valid Backend URL
$id = $_GET['ID'];
$username = $_GET['user'];
$role = $_GET['role'];
$budget = $_GET['budget'];

$user = array($id, $username, $role, $budget);

$make_call = callJSONAPI('POST', 'localhost:3000/users', json_encode($user));
$response = json_decode($make_call, true);
$errors   = $response['response']['errors'];
$data     = $response['response']['data'][0];


echo("<script>window.location.replace('../../index.php?page=users');</script>");

?>
