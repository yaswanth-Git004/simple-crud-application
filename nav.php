<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Document</title>
</head>
<body>
    <nav class="flex-box">
        <div class="logo">
            <span>My Blogs</span>
        </div>

        <div class="nav-links flex-box">
            <a href="index.php">Home</a>
             <?php 
                if(isset($_SESSION['username'])){
                    echo ' <a href="createPost.php">Add post</a>';
                }
             ?>
        </div>

        <div class="nav-links flex-box">
           <?php 
                if(!isset($_SESSION['username'])){
                    echo ' <a href="register.php"><li class="link">Register</li></a>
                         <a href="login.php"><li class="link">Login</li></a>';
                }else{
                    echo '<a href="backend/logout.php"><li class="link">Logout</li></a>';
                     echo '<h2 class="user"> Welcome '.$_SESSION['username'].'</h2>';
                }
           ?>
        </div>
    </nav>
</body>
</html>