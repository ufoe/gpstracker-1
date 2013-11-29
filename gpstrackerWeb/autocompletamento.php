<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

include_once ("login.php");
include_once ("queries.php");

//sleep(4);

$query=getGet("query");
$search=getGet("term",'');
$limit=getGet("limit",10);




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

$responce=dammiArrayListDaQuery($SQL);

$responce2=array();
foreach ($responce as $riga) {
    if (isset($riga["label"])) {
        $label=$riga["label"];
    } else {
        $label=$riga[1];
    }
        
    $responce2[]=array("value"=>$riga[1],"label"=>$label,"id" => $riga[0],"valori"=>$riga   );        
}

$res=json_encode($responce2);
echo $res;