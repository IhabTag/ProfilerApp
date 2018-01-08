<?php

    session_start();
    
    $noNavBar = '';
    $noContent = '';
    
    // If session is active, then redirect to dashboard
    if (isset($_SESSION['username'])){
        header('Location: dashboard.php');
        exit();
    }
    
    require_once 'init.php';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {     //Check if the credentials are coming through POST method
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashedPassword = sha1($password);
        
        // Check if the user exists in the database
        
        $statement = $con->prepare('SELECT UserID, Username, UserPassword FROM users WHERE Username = ? AND UserPassword = ? LIMIT 1');
        $statement->execute(array($username, $hashedPassword));
        $row = $statement->fetch();
        $count = $statement->rowCount();
        
        // If $count is greater than 0, then the user exists
        $error = '';
        
        if ($count > 0) {
            $_SESSION['username']   = $username;        // Register username in session
            $_SESSION['id']         = $row['UserID'];   // Register user id in session
            header('Location: dashboard.php');
        }else{
            $error = '<div class="alert alert-danger">Invalid Username or Password</div>';
        }
    }
  
?>
<h1 class="appName"><span>P</span>rofiler <span>A</span>pp</h1>
<div class="container" id="loginPanel">
    <div class="loginRegister">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a id="tabLogin" class="nav-link active" href="#loginPage" role="tab" data-toggle="tab">Login</a>
            </li>
            <li class="nav-item">
                <a id="tabRegister" class="nav-link" href="#registerPage" role="tab" data-toggle="tab">Register</a>
            </li>
        </ul>
    </div>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="loginPage">
            <form id="formLogin" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
              <div class="form-group">
                  <input type="text" class="form-control" name="username" placeholder="&#xf007 Username"/>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="&#xf084 Password"/>
              </div>
                <button type="submit" class="btn btn-primary">&#xf090; &nbsp; Login</button>
            </form>
            <div class="passReset">Forgot your Password? <a href="reset_password.php"> &nbsp; Reset Password</a></div>
        </div>
        
        <?php if (!empty($error)) {echo $error;} ?>
        
        <div role="tabpanel" class="tab-pane fade" id="registerPage">
            <form id="formRegister" action="register.php" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" name="username" required="required" placeholder="&#xf007 Username"/>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="fullName" required="required" placeholder="&#xf007 Full Name"/>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" required="required" placeholder="&#xf0e0 E-Mail Address"/>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="newPass" required="required" placeholder="&#xf084 Choose Password"/>
                    <i id="passCheck01" class="passCheckG fa fa-check-circle" aria-hidden="true"></i>
                    <i id="passCheck02" class="passCheckR fa fa-times-circle" aria-hidden="true"></i>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="cNewPass" required="required" placeholder="&#xf084 Confirm Password"/>
                    <i id="passCheck03" class="passCheckG fa fa-check-circle" aria-hidden="true"></i>
                    <i id="passCheck04" class="passCheckR fa fa-times-circle" aria-hidden="true"></i>
              </div>
                <button type="submit" class="btn btn-success">&#xf234; &nbsp; Register</button>
            </form>
        </div>
    </div>
</div>

<?php 
    
    require_once $tmpl . 'footer.php';