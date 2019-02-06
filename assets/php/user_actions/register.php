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
    $u_name = $conn->real_escape_string($userName);
    $u_pass = hash('sha256',$conn->real_escape_string($password));
    $u_email = $conn->real_escape_string($email);

    

}




           