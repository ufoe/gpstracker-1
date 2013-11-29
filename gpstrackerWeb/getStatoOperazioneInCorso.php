<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

include_once 'functions.php';


//$arr=Array();
session_start();

$lavId=getGet("lavId","lastLavId");


$nomeFolder = sys_get_temp_dir() . "/lavorazioni/";
if (!file_exists($nomeFolder)) {
    mkdir($nomeFolder, 0777, true);
}

$i=session_id();
$myFile = $nomeFolder."/".$i."_".$lavId.".txt";
// ci provo qualche volta...
$max=10;
$fatto=false;
while ($max>0) {
    if (file_exists($myFile)) {
        $fh = fopen($myFile, 'r');
        $fs=filesize($myFile);
        if ($fs>0) {
            $theData = fread($fh, $fs);
            echo $theData;
            fclose($fh);
            $fatto=true;
            break;
        } else {
            fclose($fh);            
        }
    }
    
    sleep(2);
        
    $max--;
}

if (! $fatto) {
    echo "{}";
}
