<?php
require_once('./utility/functions.php');

    //Check if user is Admin
    if(isAdmin())
    {
        include_once('./subpages/users_sub/users_content.php');
    }
?>
