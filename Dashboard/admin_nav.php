<?php
    require_once('../backend/dbConnection.php');

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if(!isset($_SESSION['username'])){
        header("Location: ../login.php");
        exit();
    }

    if($_SESSION['userrole'] === "user"){
        header("Location: ../index.php");
        exit();   
    }

    $currentPage = basename($_SERVER['PHP_SELF']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
    rel="stylesheet"
    />
    <title>Document</title>
</head>
<body>
    <div class="side-navbar flex-box flex-col">
    <div class="users-profile">
        <div class="profile-image">
            <img src="../assets/profile.jpg" alt="">
        </div>
        <div class="profile-content">
            <p><?php echo $_SESSION['username']; ?></p>
        </div>
    </div>

    <div class="nav-elements">
        <a href="adminPanel.php"><div class="navlinks <?php echo ($currentPage == 'adminPanel.php') ? 'active' : ''; ?>">
            <span>Post Management</span>
        </div></a>
        <?php if($_SESSION['userrole'] === 'admin') {?>
        <a href="user-management.php"><div class="navlinks <?php echo ($currentPage == 'user-management.php') ? 'active' : ''; ?>">
            <span>User Management</span>
        </div></a>
        <?php } ?>
        <!-- <a href="profile-management.php"><div class="navlinks <?php echo ($currentPage == 'profile-management.php') ? 'active' : ''; ?>">
            <span>Profile Management</span>
        </div></a> -->
        <a href="../index.php"><div class="navlinks">
            <span>Home</span>
        </div></a>
    </div>

    <div class="admin-logout">
        <a href="../backend/logout.php" class="btn">logout</a>
    </div>
</div>
</body>
</html>

