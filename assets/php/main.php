<?php
// setup for building the page

if($json['action'] == 'logout')
{
    $sql = "UPDATE `users` SET `logged_in`='n' WHERE `user_name`='$u_name'";
    if($conn-query($sql))
    {
        $logpath = $_SERVER['DOCUMENT_ROOT'].'/logs/login.log';
        $msg = "Succesful logout by user id " . $_SESSION['id'];
        profSpec_log($logpath,$msg);
    }else{
        $logpath = $_SERVER['DOCUMENT_ROOT'].'/logs/login.log';
        $msg = "Could not log out user id " . $_SESSION['id'];
        profSpec_log($logpath,$msg);
    }

    $param['loggedIn'] = false;
    $page = $builder->buildPage($param);
    print($page);
    session_destroy();
}



// user is logged in // set user id
$param['loggedIn'] = true;
$param['user'] = $_SESSION['id'];
$page = $builder->buildPage($param);
print($page);




?>