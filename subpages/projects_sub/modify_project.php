<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/INN/utility/functions.php');
//Send user data to backend via URL
//TODO: Insert Valid Backend URL
$id = $_GET['ID'];
$name = $_GET['group'];
$Lektor = $_GET['lektor'];
$budget = $_GET['budget'];
$end_date = $_GET['end_date'];
$students = array(100);

for($i = 0; $i <= 100; $i++)
{
    if(isset($_GET[$i]))
    $students[$i] = $_GET[$i];
}

$group = array($id, $name, $Lektor, $budget, $end_date, $students);

$make_call = callJSONAPI('POST', 'localhost:3000/groups', json_encode($group));
$response = json_decode($make_call, true);
$errors   = $response['response']['errors'];
$data     = $response['response']['data'][0];



echo("<script>window.location.replace('../../index.php?page=projects');</script>");

?>
