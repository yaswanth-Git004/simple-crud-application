<?php
require_once('backend/dbConnection.php');
require_once('backend/utilities.php');
session_start();
$post_id=((int) $_GET['id']);

$query = 'SELECT p.title,p.content,p.created_at,u.username from posts p join users u on p.user_id = u.id WHERE p.id = :postid';
$bindvalues = [":postid" => $post_id];

$post = getPosts($query, $conn, $bindvalues);
$date = explode(' ', $post[0]['created_at'])[0];

$dateObj = DateTime::createFromFormat('Y-m-d', $date);
$formated_Date = $dateObj->format('d/m/y');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>view</title>
</head>
<body>
    <?php include("nav.php");?>
<div class="main-container flex-box content-center">
    <?php 
        if($post[0]){ ?>
           <div class="post-box flex-box flex-row ">
                <div class="img-box" >
                    <img src="https://media.istockphoto.com/id/1147544807/vector/thumbnail-image-vector-graphic.jpg?s=612x612&w=0&k=20&c=rnCKVbdxqkjlcs3xH87-9gocETqpspHFXu5dIGB4wuM=" alt="post-image">
                </div>
                    <div class="content-box flex-box flex-col">
                    <div class="title-box flex-box flex-row content-center">
                        <div class="title">
                            <h2><?php echo $post[0]['title'] ?></h2>
                        </div>
                        <div class="post-details">
                            <p><?php echo $post[0]['username'] ?></p>
                            <p><?php echo $formated_Date ?></p>
                        </div>
                    </div>
                    <div class="content">
                        <p><?php echo $post[0]['content'] ?></p>
                    </div>
                </div>       
            </div>
    <?php } else { 
            echo "<h2>Post not found</h2>";
        }?>
</div>
</body>
</html>