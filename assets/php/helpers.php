<?php

function profGen_log($msg)
{
    $date = new DateTime();
    $date = date_format($date, 'Y-m-d H:i:s');
    if(is_array($msg))
    {
        file_put_contents($filepath,"[".$date . "] ",FILE_APPEND);
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logs/gen.log',print_r($msg,true),FILE_APPEND);
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logs/gen.log',"\n",FILE_APPEND);
    }else{
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logs/gen.log',"[" . $date . "] " . $msg.="\n",FILE_APPEND);
    } 
}
function profSpec_log($filepath,$msg)
{
    $date = new DateTime();
    $date = date_format($date, 'Y-m-d H:i:s');

    if(is_array($msg))
    {
        file_put_contents($filepath,"[".$date . "] ",FILE_APPEND);
        file_put_contents($filepath,print_r($msg,true),FILE_APPEND);
        file_put_contents($filepath,"\n",FILE_APPEND);
    }else{
        file_put_contents($filepath,"[" . $date . "] " . $msg.="\n",FILE_APPEND);
    } 
}

?>