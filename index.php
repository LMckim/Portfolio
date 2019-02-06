
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/helpers.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/buildpage.php');

session_start();

// retrieve configurations for server
require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

$param = array();
$builder  = new pageBuilder();
if(isset($_SESSION['id']))
{
    $param['loggedIn'] = true;

}else{

    $json = json_decode(file_get_contents('php://input'), true);

    if($json['action'] == 'login')
    {
        include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/user_actions/login.php');
    }elseif($json['action'] == 'register'){
        include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/user_actions/register.php');
    }


    $param['loggedIn'] = false;
}
$page = $builder->buildPage($param);
print($page);

?>