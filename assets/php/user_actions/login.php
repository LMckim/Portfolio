<?php

// import values from array to be used as variables
$userName = $json['uname'];
$password = $json['pass'];

if(!empty($userName) && !empty($password))
{
    $logpath = $_SERVER['DOCUMENT_ROOT'].'/logs/login.log';

    // Escapes special characters in a string for use in an SQL statement, taking into account the current charset of the connection
    $u_name = $conn->real_escape_string($userName);
    $sql = "SELECT `user_id`,`logged_in`,`user_password` FROM users WHERE `user_name`='$u_name' LIMIT 1";
    $result = $conn->query($sql);
    // check username exists
    if(!$result->num_rows > 0)
    {
        $msg = "Unsuccesful login attempt using username = " . $u_name;
        profSpec_log($logpath,$msg);
        $msg = "Login failed, either username or password are incorrect.";
        $error = array('status'=>'error','message'=>$msg);
        echo(json_encode($error));
        exit();
    }else{
        $arr = $result->fetch_array(MYSQLI_ASSOC);
        $hash = $arr['user_password'];

        include_once($_SERVER['DOCUMENT_ROOT'].'/external/Security/PBKDF2.php');
        $checker = new PasswordStorage();
        // verify password
        if($checker->verify_password($password,$hash) == true)
        {   
            $sql = "UPDATE `users` SET `logged_in`='y' WHERE   `user_name`='$u_name'";
            if($conn->query($sql))
            {
                // handle logging
                $msg = "Succesful login by username = " . $u_name . " with id = " . $arr['user_id'];
                profSpec_log($logpath,$msg);

                // set and create session id
                $_SESSION['id'] = $arr['user_id'];
            }
            else{
                $msg = "Could not update login status for user id = " . $r_arr['user_id'];
                profSpec_log($logpath,$msg);
            }
        }else{
            // handle failed passwords
            $msg = "Unsuccesful login attempt using username = " .$u_name. " and password = " .$password . "password incorrect!";
            profSpec_log($logpath,$msg);
            $msg = "Login failed, either username or password are incorrect.";
            $error = array('status'=>'error','message'=>$msg);
            echo(json_encode($error));
            exit();
        }

        
    }
    
    
}