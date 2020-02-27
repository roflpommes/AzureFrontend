<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Projekt bearbeiten:</h6>
</div>

<?php
require_once('./utility/functions.php');

$get_data = callJSONAPI('GET', 'http://localhost:3000/groups', false);
$response = json_decode($get_data, true);
//$errors = $response['response']['errors'];
//$data = $response['response']['data'][0];

$get_students = callJSONAPI('GET', 'http://localhost:3000/users', false);
$student_list = json_decode($get_students, true);

$arrayid = $_GET["project"] - 1;
$group = $response[$arrayid];

$action = './subpages/projects_sub/modify_project.php';
if(isAdmin()){
    print("
        <form name='group_properties' action='".$action."'>
            <div class='card-body'>
            <h5 class='font-weight-bol mb-2'>Name: </h5><input type='text'  class=\"form-control w-50\" name='group' value='".$group['name']."'><br>
              <h6 class='font-weight-bol mt-0' for=\"Lektors\">Lektor:</h6>
              <select id=\"Lektor\" class=\"form-control w-50\" name=\"Lektor\">
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
            <h6 class='font-weight-bol mt-3'>Budget: </h6><input type='text' class=\"form-control w-50\" name='budget' value='".$sgroup['budget']."'><br>
            <h6 class='font-weight-bol mt-0'>End_Date: </h6><input type='text' class=\"form-control w-50\" name='end_date' value='".$sgroup['end_date']."'><br>
            <input type='hidden'  name='ID' value='".$sgroup['ID']."'/>
      ");

print("<h6 class='font-weight-bol mb-0'>Members: </h6>");

//Iterator for Input name + id
$i = 0;
foreach ($student_list as $list_student)
{
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
}

print("<input type='submit' value='Save' class=\"btn btn-primary mr-3 mt-3\"></form>");
} else if(isLektor()){
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
        <div class='input-group mb-2'>
            <div class='input-group-prepend'>
                 <label class='input-group-text' for='inputGroupInput01'>Lektor:</label>
            </div>
            <div class='custom-file'>
                <input type='text' class=\"form-control w-100\" name='lektor' value='".$group['Lektor']."'readonly>
            </div>
        </div>
        <div class='input-group mb-2'>
            <div class='input-group-prepend'>
                 <label class='input-group-text' for='inputGroupInput01'>Budget:</label>
            </div>
            <div class='custom-file'>
                <input type='text' class=\"form-control w-100\" name='budget' value='".$group['budget']."'readonly>
            </div>
        </div>
        <div class='input-group mb-2'>
            <div class='input-group-prepend'>
                 <label class='input-group-text' for='inputGroupInput01'>Enddatum:</label>
            </div>
            <div class='custom-file'>
                <input type='date' class=\"form-control w-100\" id=\"datepicker\"  name='end_date' value='".$group['end_date']."'>
            </div>
        </div>
        <input type='hidden'  name='ID' value='".$group['ID']."'/>");
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

} else {
    print("
        <form name='group_properties' action='".$action."'>
        <div class='card-body'>
        <h5 class='font-weight-bol mb-2'>Name: </h5><input type='text'  class=\"form-control w-50\" name='group' value='".$group['name']."' disabled><br>
        <h6 class='font-weight-bol mt-0' for=\"Lektors\">Lektor:</h6>
        <input type='text' class=\"form-control w-50\" name='lektor' value='".$group['Lektor']."' disabled><br>    
        <h6 class='font-weight-bol mt-3'>Budget: </h6><input type='text' class=\"form-control w-50\" name='budget' value='".$group['budget']."' disabled><br>
        <h6 class='font-weight-bol mt-0'>End_Date: </h6><input type='date' class=\"form-control w-50 \" id=\"datepicker\"name='end_date' value='".$group['end_date']."' disabled><br>
        <input type='hidden'  name='ID' value='".$group['ID']."'/>
        <h6 class='font-weight-bol mb-0'>Members: </h6>
    ");

    //Iterator for Input name + id
    $i = 0;
    foreach ($student_list as $list_student)
    {
        //Only list sutdents as Members of Project
        if($list_student['role'] == "Student") {
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
    }
    print("<input type='submit' value='Save' class=\"btn btn-primary mr-3 mt-3\"></form>");
}

?>
