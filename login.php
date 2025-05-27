<?php
    require_once('backend/dbConnection.php');
    session_start();

    $Warning = ["status" => false, "message" => ""];
    $success = "";
    
    if(isset($_SESSION["successMessage"])){
        $success = $_SESSION["successMessage"];
        unset($_SESSION["successMessage"]);
    }

    if(isset($_POST["submit"])){
        if(!empty($_POST["username"]) && !empty($_POST["password"])){
            // echo "starting point";
            $username = $_POST["username"];
            $password = $_POST["password"];
            $sql="SELECT *FROM users WHERE username=:Username";
            $stmt=$conn->prepare($sql);
            $stmt->execute(['Username' => $username]);
            $user=$stmt->fetch(PDO::FETCH_BOTH);
            // var_dump($user);
            if($user && password_verify($password, $user['password']) && $username === $user['username']){
                echo "Login successful. Welcome, " . htmlspecialchars($username) . "!";
                $_SESSION['username'] = $username;
                $_SESSION['userid'] = $user['id'];
                if(isset($_SESSION)){
                    header('Location:index.php');
                    // exit();
                }   
            } else {
                $Warning['status']= true;
                $Warning['message']="invalid user name or password";
                // header('Location:login.php');
                // exit();
            }

            $stmt = null;
            $connectingDB = null;
            
        }else{
            $Warning["status"] = true;
            $Warning["message"] = "Please enter credientials to login";
            // exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Login</title>
</head>
<body>
    <div class="full-screen flex-box content-center">
        <?php 
            if($Warning["status"]){
                echo '<div class="warning-container">
                        <p>'.$Warning["message"].'</p>
                     </div>';
            }
            if(!empty($success)){
                echo '<div class="warning-container">
                        <p>'.$success.'</p>
                     </div>';
            }
        ?>
        <form class="flex-box flex-col" action="login.php" method="post">
            <input type="text" name="username" id="" placeholder="Username">
            <input type="password" name="password" id="" placeholder="Password">
            <div class="flex-box content-space">
                <a href="index.php">-Home-</a>
                <a href="register.php">-Register-</a>
            </div>
            <button class="btn" name="submit" type="submit">Login</button>
        </form>
    </div>
</body>
</html>