<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Gruppe bearbeiten</h6>
</div>

<?php
require_once('./utility/functions.php');

$get_data = callJSONAPI('GET', 'http://localhost:3000/groups', false);
$response = json_decode($get_data, true);
//$errors = $response['response']['errors'];
//$data = $response['response']['data'][0];

$get_students = callJSONAPI('GET', 'http://localhost:3000/users', false);
$student_list = json_decode($get_students, true);

$arrayid = $_GET["group"] - 1;
$group = $response[$arrayid];

$action = './subpages/groups_sub/modify_group.php';
$action = str_replace("index.php/", "", $action);

print("
        <form name='group_properties' action='".$action."'>
            <div class='card-body'>
            
            <div class='input-group mb-2'>
                <div class='input-group-prepend'>
                     <label class='input-group-text' for='inputGroupInput01'>Projektname:</label>
                </div>
                <div class='custom-file'>
                    <input type='text' class=\"form-control w-100\" name='group' value='".$group['name']."'>
                </div>
            </div>
            <div class=\"input-group mb-2\">
            <div class='input-group-prepend'>
                     <label class='input-group-text' for='inputGroupInput01'>Lektor:</label>
                </div>
            <select id=\"sort inputGroupSelect01\" name=\"Lektor\" class=\"custom-select text-center\">
      ");

//List all available lectors
foreach ($response as $sgroup)
{
    print("
                    <option value='".$sgroup['Lektor']."' ");if($response[$arrayid]['Lektor'] == $sgroup['Lektor']) print ("selected"); print(">".$sgroup['Lektor']."</option>
          ");
}
print("
              </select>
        
                </div>
                
           <div class='input-group mb-2'>
                <div class='input-group-prepend '>
                     <label class='input-group-text' for='inputGroupInput01'>Budget:</label>
                </div>
                <div class='custom-file'>
                    <input type='text' class=\"form-control w-100\" name='budget' value='".$group['budget']."'>
                </div>
            </div>
            
            <div class='input-group mb-2'>
                <div class='input-group-prepend '>
                     <label class='input-group-text' for='inputGroupInput01'>Enddatum:</label>
                </div>
                <div class='custom-file'>
                    <input type='date' class=\"form-control w-100 text-center\" name='end_date' value='".$group['end_date']."' id=\"datepicker\">
                </div>
            </div>
            <input type='hidden'  name='ID' value='".$sgroup['ID']."'/>
      ");

print("<div class='input-group mb-2'>
                <div class='input-group-prepend '>
                     <label class='input-group-text' for='inputTeilnehmer'>Teilnehmer:</label>
                </div></div>");

//Iterator for Input name + id
$i = 0;

        print("<table class=\"table\">
            <thead></thead><tbody><tr>");
foreach ($student_list as $list_student)
{
    //Only list sutdents as Members of Project
    if($list_student['role'] == "Student")
    {

        print("<td class=\"text-center\"><input class='form-check-input' type='checkbox' id='" . $i . "' name='" . $i . "' value='" . $list_student['user'] . "'");

        //If student is in project -> check the box
        foreach ($group['students'] as $group_student) {
            if ($list_student['ID'] == $group_student) {
                print(" checked");
            }
        }
        print("><label class='form-check-label' for='defaultCheck" . $i . "'>");
        print($list_student['user']);
        print("</label></td>");
        $i++;
    }
}
               print("</tr></table>");       
            

print(" <div class='text-center'>
            <input type='submit' value='Speichern' class=\"btn btn-primary\">
            </div></form>");

/*
//Only list sutdents as Members of Project
    if($list_student['role'] == "Student")
    {
        print("<div class=\"form-check\">");
        print("<input class='form-check-input' type='checkbox' id='" . $i . "' name='" . $i . "' value='" . $list_student['user'] . "'");

        //If student is in project -> check the box
        foreach ($group['students'] as $group_student) {
            if ($list_student['ID'] == $group_student) {
                print(" checked");
            }
        }
        print("><label class='form-check-label' for='defaultCheck" . $i . "'>");
        print($list_student['user']);
        print("</label>");
        print("</div>");
        $i++;
    }
 */
?>
