<?php

// import values from array to be used as variables
        extract($_POST);
        $logpath = $_SERVER['DOCUMENT_ROOT'].'/logs/login.log';

        if(empty($userName) || empty($password) || empty($confirmPassword) || empty($email))
        {
            $register = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/register.html');
            print($register);
            $msg = "Not all fields filled out, please try again.";
            echo ("<script type='text/javascript'>alert('$msg');</script>");
        }else{

            // set up for safety
            $u_name = $conn->real_escape_string($userName);
            $u_pass = hash('sha256',$conn->real_escape_string($password));
            $u_email = $conn->real_escape_string($email);

            // check username doesnt already exist
            $sql = "SELECT * FROM `users` WHERE `user_name`='$u_name'";
            $result = $conn->query($sql);
            if(mysqli_num_rows($result) != 0)
            {
                $msg = "attempt to register with in use username = " . $u_name;
                profSpec_log($logpath,$msg);
                $msg = "Username in use, please try a different one.";
                echo ("<script type='text/javascript'>alert('$msg');</script>");
            }else{
                // if username doesnt exit then create new user
                $sql = "INSERT INTO `users`(`user_name`,`user_password`,`user_email`) VALUES('$u_name','$u_pass','$email')";
                profGen_log($sql);
                if($conn->query($sql))
                {
                    $msg = "user " . $u_name . " created successfully";
                    profSpec_log($logpath,$msg);
                    $login = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/login.html');
                    print($login);
                    $msg = "Success! Please log in now.";
                    echo ("<script type='text/javascript'>alert('$msg');</script>");
                }else{
                    $msg = "Could not create new user";
                    profSpec_log($logpath,$msg);
                }
            }
        }
           