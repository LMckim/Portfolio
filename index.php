
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/helpers/helpers.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/helpers/buildpage.php');

session_start();

// retrieve configurations for server
require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
// handles requests from the page
$json = json_decode(file_get_contents('php://input'), true);

if($json['action'] == 'login')
{
    // once logged in $_SESSION['id'] is set to user id
    include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/users/login.php');

}elseif($json['action'] == 'register')
{
    include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/users/register.php');
}

$param = array();
$builder  = new pageBuilder();
// intial logged in landing
if(isset($_SESSION ['id']))
{   
    // user landing page
    $param['loggedIn'] = true;
    $param['user'] = $_SESSION['id'];
    include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/users/loggedIn.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/main.php');
}else{
    // guest landing page
    $param['loggedIn'] = false;
    $param['user'] = 'guest';
    include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/main.php');

}



?>