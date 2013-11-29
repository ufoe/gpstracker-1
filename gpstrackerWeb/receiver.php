<?php
//header('Cache-Control: no-cache, must-revalidate');
//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
//header('Content-type: application/json');

include_once 'functions.php';
include_once 'BfaUtilities.php';
include_once 'classi/Point.php';


//session_start();


$logger->info("p");

date_default_timezone_set('UTC');
$logger->info("p2");

$data=date("Y-m-d H:i:s");
$logger->info("p3");

$point=new Point();
$logger->info("p4");

$point->PNT_AID=getGet("androidID",-1);
$point->PNT_SES=getGet("session",0);
$point->PNT_BEARING=getGet("bearing",0);
$point->PNT_LAT=getGet("lat",0);
$point->PNT_LON=getGet("lon",0);
$gpsProvider=getGet("gpsProvider",0);
if ($gpsProvider=="enabled") {
    $point->PNT_PROVIDER=1;
}
$point->PNT_SATS=getGet("numSats",0);
$point->PNT_SATSFIX=getGet("numSatsInUsedInFix",0);
$point->PNT_SIGNAL=getGet("gpssignal",0);
$point->PNT_SPEED=getGet("speed",0);


$point->salvati();
