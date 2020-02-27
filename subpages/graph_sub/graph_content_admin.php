<div class="row justify-content-center">
    <div class="col">
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Projekt auswählen:</h6>
            </div>

            <?php
            require_once('./utility/functions.php');

            $get_data = callJSONAPI('GET', 'http://localhost:3000/groups', false);
            $response = json_decode($get_data, true);
            //$errors = $response['response']['errors'];
            //$data = $response['response']['data'][0];
        
            $get_users = callJSONAPI('GET', 'http://localhost:3000/users', false);
            $user_list = json_decode($get_users, true);
            
            $id = -1;
            //get student id
            foreach($user_list as $user){
                if($user['user'] == $_SESSION['uname']){
                    $id = $user['ID'];
                    break;
                }
            }
            
                    
            
            $graph_href = $_SERVER['PHP_SELF'];

            if(isset($_GET['sort']))
            {   
                $sort = $_GET['sort'];
                // was tun wenn kein projekt existiert?
            } else {
                $found = false;
                $sort = "Kein Projekt";
                // student fehlt noch
                
                if(isAdmin() && !empty($response)){
                    $sort = $response[0]['name'];
                } else if(isLektor() && !empty($response)){
                    foreach($response as $projectWithLector){
                        if($found){
                            break;
                        }
                        if($projectWithLector['Lektor'] == $_SESSION['uname']){
                            $sort = $projectWithLector['name'];
                            $found = true;

                        }
                    }
                } else if(!empty($response)){
                    
                        foreach($response as $projectWithStudent){
                            if($found){
                                break;
                            }
                            foreach($projectWithStudent['students'] as $student){
                                if($student == $id && $id != -1){
                                    $sort = $projectWithStudent['name'];
                                    $found = true;
                                } 
                            }
                        }
                    }
                }
            
            $get_usage = callJSONAPI('GET', 'http://localhost:3000/currentUsage?groupName='.$sort, false);
            
            $usage = json_decode($get_usage, true);
            if(!empty($usage) && $usage[0]['usage'] >= 0.8){
                $verbrauch = "Es wurden bereits <red>".$usage[0]['usage']*100;
                $verbrauch.="%</red> des Budgets verbraucht!";
                echo '<script type="text/javascript">';
                echo "$.alert({
                        title: 'Benachrichtigung!',
                        content: '$verbrauch'
                    });";
                echo '</script>';     
            }
            
            print("
                <form action='".$graph_href."?page=graphen'>

                    <div class=\"input-group p-4\">
                        <select id=\"sort\" name=\"sort\" class=\"custom-select\">");
            
            foreach($response as $projectSelect){
                if(isAdmin()){
                    print("
                        <option value='".$projectSelect['name']."'>".$projectSelect['name']."</option>
                    ");
                } else if(isLektor()){
                    if($projectSelect['Lektor'] == $_SESSION['uname']){
                        print("
                            <option value='".$projectSelect['name']."'>".$projectSelect['name']."</option>
                        ");
                    }
                } else {
                   foreach($projectSelect['students'] as $student){
                            
                                if($student == $id && $id != -1){
                                   print("
                                    <option value='".$projectSelect['name']."'>".$projectSelect['name']."</option>
                                ");
                                    
                                } 
                            }
                        
                }
            }
        
            print("
                        </select>
                <input type='hidden' name='page' value='graphen'/>
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
                                <th class='text-center'> Lektor: </th>
                                <th class='text-center'> Enddatum: </th>
                                <th class='text-center'> Budget: </th>
                                <th class='text-center'> Verbrauch: </th>");
            if(isAdmin() || isLektor()){
                print("<th class='text-center'> Teilnehmer: </th>");
            }
            print("
                           </tr>
                        </thead>
                        <tbody>
                        ");
            
            foreach ($response as $project) {
                if ($project['name'] == $sort) {
                    if(!empty($usage)){
                        $ausgabe = $usage[0]['usage']*100;
                    } else {
                        $ausgabe = "Nicht vorhanden.";
                    }
                    
            print("
                <tr>
                    <td class='text-center'><a class='font-weight-bol'>" . $project['name'] . "</a></td>
               <td class='text-center'>" . $project['Lektor'] . "</td>
                <td class='text-center'>" . $project['budget'] . "</td>
                <td class='text-center'>" . $project['end_date'] . "</td>
                  <td class='text-center");
                    if(gettype($ausgabe) == 'double'){
                        if($ausgabe >= 50 && $ausgabe < 80){
                            print(" text-orange");
                        } else if($ausgabe >= 80){
                            print(" text-red");
                        } else{
                            print(" text-green");
                        }
                        print("'>" . $ausgabe . "%</td>");
                    } else {
                        print("'>" . $ausgabe . "</td>");
                    }
                    

if(isAdmin() || isLektor()){
                print("<td class='text-center'>");
           $stud_string = "";
            $stud_output = "";
            foreach ($project['students'] as $group_student)
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
            }
        
        print("</tr></tbody>
            </table> 
            </div>");

        ?>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Budget von <?php echo $sort; ?> in Tabellenform:</h6>
            </div>

            <?php
            require_once('./utility/functions.php');
            $get_budgetverlauf = callJSONAPI('GET', 'http://localhost:3000/budget_verlauf', false);
            $budget = json_decode($get_budgetverlauf, true);
            
            $get_projects = callJSONAPI('GET', 'http://localhost:3000/groups', false);
            $projects = json_decode($get_projects, true);
        
            if(isset($_GET['sort'])){
                $sort = $_GET['sort'];
            } else {
                $sort = $projects[0]['name'];
            }
        
            $projectFound = false;
            
            foreach($budget as $oneBudget){
                if($sort == $oneBudget['project_name']){
                    print("
                        <div class='card-body mt-0 mb-0 pb-1'>
                    ");
                    $projectFound = true;
                }
            }
        
            if($projectFound){
            
                print("
                    <table class='table'>
                        <thead class='thead-dark1'>
                            <tr>
                                <th class='text-center'> Datum </th>
                                <th class='text-center'> Budget </th>
                            <tr>
                        </thead>
                        <tbody>
                ");

                foreach($budget as $oneDayBudget){
                    if($oneDayBudget['project_name'] == $sort){
                        foreach($oneDayBudget['budget'] as $budgetPerDay){
                            $milliseconds =  $budgetPerDay[0];
                            $timestamp = $milliseconds/1000;
                            
                            
                            print("
                                <tr>
                                    <td class='text-center'>".date("d-m-Y", $timestamp)."</td>
                                    <td class='text-center'>".$budgetPerDay[1]."</td>
                                </tr>
                            ");
                        }
                    }
                }

                print("
                        </tbody>
                        </table>
                    </div>
                    </div>
                ");
            } else {
                print("
                    <div class='card-body mt-0 mb-0 pb-1'>
                    <p> Leider kein Budgetverlauf für <b> ".$sort." </b> gefunden.</p>
                    </div>
                    </div>
                ");
            }
            
        
        ?>
        </div>
    </div>

    
<div class="row justify-content-center">
    <div class="col">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Budget von <?php echo $sort; ?> in Graphenform:</h6>
                </div>
                <?php 
               $get_budgetverlauf = callJSONAPI('GET', 'http://localhost:3000/budget_verlauf', false);
                $budget = json_decode($get_budgetverlauf, true);
            
                $get_projects = callJSONAPI('GET', 'http://localhost:3000/groups', false);
                $projects = json_decode($get_projects, true);
        
                if(isset($_GET['sort'])){
                    $sort = $_GET['sort'];
                } else {
                    $sort = $projects[0]['name'];
                }
        
                $projectFound = false;

                foreach($budget as $oneBudget){
                    if($sort == $oneBudget['project_name']){
                        print("
                            <div class='card-body mt-0 mb-0 pb-1'>
                        ");
                        $projectFound = true;
                        $dataPoints = $oneBudget['budget'];
                    }
                }
                if($projectFound){
                    
                print('
                <div id="chartContainer" style="height: 300px; width: 100%;">
                    <canvas id="chartCanvas"></canvas>
                </div>
                ');
                    
                print("
                <script>
                    $.ajax({
                        url: 'http://localhost:3000/budget_verlauf?project_name=". $sort ."',
                        method: 'GET',
                        datatype: 'json',
                        success: function(data) {
                            let rawData = data[0]['budget']
                            let data1 = [];
                            for (let i = 0; i < rawData.length; i++) {
                                rawData[i][0] = new Date(rawData[i][0]) 
                                rawData[i][1] = rawData[i][1]
                                let addToData = {x: rawData[i][0], y:rawData[i][1]};
                                data1.push(addToData);
                            }

                            
                            let options = {
                                title: {
                                text: 'Verlauf'
                                },
                                axisX: {
                                valueFormatString: 'MM-DD'
                                },
                                data: [
      {
        dataPoints: data1,
        type: 'line'
      }
      ]
                            }
                            
                            let chart = new CanvasJS.Chart('chartContainer' ,options)
                            chart.render()
                        },
                        error: function(data) {
                            
                        }
                    })
                
                </script>
                ");
                    
                echo "</div>";
                    
                } else {
                    print("
                        <div class='card-body mt-0 mb-0 pb-1'>
                    <p> Leider kein Budgetverlauf für <b> ".$sort." </b> gefunden.</p>
                    </div>
                    ");
                }
            ?>
            </div>

        </div>

    </div>