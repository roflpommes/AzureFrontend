<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Groups</h6>
</div>

<?php
require_once('./utility/functions.php');

$get_data = callJSONAPI('GET', 'http://localhost:3000/groups', false);
$response = json_decode($get_data, true);
//$errors = $response['response']['errors'];
//$data = $response['response']['data'][0];

$get_students = callJSONAPI('GET', 'http://localhost:3000/users', false);
$student_list = json_decode($get_students, true);

$groups_href = $_SERVER['PHP_SELF'];
if(isset($_GET['sort']))
    {$sort = $_GET['sort'];}

else $sort = "All";
$lektor_array = [];

foreach ($response as $group)
{   
    array_push($lektor_array,$group['Lektor']);
}

$result_array = array_unique($lektor_array);

print("
        <form action='".$groups_href."?page=groups'>
              <div class=\"input-group p-4\">
              <select id=\"sort\" name=\"sort\" class=\"custom-select\">
                    <option value=\"All\" ");if($sort == 'All') print ("selected"); print(">All</option>");
foreach($result_array as $uniqueLektor){
    print("<option value=\"".$uniqueLektor."\" ");if($sort == $uniqueLektor) print ("selected"); print(">".$uniqueLektor."</option>");
}

print("       
              </select>
              <input type='hidden' name='page' value='groups'/>
              <div class='input-group-append'>
                  <button class='btn btn-outline-secondary' type='submit'>Auswählen</button>
    
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
                                <th class='text-center'> Lektor: </th>
                                <th class='text-center'> Enddatum: </th>
                                <th class='text-center'> Budget: </th>
                                <th class='text-center'> Teilnehmer: </th>
                            </tr>
                        </thead>
                        <tbody>
                        ");

if($sort == "All")
{
    foreach ($response as $group)
    {       
        
            $id = $group["ID"];
            print("
                 <tr>
                 <td class='text-center'><a class='font-weight-bol' href='" . $groups_href . "?page=groups&group=" . $id . "'>" . $group['name'] . "</a></td>
                 <td class='text-center'>" . $group['Lektor'] . "</td>
                 <td class='text-center'>" . $group['end_date'] . "</td>
                 <td class='text-center'>" . $group['budget'] . "</td>"
            );
            print("<td class='text-center'>");
            $stud_string = "";
            $stud_output = "";
            foreach ($group['students'] as $group_student)
            {   
                
                foreach ($student_list as $list_student)
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
                
    print("</tbody>
            </table> 
            </div>");

}

else {
    foreach ($response as $group) {
        if ($group['Lektor'] == $sort) {
       $id = $group["ID"];
            print("
                 <tr>
                 <td class='text-center'><a class='font-weight-bol' href='" . $groups_href . "?page=groups&group=" . $id . "'>" . $group['name'] . "</a></td>
                 <td class='text-center'>" . $group['Lektor'] . "</td>
                 <td class='text-center'>" . $group['end_date'] . "</td>
                 <td class='text-center'>" . $group['budget'] . "</td>"
            );
            print("<td class='text-center'>");
            $stud_string = "";
            $stud_output = "";
            foreach ($group['students'] as $group_student)
            {   
                
                foreach ($student_list as $list_student)
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
    
    print("</tr></tbody>
            </table> 
            </div>");

}

?>
