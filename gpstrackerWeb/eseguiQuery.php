<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

include_once ("login.php");
include_once ("queries.php");

//sleep(4);

$query=getGet("query");
$search=getGet("search");
$limit=getGet("limit");

$SQL=str_replace("%search%", addSlashes($search), $queries[$query]);


$cosaCercare="{(.*?)}";

while (preg_match("/\\$cosaCercare/",$SQL, $matches)) {
      $ricerca=$matches[1];
      
      $val=  getGet("$ricerca");      
      $SQL=  preg_replace("/\\"."{".$ricerca."}/",$val, $SQL);
}





if ($limit!="") {
    $SQL.=" limit ".$limit;
}

$responce=dammiArrayListDaQueryAss($SQL);

$res=array("success"=>true,"data"=>$responce);

$res=json_encode($res);
echo $res;