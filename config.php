<?php

$conn = new mysqli('localhost','portfolio','MZtBPtYajvv0UCGW','portfolio');
if($conn->connect_errno)
{
    echo "ERROR: ". $conn->connection_error;
}
?>