<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Projekte</h6>
</div>

<?php
require_once('./utility/functions.php');

$get_data = callJSONAPI('GET', 'http://localhost:3000/groups', false);
$response = json_decode($get_data, true);
//$errors = $response['response']['errors'];
//$data = $response['response']['data'][0];

$get_users = callJSONAPI('GET', 'http://localhost:3000/users', false);
$user_list = json_decode($get_users, true);
$projects_href = $_SERVER['PHP_SELF'];

$user = $_SESSION["uname"];
// search for all projects from the user
$user_id = -1;

foreach($user_list as $element){
    if($element["user"] == $user){
        $user_id = $element["ID"];
    }
}

print("
                <div class='p-4'>
                    <table class='table'>
                        <thead class='thead-dark1'>
                            <tr>
                                <th class='text-center'> Name: </th>");
                                if(!isLektor()){ print("<th class='text-center'> Lektor: </th>"); }
                                print("<th class='text-center'> Enddatum: </th>
                                <th class='text-center'> Budget: </th>");
                                if(isLektor()){ print("<th class='text-center'> Teilnehmer: </th>"); }
                           print("</tr>
                        </thead>
                        <tbody>
                        ");


// different views for account type
if(isLektor()){
    foreach($response as $group){
        if($group["Lektor"] == $user){
            $id = $group["ID"];
            print("
                 <tr>
                 <td class='text-center'><a class='font-weight-bol' href='" . $projects_href . "?page=projects&project=" . $id . "'>" . $group['name'] . "</a></td>
                 <td class='text-center'>" . $group['end_date'] . "</td>
                 <td class='text-center'>" . $group['budget'] . "</td>"
            );
            print("<td class='text-center'>");
           $stud_string = "";
            $stud_output = "";
            foreach ($group['students'] as $group_student)
            {   
                
                foreach ($user_list as $list_student)
                {
                    if($list_student['ID'] == $group_student)
                    {
                        $stud_string .= $list_student['user'].", ";
                        
                    }
                }
               
            }
         
            $stud_output = substr($stud_string,0,-2);
        print($stud_output."</td>");
        }
    }
} else {
    foreach($response as $group){
        foreach($group["students"] as $studentInProject){
            if($studentInProject == $user_id){
                print("
                 <tr>
                 <td class='text-center'>" . $group['name'] . "</td>
                 <td class='text-center'>" . $group['Lektor'] . "</td>
                 <td class='text-center'>" . $group['end_date'] . "</td>
                 <td class='text-center'>" . $group['budget'] . "</td>"
            );
            }
        }
    }
}

print("</tr></tbody>
            </table> 
            </div>");


?>
