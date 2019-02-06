<?php
// setup for building the page





// user is logged in // set user id
$param['loggedIn'] = true;
$param['user'] = $_SESSION['id'];
$page = $builder->buildPage($param);
print($page);




?>