<?php

    if (isset($_GET['search'])) {
        $contact = $_GET['search'];
        header("Location: contacts.php?do=Search&Contact=$contact");
    }

?>

<div class="row appNav">
    <div class="col-sm-2">
        <div class="nav-side-menu">
            <a href="index.php"><div class="brand"><span>P</span>rofiler <span>A</span>pp</div></a>
            <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
                <div class="menu-list">

                    <ul id="menu-content" class="menu-content collapse out">
                        <li>
                            <form id="search-bar" class="navbar-form navbar-left" action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="search" placeholder="Search Contacts">
                                </div>
                                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </form>
                        </li>
                        <li>
                            <a href="contacts.php">
                                <i class="fa fa-user fa-lg"></i> Contacts
                            </a>
                        </li>
                        <li>
                            <a href="groups.php">
                                <i class="fa fa-users fa-lg"></i> Groups
                            </a>
                        </li>
                        <li>
                            <a href="profile.php">
                                <i class="fa fa-user fa-lg"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a href="logout.php">
                            <i class="fa fa-sign-out fa-lg"></i> Logout
                            </a>
                        </li>
                    </ul>
             </div>
        </div>
    </div>
</div>