
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
    include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/user_actions/login.php');

}elseif($json['action'] == 'register'){
    include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/user_actions/register.php');
}

$param = array();
$builder  = new pageBuilder();
// intial logged in landing
if(isset($_SESSION ['id']))
{
    include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/main.php');
}else{
    // most basic landing page
    $param['loggedIn'] = false;
    $page = $builder->buildPage($param);
    print($page);
}



?>