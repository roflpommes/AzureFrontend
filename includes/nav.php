<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/INN/utility/functions.php');
?>
<nav class="navbar navbar-expand-lg navbar-light bg-primary1 mb-3">
    <a class="navbar-brand" href="index.php"><img src="./pics/fh-logo.png"  class="logo" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php
            if(isAdmin()){ 
                include_once('./includes/nav_sub_view/admin_nav.php');
            } else if(isLektor()){
                include_once('./includes/nav_sub_view/lektor_nav.php');
            } else {
                include_once('./includes/nav_sub_view/student_nav.php');
            }
        
        ?>
        <ul class="navbar-nav">
            <li class="nav-item">
                <p class="m-0 p-2">Willkommen, <?php echo $_SESSION["uname"]; ?></p>
            </li>
            <li class="nav-item">
                <a class="nav-link font-weight-bold" href="./helper/logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
