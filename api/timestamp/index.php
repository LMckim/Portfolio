
<?php

if($_GET['datetime'] != "")
{
    $datetime = "";
    try{
        $datetime = new DateTime($_GET['datetime']);
    }catch(Exception $e){
        $arr = array("error"=>"invalid date");
        print(json_encode($arr));
        exit();
    }
    $arr = array("unix"=>"","utc"=>"");
    $utc = date_format($datetime, 'D, d M Y H:i:s T');
    $arr['utc'] = $utc;
    $unix = strtotime($utc);
    $arr['unix'] = $unix;

    print(json_encode($arr));
    exit();
}


$arr = array("unix" => "", "utc" => "");

$arr["unix"] = time();

$utc = new DateTime();
$utc = date_format($utc, 'D, d M Y H:i:s T');

$arr["utc"] = $utc;
print(json_encode($arr));

?>
