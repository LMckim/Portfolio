
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

    if(isset($_POST['login']))
    {
        profGen_log("whoopie!");
    }
    $_POST = json_decode(file_get_contents('php://input'), true);
    profGen_log(extract($_POST));
    profGen_log($_SERVER);
    profGen_log($_POST);

    $param['loggedIn'] = false;
}
$page = $builder->buildPage($param);
print($page);

?>