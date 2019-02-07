<?php

// Where most of the page handling will be

// if theres content then return the requested content
if($json['action'] == 'content')
{
    include_once($_SERVER['DOCUMENT_ROOT'].'/assets/php/helpers/contentGrab.php');
    $grabber = new contentGrabber();
    $content = $json['toGet'];
    $content = $grabber->grabContent($content);
    profGen_log($content);
    print($content);
    exit();

    // if just basic page then print that
}else{
    $page  = $builder->buildPage($param);
    print($page);
    exit();
}




?>