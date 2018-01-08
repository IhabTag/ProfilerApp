<?php

/* 
 *  Profile Page v1.0
 *  Author	: Ihab Tag.
 *  Date	: 
 */
session_start();

if (isset($_SESSION['username'])) {
    
    require_once 'init.php';
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'View';
    
    if ($do == 'View') {
        
        $statement = $con->prepare('SELECT * FROM users WHERE UserID = ?');
        $statement->execute(array($_SESSION['id']));
        $user = $statement->fetch();
        
?>        
        <h2 class="text-center pageHead">My Profile</h2>
        
        <form class="contactData" action="?do=Update" method="POST">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">User Name</label>
              <div class="col-sm-9">   
                  <label class="col-form-label contact-details"><?php echo $user['Username']; ?></label>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Full Name</label>
              <div class="col-sm-9">   
                  <input type="text" class="form-control" name="fullName" required="required" placeholder="Full Name" value="<?php echo $user['FullName']; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label ">Current Password</label>
              <div class="col-sm-9">
                    <input type="password" class="form-control" name="currPass" required="required" placeholder="Enter Current Password">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label ">New Password</label>
              <div class="col-sm-9">
                    <input type="password" class="form-control" name="newPass" placeholder="Enter New Password">
                    <i id="passCheck01" class="passCheckG fa fa-check-circle" aria-hidden="true"></i>
                    <i id="passCheck02" class="passCheckR fa fa-times-circle" aria-hidden="true"></i>
                    
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label ">Confirm New Password</label>
              <div class="col-sm-9">
                    <input type="password" class="form-control" name="cNewPass" placeholder="Enter New Password Again">
                    <i id="passCheck03" class="passCheckG fa fa-check-circle" aria-hidden="true"></i>
                    <i id="passCheck04" class="passCheckR fa fa-times-circle" aria-hidden="true"></i>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-9 col-sm-offset-3">
                <button type="submit" class="btn btn-primary full-width">Submit</button>
              </div>
            </div>
        </form>

<?php

    }elseif ($do == 'Update') {
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $userID         = $_SESSION['id'];
            $userFullName   = $_POST['fullName'];
            $currPass       = $_POST['currPass'];
            $currPassHash   = sha1($currPass);
            $newPass        = $_POST['newPass'];
            $cNewPass       = $_POST['cNewPass'];
            
            $statement = $con->prepare('SELECT UserPassword FROM users WHERE UserID = ?');
            $statement->execute(array($userID));
            $user = $statement->fetch();
            
            // Validation
            
            $formErrors = array();
            
            if ($newPass == $cNewPass){
                $newPassHash = sha1($newPass);
            }else{
                $formErrors[] = '<div class="alert alert-danger">"New Password" And "New Password Confirmation" fields must be identical</div>';
            }
            
            if (empty($userFullName) || strlen($userFullName) < 3) {
                $formErrors[] = '<div class="alert alert-danger">Full Name Can\'t be less tahn 3 charachters</div>';
            }
            
            if ($currPassHash != $user['UserPassword']) {
                $formErrors[] = '<div class="alert alert-danger">The current password you have entered isn\'t correct</div>';
            }
            
            if (!empty($newPass)){
                if (strlen($newPass) < 6){
                    $formErrors[] = '<div class="alert alert-danger">The new password can\'t be less than 6 charachters</div>';
                }
            }
            
            if (!empty($formErrors)){
                foreach ($formErrors as $error) {
                    echo '<h2 class="text-center pageHead">Update Profile</h2>';
                    echo $error;
                    echo '<div><a class="btn btn-primary" href="javascript: history.go(-1)">Back</a></div>';
                }
            }else{
                
                
                if (empty($newPass)){$newPassHash = $currPassHash;}
                $statement = $con->prepare('UPDATE users SET FullName = ?, UserPassword = ? WHERE UserID = ?');
                $statement->execute(array($userFullName, $newPassHash, $userID));
                
                echo '<h2 class="text-center pageHead">Update Profile</h2><div class="alert alert-success">Your profile was updated successfully</div>';
                redirection('profile.php', 3, 'You will be redirected to your <span style="font-weight: bold;">Profile</span> page after 3 seconds');
            }
    
        }else{
            redirection('index.php', 0);
        }
    }
    
    require_once $tmpl . 'footer.php';
}else{
    header('Location: index.php');
    exit();
}
