<?php 
require_once("backend/dbConnection.php");
session_start();
$Warning = ["status" => false, "Message" => ""];
if(isset($_POST["submit"]))
{
    if((!empty($_POST["username"])&&!empty($_POST["password"]))&&!empty($_POST["cpassword"]))
    {
        try 
        {
            if($_POST["password"]===$_POST["cpassword"])
            {
           
                $username=$_POST["username"];
                $password=$_POST["cpassword"];
                $hashing=password_hash($password,PASSWORD_DEFAULT);
                global $conn;
                $sql = "INSERT INTO users(username,password)
                VALUES(:Uname,:Password)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':Uname',$username);
                $stmt->bindValue(':Password',$hashing);
                //  $stmt->bindValue(':Password',$password);
                $Execute=$stmt->execute();
                if($Execute)
                {
                    $_SESSION["successMessage"]= "user registered successfully";
                    header("Location:login.php");
                }
            }
            else
            {
               $Warning["status"] = true;
               $Warning["Message"] = "please check the passwoed and re-enter it.";
            }
        } 
        catch (Exception $e) 
        {
            $Warning["status"] = true;
            $Warning["Message"] = "User already exists";
        }
    }
    else
    {
        $Warning["status"] = true;
        $Warning["Message"] = "please enter the mentioned details";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Register</title>
</head>
<body>
    <div class="full-screen flex-box content-center">
        <?php 
            if($Warning["status"]){
                echo '<div class="warning-container">
                        <p>'.$Warning["Message"].'</p>
                     </div>';
            }
        ?>
        <form class="flex-box flex-col" action="register.php" method="post">
            <input type="text" name="username" id="" placeholder="Username">
            <input type="password" name="password" id="" placeholder="Password">
            <input type="password" name="cpassword" id="" placeholder="Confirm Password">
            <div class="flex-box content-space">
                <a href="index.php">-Home-</a>
                <a href="login.php">-Login-</a>
            </div>
            <button class="btn" type="submit" name="submit">Register</button>
        </form>
    </div>
</body>
</html>