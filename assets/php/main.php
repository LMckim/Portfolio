<?php
// setup for building the page

// lets put this into a switch statement later
profGen_log($json);
if($json['action'] == 'logout')
{
    $sql = "UPDATE `users` SET `logged_in`='n' WHERE `user_name`='$u_name'";
    if($conn->query($sql))
    {
        $logpath = $_SERVER['DOCUMENT_ROOT'].'/logs/login.log';
        $msg = "Succesful logout by user id " . $_SESSION['id'];
        profSpec_log($logpath,$msg);
    }else{
        $logpath = $_SERVER['DOCUMENT_ROOT'].'/logs/login.log';
        $msg = "Could not log out user id " . $_SESSION['id'];
        profSpec_log($logpath,$msg);
    }

    $param['element'] = 'AccountOptions_Default.html';
    print($builder->grabElement($param)); // is this going to cause issues????
    session_destroy();
    exit();
}  



// user is logged in // set user id
$param['loggedIn'] = true;
$param['user'] = $_SESSION['id'];
$page = $builder->buildPage($param);
print($page);
// session_destroy();




?>