<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/INN/utility/functions.php');
    if(isAdmin() || isLektor())
    {
        include_once($_SERVER['DOCUMENT_ROOT'] . '/INN/subpages/groups_sub/groups_content.php');
    }
?>
