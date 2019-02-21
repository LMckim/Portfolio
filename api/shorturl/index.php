<?php

$conn = new mysqli('localhost','shorturl','MZtBPtYajvv0UCGW','shorturl');
if($conn->connect_errno)
{
    print("Could not connect to server");
}

if(isset($_GET['original_url']))
{
    $query = "SELECT MAX(short_url) FROM `shorturl`";
    $result = $conn->query($query);
    $arr = $result->fetch_array(MYSQLI_ASSOC);

    $url = $conn->real_escape_string($_GET['original_url']);
    $s_url = intval($arr['MAX(short_url)'] + 1);

    $query = "INSERT INTO `shorturl`(`original_url`,`short_url`) VALUES ('$url','$s_url')";
    $result = $conn->query($query);

    $r_arr = array();
    $r_arr['original_url'] = $url;
    $r_arr['short_url'] = $s_url;
    print(json_encode($r_arr));
    exit();

}else if(isset($_GET['short_url']))
{
    $s_url = $_GET['short_url'];
    $query = "SELECT `original_url` FROM `shorturl` WHERE `short_url`='$s_url'";
    $result = $conn->query($query);
    $arr = $result->fetch_array(MYSQLI_ASSOC);
    $url = $arr['original_url'];
    header('Location:'.$url);
    exit();

}else{
    print("Nothing to handle");
}
?>