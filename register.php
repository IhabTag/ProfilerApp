<?php

/* 
 *  Register Page v1.0
 *  Author	: Ihab Tag.
 *  Date	: 06-01-2018
 */
$noNavBar    = '';
$noContent   = '';

require_once 'init.php';

echo '<h1 class="appName"><span>P</span>rofiler <span>A</span>pp</h1>';
echo '<div class="container registerPage">';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $userName   = $_POST['username'];
    $fullName   = $_POST['fullName'];
    $email      = $_POST['email'];
    $password   = $_POST['newPass'];
    $cPassword  = $_POST['cNewPass'];
    
    //check for existing username and email in database
    
    $statement = $con->prepare('SELECT * FROM users');
    $statement->execute();
    $rows = $statement->fetchAll();
    foreach ($rows as $row) {
        if ($row['Username'] == $userName) {
            $userExists = true;
        }
        if ($row['UserEmail'] == $email) {
            $emailExists = true;
        }
    }
    
    // Start form input validation
    
    $formErrors = array();
    
    if (strlen($userName) < 3 && strlen($userName) > 10) {$formErrors = '<div class="alert alert-danger">Username Can\'t be less than <strong>3 charachters</strong></div>';}
    if ($userExists) {$formErrors[] = '<div class="alert alert-danger">This   <strong>Username</strong> is <strong>Registered</strong> before.</div>';}
    if (strlen($fullName) < 3 && strlen($fullName) > 50) {$formErrors[] = '<div class="alert alert-danger">Full Name Can\'t be less than <strong>3 charachters</strong></div>';}
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){$formErrors[] = '<div class="alert alert-danger">Invalid <strong>Email</strong></div>';}
    if ($emailExists) {$formErrors[] = '<div class="alert alert-danger">This <strong>Email</strong> is <strong>Registered</strong> before.</div>';}
    if (empty($password)) {$formErrors[] = '<div class="alert alert-danger">Password Can\'t be <strong>Empty</strong></div>';}
    if (strlen($password) < 6) {$formErrors[] = '<div class="alert alert-danger">Password Can\'t be less than <strong>6 charachters</strong></div>';}
    if ($password != $cPassword) {$formErrors[] = '<div class="alert alert-danger">Password is <strong>Not Identical</strong></div>';}
      
    if (!empty($formErrors)){
        foreach ($formErrors as $error) {
            echo $error;
        }
        echo '<a class="btn btn-primary" href="javascript: history.go(-1)"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>';
        exit();
    }

    $passwordHash = sha1($password);
    
    $statement = $con->prepare('INSERT INTO users (Username, FullName, UserPassword, UserEmail) VALUES (:zusername, :zfullname, :zpassword, :zemail)');
    $statement->execute(array('zusername' => $userName, 'zfullname' => $fullName, 'zpassword' => $passwordHash, 'zemail' => $email));
    echo "<div class='alert alert-success'><h2>Congratulations!</h2>\r\nYou have succssfully registered.</div>";
    redirection('index.php', 10,'You will be redirected to <strong>Login Page</strong> in 10 seconds');
    
    echo '</div>';
    require_once $tmpl . 'footer.php';
    
}else{
    header('Location: index.php');
}