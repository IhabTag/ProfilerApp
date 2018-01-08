<?php

/* 
 *  Functions v1.0
 *  Author	: Ihab Tag.
 *  Date	: 
 */


// Function to redirect to a specific page after period of seconds & accepts display message
function redirection($location, $seconds = 3, $msg = '') {
    echo "<div class='alert alert-success'>$msg</div>"; 
    header("refresh:$seconds;url=$location");
    exit();
}