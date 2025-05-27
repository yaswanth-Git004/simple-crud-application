<?php
require_once('backend/dbConnection.php');
session_start();
$search_element=$_GET['id'];
if(isset($_SESSION['username'])){
    if(isset($_POST['submit'])){
        if(!empty($_POST['title']) && !empty($_POST['content'])){
            $title=$_POST['title'];
            $content=$_POST['content'];
            global $conn;
            $sql= "UPDATE posts SET title= :Title , content= :Content WHERE id=:Id";
            $stmt=$conn->prepare($sql);
            $stmt->bindValue(':Title',$title);
            $stmt->bindValue(':Content',$content);
            $stmt->bindValue(':Id',$search_element);
            $Execute=$stmt->execute();
            if($Execute){
                header("Location:index.php");
                exit();
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
    <?php
        global $conn;
        $sql="SELECT title,content FROM posts WHERE id='$search_element'";
        $stmt=$conn->query($sql);
        while($DataRows=$stmt->fetch())
        {
            $title=$DataRows["title"];
            $content=$DataRows["content"];
        }
    ?>
    <div class="full-screen flex-box content-center">
        <form class="flex-box flex-col" action="edit.php?id=<?php echo $search_element?>" method="post">
            <h2 class="form-title">Edit Post</h2>
            <input type="text" name="title" id="" value="<?php echo $title?>">
            <textarea name="content" id="" cols="30" rows="10"><?php echo $content?></textarea>
            <button class="btn" type="submit" name="submit">Edit</button>
        </form>
    </div>
</body>
</html>