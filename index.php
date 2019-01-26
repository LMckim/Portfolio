<?php 

// load custom functions
include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/helpers.php');

session_start();

// retrieve configurations for server
require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

// if logged in then redirect
if(isset($_SESSION['id']))
{
    if(isset($_GET['tips-tracker']))
    {
        print('success!');
        $logpath = $_SERVER['DOCUMENT_ROOT'].'/logs/testing.log';
        $msg = "success!";
        profSpec_log($logpath,$msg);
    }
    // handles logging out
    if(isset($_GET['login']))
    {   
        $id = $_SESSION['id'];
        $logpath = $_SERVER['DOCUMENT_ROOT'].'/logs/login.log';
        $sql = "SELECT `logged_in` FROM `users` WHERE `user_id`= $id";
        if($conn->query($sql)){}
        else{
            $msg = "Could not retrieve user status for id = $id";
            profSpec_log($logpath,$msg);
        }

        $sql = "UPDATE `users` SET`logged_in`='n' WHERE `user_id`= $id";
        if($conn->query($sql))
        {
            $msg = "Successful logout by user id = $id";
            profSpec_log($logpath,$msg);
        }else{
            $msg = "Could not log out user id = $id";
            profSpec_log($logpath,$msg);
        }

        // destroy the session and return to login page wether successful or not
        session_start();
        session_destroy();
        $login = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/login.html');
        print($login);
    }else{
        // prints landing page index.html if nothing else is set
        $html = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/index.html');
        print($html);
    }
}
else{
    // handles all non-logged in shit
    if(isset($_POST['submit']))
    {
        if($_SERVER['QUERY_STRING'] == 'login')
        {
            include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/user_actions/login.php');
        }else if($_SERVER['QUERY_STRING'] == 'register')
        {
            include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/user_actions/register.php');
        }

    }else{
        $login = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pages/login.html');
        print($login);
    }
}

?>


