<?php
require_once('backend/dbConnection.php');
session_start();
if(isset($_SESSION['username'])){
    if(isset($_POST['submit'])){
        if(!empty($_POST['title']) && !empty($_POST['content'])){
            $title=$_POST['title'];
            $content=$_POST['content'];
            global $conn;
            $sql= "INSERT INTO posts (title,content) VALUES(:Title,:Content)";
            $stmt=$conn->prepare($sql);
            $stmt->bindValue(':Title',$title);
            $stmt->bindValue(':Content',$content);
            $Execute=$stmt->execute();
            if($Execute){
                header("Location:index.php");
                echo "successfull";
            }
        }
    }
}
else
{
    echo '<script>window.alert("please login")
        window.location.href = "/CRUD_Application/index.php"
    </script>';
    // header("Location:login.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Create post</title>
</head>
<body>
    <?php 
        include("nav.php");
    ?>
    <div class="full-screen flex-box content-center">
        <form class="flex-box flex-col" action="createPost.php" method="post">
            <h2 class="form-title">Create Post</h2>
            <input type="text" name="title" id="" placeholder="Title">
            <textarea name="content" id="" cols="30" rows="10" placeholder="Description"></textarea>
            <button class="btn" type="submit" name="submit">Create</button>
        </form>
    </div>
</body>
</html>