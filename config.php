<?php

$conn = new mysqli('localhost','portfolio','MZtBPtYajvv0UCGW','portfolio');
if($conn->connect_errno)
{
    $logpath = $_SERVER['DOCUMENT_ROOT'].'/logs/error.log';
    $msg = "Server could not be connected to";
    profSpec_Log($logpath,$msg);
}
?>