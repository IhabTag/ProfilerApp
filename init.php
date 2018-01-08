<?php
    
//The initialization file

// Routes starts here
    $functions  = 'includes/functions/';       // Functions Directory
    $tmpl       = 'includes/templates/';       // Template Directory
    $css        = 'layout/css/';               // Css Directory
    $js         = 'layout/js/';                // Scripts Directory
    $fonts      = 'layout/fonts/';             // Fonts Directory
    
// Routes ends here
    
require_once 'connect.php';
require_once $functions . 'functions.php';

// Template Includes

    require_once $tmpl . 'header.php';

    if (!isset($noNavBar)) {require_once $tmpl . 'navBar.php';}
    if (!isset($noContent)) {require_once $tmpl . 'content.php';}