<?php

// import values from array to be used as variables
$logpath = $_SERVER['DOCUMENT_ROOT'].'/logs/login.log';

$userName = $json['uname'];
$password = $json['pass'];
$email = $json['email'];

if(empty($userName) || empty($password) || empty($email))
{
    $result = array('status'=>'failure','error'=>'empty form');
    $result = json_encode($result);
    echo($result);
    // exits form if an error is found
    exit();
}else{
    // import secure password hashing
    include_once($_SERVER['DOCUMENT_ROOT'].'/external/Security/PBKDF2.php');
    $hasher = new PasswordStorage();

    $u_name = $conn->real_escape_string($userName);
    $u_pass = $hasher->create_hash($password);
    $u_email = $conn->real_escape_string($email);

    $sql = "SELECT * FROM `users` WHERE `user_name`='$u_name'";
    $result = $conn->query($sql);
    if(mysqli_num_rows($result) != 0)
    {
        $msg = "attempt to register with in use username = " . $u_name;
        profSpec_log($logpath,$msg);
        $msg = "Username in use, please try a different one.";
        $error = array('status'=>'error','message'=>$msg);
        echo(json_encode($error));
        exit();
    }else{
        // if username doesnt exit then create new user
        $sql = "INSERT INTO `users`(`user_name`,`user_password`,`user_email`) VALUES('$u_name','$u_pass','$email')";
        profGen_log($sql);
        if($conn->query($sql))
        {
            $msg = "user " . $u_name . " created successfully";
            profSpec_log($logpath,$msg);

            $sql = "SELECT `user_id` FROM `users` WHERE `user_name`='$u_name'";
            $user_id = $conn->query($sql);
            if(mysqli_num_rows($user_id) == 0)
            {
                $msg = "Could not retrieve new user";
                profSpec_log($logpath,$msg);
                $error = array('status'=>'error','message'=>$msg);
                echo(json_encode($error));
                exit();
            }
            $user_id = $user_id->fetch_array(MYSQLI_ASSOC);
            $user_id = $user_id['user_id'];
            // set user logged in
            $sql = "UPDATE `users` SET `logged_in`='y' WHERE `user_id`=$user_id";
            $conn->query($sql);

            $msg = "Successfully registered.";
            $success = array('status'=>'success','message'=>$msg ,'user_id'=>$user_id);
            echo (json_encode($success));
            exit();
        }else{
            $msg = "Could not create new user";
            profSpec_log($logpath,$msg);
            $error = array('status'=>'error','message'=>$msg);
            echo(json_encode($error));
            exit();
        }
    }

}




           