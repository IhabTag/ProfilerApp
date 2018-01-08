<?php

/* 
 *  Groups Page v1.0
 *  Author	: Ihab Tag.
 *  Date	: 04-01-2018
 */

session_start();

if (isset($_SESSION['username'])) {
    
    require_once 'init.php';
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'View';
    
    // View ; Open ; Edit; Update ; New ; Insert ; Delete
    
    if ($do == 'View') {
        
        $statement = $con->prepare('SELECT * FROM groups WHERE UserID = ?');
        $statement->execute(array($_SESSION['id']));
        $rows = $statement->fetchAll();
        
?>
        <h2 class="text-center pageHead">Groups</h2>
        
        <!-- Groups Buttons -->
        <div class="membersNav text-left">
            <a class="btn btn-success" name="new" href="groups.php?do=New" method="GET"><i class="fa fa-plus-square" aria-hidden="true"></i> New</a>
        </div>

        <!-- Groups Main Table -->
        <table class="table table-responsive">
            <thead>
              <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Group</th>
                    <th scope="col">Description</th>
                    <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>  
<?php
        
        // Looping through the database table groups to get the groups details and view them on the main table
        $rowCounter = 1;    // The table row counter for the column [#]
        
        foreach ($rows as $row) { 
                
                echo '<tr class="clickableRow" data-href="groups.php?do=Open&id=' . $row['GroupID'] . '">';
                    echo '<th scope="row">' . $rowCounter++ . '</th>';
                    echo '<td>' . $row['GroupName'] . '</td>';
                    echo '<td>' . $row['GroupDesc'] . '</td>';
                    echo '<td><a class="btn btn-danger" name="delete" href="groups.php?do=Delete&id=' . $row['GroupID'] . '" method="GET"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>';
                echo '</tr>';
            
        }
        echo '</tbody></table>';
        
        
    }elseif ($do == 'Open') {
        
        $statement = $con->prepare('SELECT * FROM groups WHERE GroupID = ?');
        $statement->execute(array($_GET['id']));
        $group = $statement->fetch();
        $selectedGroupID = $group['GroupID'];
        
        
?>
        <h2 class="text-center pageHead">Group Details</h2>
        
        <div class="membersNav text-center">
            <a class="btn btn-warning" name="edit" href="groups.php?do=Edit&id=<?php echo $selectedGroupID; ?>" method="GET" id="editBtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
            <a class="btn btn-danger" name="delete" href="groups.php?do=Delete&id=<?php echo $selectedGroupID; ?>" method="GET"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>
        </div>
       
        <form class="contactData" action="?do=Open" method="GET">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Group</label>
              <div class="col-sm-10">   
                  <label class="col-form-label contact-details"><?php echo $group['GroupName'] ?></label>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label ">Group Description</label>
              <div class="col-sm-10">
                    <label class="col-form-label contact-details "><?php echo $group['GroupDesc'] ?></label>
              </div>
            </div>
        </form>
        
        
<?php
    

    }elseif ($do == 'New') {
        
        
?>
        <h2 class="text-center pageHead">Add New Group</h2>
        
        <form id="newGroup" action="?do=Insert" method="POST">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Group</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" name="groupName" required="required" placeholder="Group Name">
              </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Group Description</label>
                <div class="col-sm-10">    
                    <textarea class="form-control" rows="4" name="gro   upDesc" form="newGroup" placeholder="Enter description"></textarea>
                </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-10 col-sm-offset-2">
                <button type="submit" class="btn btn-primary full-width">Submit</button>
              </div>
            </div>
        </form>
<?php
    


    }elseif ($do == 'Insert') {
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
                echo '<h2 class="text-center pageHead">Add New Group</h2>';
                
                $groupName  = $_POST['groupName'];
                $groupDesc  = $_POST['groupDesc'];
                $userID     = $_SESSION['id'];
                
                // Check form data for errors
                
                $formErrors = array();
                if (empty($groupName)) {$formErrors[] = '<div class="alert alert-danger">Group Name Can\'t be empty</div>';}
                if (!empty($formErrors)){
                    foreach ($formErrors as $error){echo $error;}
                }else{
                    
                    // if no errors, insert data into database
                    
                    $statement = $con->prepare('INSERT INTO groups(GroupName, GroupDesc, UserID) VALUES(:gname, :gdesc, :gid)');
                    $statement->execute(array('gname' => $groupName, 'gdesc' => $groupDesc, 'gid' => $userID));
                    echo '<div class="alert alert-success">' . $statement->rowCount() . ' group was added successfully</div>';
                    redirection('groups.php', 3, 'You will be redirected to <span style="font-weight: bold;">Groups</span> page after 3 seconds');
                }
                
        }else{
            redirection('groups.php', 0);
        }

    }elseif ($do == 'Edit') {
        
        $statement = $con->prepare('SELECT * FROM groups WHERE GroupID = ?');
        $statement->execute(array($_GET['id']));
        $group = $statement->fetch();
        
?>
        <h2 class="text-center pageHead">Edit Group Details</h2>
        
        <form id="newGroup" action="?do=Update" method="POST">
            <label class="col-sm-2 col-form-label hideElement">GroupID</label>
              <input type="text" class="form-control hideElement" name="groupID" value="<?php echo $group['GroupID'] ?>">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Group</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" name="groupName" required="required" placeholder="Group Name" value="<?php echo $group['GroupName']; ?>">
              </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Group Description</label>
                <div class="col-sm-10">    
                    <textarea class="form-control" rows="4" name="groupDesc" form="newGroup" placeholder="Enter description"><?php echo $group['GroupDesc']; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-10 col-sm-offset-2">
                <button type="submit" class="btn btn-primary full-width">Submit</button>
              </div>
            </div>
        </form>
        
<?php
    


    }elseif ($do == 'Update') {
        
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
                echo '<h2 class="text-center pageHead">Update Group Details</h2>';
                
                $groupID    = $_POST['groupID'];
                $groupName  = $_POST['groupName'];
                $groupDesc  = $_POST['groupDesc'];
               
                // Check form data for errors
                
                $formErrors = array();
                if (empty($groupName)) {$formErrors = ['<div class="alert alert-danger">Group Name Can\'t be empty</div>'];}
                if (!empty($formErrors)){
                    foreach ($formErrors as $error){echo $error;}
                }else{
                    
                    // if no errors, update database
                    
                    $statement = $con->prepare('UPDATE groups SET GroupName = ?, GroupDesc = ? WHERE GroupID = ?');
                    $statement->execute(array($groupName, $groupDesc, $groupID));
                    echo '<div class="alert alert-success">' . $statement->rowCount() . ' group was updated successfully</div>';
                    redirection('groups.php', 3, 'You will be redirected to <span style="font-weight: bold;">Groups</span> page after 3 seconds');
                }
                
        }else{
            redirection('groups.php', 0);
        }  

    }elseif ($do == 'Delete') {
        
echo '<h2 class="text-center pageHead">Delete Group</h2>';
        
        $GroupID = $_GET['id'];
        $statement = $con->prepare('DELETE FROM groups WHERE GroupID = ?');
        $statement->execute(array($GroupID));
        
        echo '<div class="alert alert-danger">1 group was successfully deleted</div>';
        redirection('groups.php', 3, 'You will be redirected to groups page after 3 seconds');
        
    }

    require_once $tmpl . 'footer.php';
}else{
    header('Location: index.php');
    exit();
}