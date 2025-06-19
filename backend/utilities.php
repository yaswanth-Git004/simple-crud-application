<?php 

    function user_Validation($userName){
        if(strlen($userName)>30){
            return 'username should be lessthan 30 characters';
        }
        $error = preg_match("/^[A-Za-z][A-Za-z. ]{2,19}$/",$userName) ? null  :"username should contain atleast 3 characters only alpabets ,spaces and dot(.) are allowed";
        return $error;
    }

    function password_Validation($password){
        if(strlen($password)>12){
            return 'password should not exceed 12 characters';
        }
        $error = preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",$password) ? null : "password should contain min 8 characters uppercase,lowercase,numbers and special characters";
        return $error;
    }

    function hash_password($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }

    function set_Success(&$success){
      if(isset($_SESSION['successMessage'])){
        $success['status'] = true;
        $success['message'] = $_SESSION["successMessage"];
        unset($_SESSION["successMessage"]);
      }
    }
    
    function get_User($query,$bindValues, $conn){
        $stmt = $conn->prepare($query);

        foreach ($bindValues as $key => $value) {
            if (is_int($value)) {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } elseif (is_bool($value)) {
                $stmt->bindValue($key, $value, PDO::PARAM_BOOL);
            } elseif (is_null($value)) {
                $stmt->bindValue($key, $value, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function getPosts($query,$conn,$bindValues=[]){ 
        $stmt = $conn->prepare($query);
    
          foreach ($bindValues as $key => $value) {
            if (is_int($value)) {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } elseif (is_bool($value)) {
                $stmt->bindValue($key, $value, PDO::PARAM_BOOL);
            } elseif (is_null($value)) {
                $stmt->bindValue($key, $value, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getTotalPosts($query,$conn,$bindValues = []){
        $stmt=$conn->prepare($query);
        foreach ($bindValues as $key => $value) {
            if (is_int($value)) {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } elseif (is_bool($value)) {
                $stmt->bindValue($key, $value, PDO::PARAM_BOOL);
            } elseif (is_null($value)) {
                $stmt->bindValue($key, $value, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    function create_User($values,$conn){
        if($values["password"] === $values["cpassword"]){
            $query = "select * from users where username = :User";
            $bindValues = [':User' => $values['name']];
            $user = get_User($query,$bindValues,$conn);
            if($user && $values["name"]===$user["username"]){
                    error_Handler($Warning,'User alredy exists');
            }else{
                $stmt = $conn->prepare("INSERT INTO users(username,password,role)VALUES(:Uname,:Password,:Role)");
                $stmt->bindValue(':Uname',$values['name']);
                $stmt->bindValue(':Password',hash_password($values['password']));
                $stmt->bindValue(':Role',$values['role']);
                $Execute=$stmt->execute();
                if($Execute)
                {
                    $_SESSION["successMessage"]= "user added successfully";
                    header("Location:user-management.php");
                }
            }
        }
    }

    function  edit_User($id,$role,$conn){
        $stmt = $conn->prepare("update users set role = :Role where id = :Id");
        $stmt->bindValue(':Role',$role,PDO::PARAM_STR);
        $stmt->bindValue(':Id',$id,PDO::PARAM_INT);
        $Execute=$stmt->execute();
        if($Execute)
        {
            $_SESSION["successMessage"]= "user updated successfully";
            header("Location:user-management.php");
            exit();
        }
    }
?>
