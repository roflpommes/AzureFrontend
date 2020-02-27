<?php
require_once('./utility/functions.php');
StartSession();

if(!isset($_SESSION["uname"])){
    header("Location: login.php");
    exit;
}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/style.css">

    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <?php if(isset($_GET['page'])){
            if($_GET['page'] == 'graphen'){
                echo "<title>Graphverwaltung</title>";
            }
            elseif($_GET['page'] == 'projects'){
                echo "<title>Projektverwaltung</title>";
            }
            elseif($_GET['page'] == 'users'){
                echo "<title>Userverwaltung</title>";
            } elseif($_GET['page'] == 'groups'){
                echo "<title>Gruppenverwaltung</title>";
            } else {
                echo "<title>Startseite</title>";
            }
        } else {
            echo "<title>Startseite</title>";
        }
    ?>
</head>

<body>
    <nav>
        <?php 
            include "./includes/nav.php";
        ?>
    </nav>

    <main class="container">
        <!-- Main Content -->
        <?php

        //users and groups should only be available for admins
        //lektors see their projects
        if(isset($_GET['page']) && $_GET['page'] == "users" && isAdmin())
            require_once('./subpages/users.php');

        elseif (isset($_GET['page']) && $_GET['page'] == "groups" && isAdmin())
            require_once('./subpages/groups.php');
        
        elseif (isset($_GET['page']) && $_GET['page'] == "projects")
            require_once('./subpages/projects.php');
        
        elseif (isset($_GET['page']) && $_GET['page'] == "graphen")
            require_once('./subpages/graph.php');

        //Main Page
        else require_once('./subpages/content.php');

        ?>
        <!-- End of Main Content -->
    </main>

    <footer>

    </footer>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <?php if(isset($_GET["project"]) || isset($_GET["group"])): ?>
    <script type="text/javascript">
        let field = document.getElementById('datepicker');
        let oldValue = field.value;
        field.oninput = handleInput;

        function handleInput(e) {
            let inputDate = Date.parse(field.value);
            let todayDate = Date.now();
            if (inputDate <= todayDate) {
                alert("Sie müssen ein Datum in der Zukunft wählen!");
                field.value = oldValue;
            }
        }

    </script>
    <?php endif; ?>

</body>

</html>
