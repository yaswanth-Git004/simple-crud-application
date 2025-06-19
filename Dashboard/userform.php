<?php 
require_once("../backend/dbConnection.php");
require_once("../backend/utilities.php");
require_once("../backend/errorHandler.php");
session_start();

if($_SESSION['userrole'] === 'editor'){
    header("Location:adminPanel.php");
    exit();
}elseif($_SESSION['userrole'] === 'user'){
    header("Location: ../index.php");
    exit();
}

$Warning = ["status" => false, "message" => ""];
$user=[
    'id' => "",
    'username' => "",
    'role' => "",
];

$action = isset($_GET['id']) ? 'Edit' : 'Create';

if($action === 'Edit'){
    $query = "select * from users where id = :uid";
    $bindvalues= [':uid' => $_GET['id']];
    $user = get_User($query,$bindvalues,$conn);
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if($action === "Create"){
            if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['cpassword'])){
                error_Handler($Warning, "please en000ter details");
            }else{
                $usernameError = user_Validation($_POST["username"]);
                $passwordError = password_Validation($_POST["password"]);
                if($usernameError){
                    error_Handler($Warning, $usernameError);
                }elseif($passwordError){
                    error_Handler($Warning, $passwordError);
                }else{
                    $vlaues=['name'=> $_POST['username'],'password'=>$_POST['password'],'cpassword'=>$_POST['cpassword'],'role'=>$_POST['role']];
                    create_User($vlaues,$conn);
                }
            }
    }else{
         edit_User($user['id'],$_POST['role'],$conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <div class="flex-box main-wrapper">
    <?php
        require_once('admin_nav.php');
    ?>

       <div class="main-section flex-box flex-col">
            <div class="full-screen flex-box content-center">
            <?php 
                if($Warning["status"]){
                    echo '<div class="warning-container success">
                            <p>'.$Warning["message"].'</p>
                        </div>';
                }
            ?>
            <form class="flex-box flex-col form" id="form" action="" method="post">
                <h1 style="text-align:center;"><?php echo $action ?> user</h1>
                <input type="text" name="username" id="name" value="<?= $action==='Edit' ? $user['username']: ""; ?>" placeholder="Username" <?= $action === "Edit" ? "disabled" : ""?>>
                <select name="role" value="<?= $action==='Edit' ? $user['role']: ""; ?>" id="">
                    <option value="user">user</option>
                    <option value="editor">editor</option>
                    <option value="admin">admin</option>
                </select>
                <?php if($action === 'Create'): ?>
                <input type="password" name="password" id="password" placeholder="Password" >
                <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" >
                <?php endif; ?>
                <!-- <div class="flex-box content-space">
                    <a href="index.php">-Home-</a>
                    <a href="login.php">-Login-</a>
                </div> -->
                <button class="btn" type="submit" name="submit"><?=$action?></button>
            </form>
        </div>

        <script>
            let success = document.querySelector(".warning-container") || null;
        
            document.getElementById("form").addEventListener("submit", function(e){
                let username = document.getElementById("name").value.trim();
                let password = document.getElementById("password").value.trim();
                let cpassword = document.getElementById("cpassword").value.trim();
                let message = null;

                if (username === "" || password === "" || cpassword === "") {
                    message = "Client Please enter the details";
                } else if (!/^[A-Za-z][A-Za-z ]{2,19}$/.test(username)) {
                    message = "Username must start with a letter, be 3-20 characters, and contain only letters and spaces";
                } else if (password.length > 12) {
                    message = "Password should be less than 12 characters";
                } else if (!/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(password)) {
                    message = "Password must be at least 8 characters and include uppercase, lowercase, number, and special character";
                }else if(cpassword !== password){
                    message = "passwords do not match"
                }

                if (message !== null) {
                    e.preventDefault();
                    if (success) {
                        success.innerHTML = `<p>${message}</p>`;
                        success.classList.add("success");
                    } else {
                        success = document.createElement("div");
                        success.classList.add("warning-container", "success");
                        let p = document.createElement("p");
                        p.innerText = message;
                        success.appendChild(p);
                        document.body.prepend(success);
                    }
                }
                setTimeout(() => {
                        if (success) {
                            success.classList.remove("success");
                        }
                    }, 5000);
            });

            if(success?.classList.contains('success')){
                setTimeout(() => {
                        if (success) {
                            success.classList.remove("success");
                        }
                    }, 3000);
            }
        </script>
       </div>
    </div>
</body>
</html>