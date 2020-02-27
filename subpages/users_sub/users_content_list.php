<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Benutzerverwaltung</h6>
</div>

<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/INN/utility/functions.php');

$get_data = callJSONAPI('GET', 'http://localhost:3000/users', false);
$response = json_decode($get_data, true);
//$errors = $response['response']['errors'];
//$data = $response['response']['data'][0];

$users_href = $_SERVER['PHP_SELF'];
if(isset($_GET['sort']))
    {$sort = $_GET['sort'];}

else $sort = "Lektor";
print("
        <form action='".$users_href."?page=users'>
            <div class=\"input-group p-4\">
                
                  <select id=\"sort inputGroupSelect01\" name=\"sort\" class=\"custom-select\">
                    <option value=\"Lektor\" ");if($sort == 'Lektor') print ("selected"); print(">Lektor</option>
                    <option value=\"Student\" ");if($sort == 'Student') print ("selected"); print(">Student</option>
                    <option value=\"Admin\" ");if($sort == 'Admin') print ("selected"); print(">Admin</option>
                  </select>
                  <input type='hidden' name='page' value='users'/>
                  <div class='input-group-append'>
                  <button class='btn btn-outline-primary' type='submit'>Laden</button>
    
  </div>
                  
            </div>
        </form>
");
        
     print("
                <div class='p-4'>
                    <table class='table'>
                        <thead class='thead-dark1'>
                            <tr>
                                <th class='text-center'> Name: </th>
                                <th class='text-center'> Rolle: </th>
                        ");
            if($sort == 'Lektor' || $sort == 'Admin'){
                print("<th class='text-center'> Budget: </th>");
            }
            print(" </tr>
                    </thead>
                    <tbody> ");

    foreach ($response as $user)
    {
        if($user['role'] == $sort)
        {   
        
            $id = $user["ID"];
            print("
                <tr>
                <td class='text-center'><a class='font-weight-bol' href='" . $users_href . "?page=users&user=" . $id . "'>" . $user['user'] . "</a></td>
                 <td class='text-center'>" . $user['role'] . "</td>"
            );
            if ($user['role'] == "Lektor" || $user['role'] == 'Admin') {
                print "<td class='text-center'>" . $user['budget'] . "</td>";
            }
            print("</tr>");

}
}
            
            
            print("                    </tbody>
                </table>
            </div>
        ");
?>
