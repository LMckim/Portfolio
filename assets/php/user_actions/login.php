<?php

// import values from array to be used as variables
        extract($_POST);

        if(!empty($userName) && !empty($password))
        {
            $logpath = $_SERVER['DOCUMENT_ROOT'].'/logs/login.log';

            // Escapes special characters in a string for use in an SQL statement, taking into account the current charset of the connection
            $u_name = $conn->real_escape_string($userName);
            $u_pass = hash('sha256',$conn->real_escape_string($password));
            $sql = "SELECT `user_id`,`logged_in` FROM users WHERE `user_name`='$u_name' AND `user_password`='$u_pass' LIMIT 1";
            $result = $conn->query($sql);

            if($result->num_rows > 0)
            {
                // succesful return, log user in, update db
                $r_arr = mysqli_fetch_array($result,MYSQLI_ASSOC);
                $sql = "UPDATE `users` SET `logged_in`='y' WHERE   `user_id`='1'";
                if($conn->query($sql)){}
                else{
                    $msg = "Could not update login status for user id = " . $r_arr['user_id'];
                    profSpec_log($logpath,$msg);
                }

                // handle logging
                $msg = "Succesful login by username = " . $u_name . " with id = " . $r_arr['user_id'];
                profSpec_log($logpath,$msg);

                // set and create session id
                $_SESSION['id'] = $r_arr['user_id'];

                // return landing page
                print(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/index.html'));

            }else{
                // nothing returned
                $msg = "Unsuccesful login attempt using username = " .$u_name. " and password = " .$password;
                profSpec_log($logpath,$msg);
                $login = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/login.html');
                print($login);
                $msg = "Login failed, either username or password are incorrect.";
                echo ("<script type='text/javascript'>alert('$msg');</script>");
            }
        }else{
            // eventually lets add error messaging here
                $msg = "Unsuccesful login attempt, username and/or password left blank";
                profSpec_log($logpath,$msg);
                $login = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/login.html');
                print($login);
                $msg = "Must fill in both username and password";
                echo ("<script type='text/javascript'>alert('$msg');</script>");
        }