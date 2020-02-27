<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">User bearbeiten</h6>
</div>

<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/INN/utility/functions.php');

$get_data = callJSONAPI('GET', 'http://localhost:3000/users', false);
$response = json_decode($get_data, true);
//$errors = $response['response']['errors'];
//$data = $response['response']['data'][0];

$arrayid = $_GET["user"] - 1;
$user = $response[$arrayid];

$action = $_SERVER['PHP_SELF'].'/subpages/users_sub/modify_user.php';
$action = str_replace("index.php/", "", $action);

print("
        <form name='user_properties' action='".$action."'>
            <div class='card-body'>
                <div class='input-group mb-2'>
                    <div class='input-group-prepend'>
                         <label class='input-group-text' for='inputGroupInput01'>Username:</label>
                    </div>
                    <div class='custom-file'>
                    <input type='text' class=\"form-control w-100\" name='user' value='".$user['user']."'>
                    </div>
                </div>
                
                <div class=\"input-group mb-2\">
                    <div class='input-group-prepend'>
                     <label class='input-group-text' for='inputGroupInput01'>Lektor:</label>
                </div>
                  <select id=\"sort inputGroupSelect01\" name=\"role\" class=\"custom-select text-center\">
                    <option value=\"Lektor\" ");if($user['role'] == 'Lektor') print ("selected"); print(">Lektor</option>
                    <option value=\"Student\" ");if($user['role'] == 'Student') print ("selected"); print(">Student</option>
                    <option value=\"Admin\" ");if($user['role'] == 'Admin') print ("selected"); print(">Admin</option>
                  </select>
                  <input type='hidden' name='page' value='users'/>
                 
                </div>
                
                <div class='input-group mb-2'>
                    <div class='input-group-prepend'>
                         <label class='input-group-text' for='inputGroupInput01'>Budget:</label>
                    </div>
                    <div class='custom-file'>
                    <input type='text' class=\"form-control w-100\" name='budget' value='".$user['budget']."'>
                    </div>
                </div>

            <input type='hidden' name='ID' value='".$user['ID']."'/>
            <div class='text-center'>
            <input type='submit' value='Speichern' class=\"btn btn-primary\">
            </div>
        </form>
        "
    );

?>
