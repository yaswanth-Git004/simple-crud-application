<?php
require_once('backend/dbConnection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php include("nav.php")  ?>
    <div class="container flex-box content-center">
        <?php
            global $conn;
            $sql="SELECT *FROM POSTS";
            $stmt=$conn->query($sql);
            while($DataRows=$stmt->fetch()){
                $id=$DataRows['id'];
                $title=$DataRows['title'];
                $content=$DataRows['content'];
                $created_at=$DataRows['created_at'];
        ?>
        <div class="post-container flex-box flex-col">
            <div class="post-img">
                <img src="https://media.istockphoto.com/id/1147544807/vector/thumbnail-image-vector-graphic.jpg?s=612x612&w=0&k=20&c=rnCKVbdxqkjlcs3xH87-9gocETqpspHFXu5dIGB4wuM=" alt="post-image">
            </div>
            <div class="post-content flex-box flex-col">
                <h3 class="post-title"><?php echo $title?></h3>
                <p class="post-description"><?php echo $content?></p>
            </div>
             <div class="post-btns flex-box">
                    <!-- <button class="btn">view</button> -->
                   <a href="edit.php?id=<?php echo $id;?>"><button class="btn">Edit</button></a>
                   <a href="delete.php?id=<?php echo $id;?>"><button class="btn">Delete</button></a>
            </div>
        </div>
        <?php } ?>
    </div>
</body>
</html>