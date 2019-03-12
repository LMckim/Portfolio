<?php

$arr = array();
$arr['ip address'] = $_SERVER['REMOTE_ADDR'];
$arr['language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
$arr['software'] = $_SERVER['HTTP_USER_AGENT'];

print(json_encode($arr));

?>