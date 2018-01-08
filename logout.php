<?php

/*
 *  Logout v1.0
 *  Author Ihab Tag
 *  Date 23/12/2017
 * 
*/
    session_start();
    
    unset($_SESSION['username']);
    session_destroy();
    
    header('Location: index.php');
    exit();