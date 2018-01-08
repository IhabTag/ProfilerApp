<?php

/* 
 *  Reset Password v1.0
 *  Author	: Ihab Tag.
 *  Date	: 06-01-2018
 */

$noNavBar = '';
$noContent = '';

require_once 'init.php';

$email = $_POST['email'];

// Check if email is valid

if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo '<div class="alert alert-danger text-center">Email isn\'t valid</div>';
}else{
    
// Check if the provided email exists in database
    
    $statement = $con->prepare('SELECT * FROM users');
    $statement->execute();
    $rows = $statement->fetchAll();
    
    $emailFound = false;
    foreach ($rows as $row) {
        if (!empty($email) && $row['UserEmail'] == $email){
            
            // User Email Exists, continue
            $emailFound = true;
            $tmpPass = rand(111111, 999999);
            $tmpPassHash = sha1($tmpPass);
            
            $statement = $con->prepare('UPDATE users SET UserPassword = ? WHERE UserEmail = ?');
            $statement->execute(array($tmpPassHash, $email));
            
            $msg = wordwrap("<html><body><div style='font-size: 14px;padding: 5px; line-height: 1.2em;'>Your password has be reset to <strong>$tmpPass</strong><br>Please change your password directly after you access your account<br>Thank You</div></body></html>", 70);
            mail($email, "ProfilerApp Password Reset", $msg, "From: profilerapp@ihabtag.com\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=ISO-8859-1\r\n");
            
            
            echo "<div class='alert alert-success text-center'>A message with new password was successfully sent to $email\r\nPlease Check You Inbox</div>";
            
            redirection('index.php', 8, '<div class="alert alert-success text-center">You will be redirected to Login Page in 8 secondes');
            

        }else{
            $emailFound = false;
        }
    }
    
    if (!empty($email) && $emailFound == false){
            echo '<div class="alert alert-danger text-center">Email isn\'t Registered</div>';
            }
    
}
?>

<h1 class="appName"><span>P</span>rofiler <span>A</span>pp</h1>
<div class="container" id="loginPanel">
    <div class="loginRegister">
        <h2 class="passResetHeader">Password Reset</h2>
    </div>
    <form id="formLogin" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="form-group">
            <input type="text" class="form-control" name="email" placeholder="&#xf0e0 Enter Your Registered Email"/>
        </div>
        <div class="form-group">
            <label>A new password will be sent to the provided e-mail</label>
            <label class="warning">Please change your password after you use it to access your acount</label>
        </div>
        <button type="submit" class="btn btn-primary">&#xf090; &nbsp; Send</button>
    </form>
</div>


<?php

require_once $tmpl . 'footer.php';