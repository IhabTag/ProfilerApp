<?php

    session_start();
    
    if (isset($_SESSION['username'])) {
        require_once 'init.php';
?>

<div class="text-center">
    <h1>Dashboard</h1>
    <div class="dashboard-group">
        <a class="btn dashboard-btn" href="contacts.php"><span><i class="fa fa-user fa-lg"></i> Contacts</span></a>
        <a class="btn dashboard-btn" href="groups.php"><span><i class="fa fa-users fa-lg"></i> Groups</span></a>
        <a class="btn dashboard-btn" href="profile.php"><span><i class="fa fa-user fa-lg"></i> Profile</span></a>
        <a class="btn dashboard-btn" href="logout.php"><span><i class="fa fa-sign-out fa-lg"></i> Logout</span></a>
    </div>
</div>

<?php        
        require_once $tmpl . 'footer.php';
    }else{
        header('Location: index.php');
        exit();
    }