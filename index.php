
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
    profGen_log("whoopsie!");
    profGen_log(extract($_POST));

    $param['loggedIn'] = false;
}
$page = $builder->buildPage($param);
print($page);

?>