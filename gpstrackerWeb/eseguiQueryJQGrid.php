<?php
include_once ("login.php");
include_once ("queries.php");
include_once ("BfaUtilities.php");

$tipoDati = getGet('tipoDati','json');
$tipoRisultato= getGet('tipoRisultato','echoJson');
$nomeColonne=getGet("nomiColonne",null);
$fileName = "";

if ($tipoRisultato=='echoJson' ) {
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');
} else if ($tipoRisultato=='echoCsv' ) {
    $fileName = getGet('fileName','dati.csv');
    header("Pragma: public");  
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$fileName");
} else {
    //preparo file da scaricare
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');
    
    $fileName = getGet('fileName','dati.csv');
}

unsetPost("tipoDati");
unsetPost("tipoRisultato");
unsetPost("fileName");
unsetPost("nomiColonne");


function getRealPOST() {
    $pairs = explode("&", file_get_contents("php://input"));
    $vars = array();
    foreach ($pairs as $pair) {
        $nv = explode("=", $pair);
        if (count($nv)>1) {
            $name = urldecode($nv[0]);
            $value = urldecode($nv[1]);
            $vars[$name] = $value;
        }
        
    }
    return $vars;
}

//sleep(4);

/* 
 header("Pragma: public");  
 header("Content-Type: application/octet-stream");
 header("Content-Disposition: attachment; filename=some_filename.csv");
 */


$page = getGet('page');
// get the requested page 
$limit = getGet('rows');
// get how many rows we want to have into the grid 
$sidx = getGet('sidx');
// get index row - i.e. user click to sort 
$sord = getGet('sord');
// get the direction 
if (!$sidx) {
    $sidx = 1;
}
//if ($limit <= 0) {
//    $limit = 999;
//}


$query = getGet("query");
$search = getGet("search");
//$limit=getGet("limit");

$SQL1 = str_replace("%search%", addSlashes($search), $queries[$query]);







function sistemaQueryJQGrid($datoDaCercare) {
    $i=  strpos($datoDaCercare, "TIMESTAMP_SOLO_DATA_MYSQL");
    if ($i === 0) {
        // trovato all'inizio
        $datoDaCercare = BfaUtilities::dammiDataMysql(substr($datoDaCercare, strlen("TIMESTAMP_SOLO_DATA_MYSQL")));
    }

    if (strpos($datoDaCercare, "TIMESTAMP_SOLO_DATA") === 0) {
        // trovato all'inizio
        $datoDaCercare = BfaUtilities::dammiDataMysql(substr($datoDaCercare, strlen("TIMESTAMP_SOLO_DATA")));
    }

    return $datoDaCercare;
}



function generaQueryDaTemplateQuery($query) {
    $postsss=  getRealPOST();
    
    $cosaCercare = "{(.*?)}";
    $FILTROJQGRID="";
    
    $querySql=$query;
    
    $matches=null;
    while (preg_match("/\\$cosaCercare/", $querySql, $matches)) {
        $ricerca = $matches[1];

        if ($ricerca == "FILTROJQGRID") {
            $val = "";
            
            
            
            //foreach ($postsss as $p => $valore) {
            foreach ($_POST as $p => $valore) {
                if ($p!="") {
                    
                    // cerco eventuali sostituzioni di punti con _ da parte di PHP
                    foreach ($postsss as $pSost => $valore2) {
                        $r=  str_replace(".", "_", $pSost);
                        if ($r==$p && $pSost!=$p) {
                            // e' uno sostituito !
                            $p=$pSost;                            
                        }
                    }
                                        
                    
                    if (
                            ($p != "_search")
                            && ($p != "nd")
                            && ($p != "page")
                            && ($p != "rows")
                            && ($p != "sidx")
                            && ($p != "sord")
                            && ($p != "filters")
                            && ($p != "query")
                            && ($p != "searchField")
                            && ($p != "searchOper")
                            && ($p != "searchString")
                            && ($p != "q") // sporco
                    ) {

                        if (is_numeric($valore)) {
                            $val.=" AND $p='$valore'";
                        } else {
                            $c="like";
                            $perc="%";
                            $i=strpos($valore, "TIMESTAMP_SOLO_DATA_MYSQL");
                            if ($i === 0) {
                                $c="=";
                                $perc="";
                            }

                            $valore = sistemaQueryJQGrid($valore);
                            $val.=" AND $p $c '$valore".$perc."'";



                        }
                    } else if ($p == "filters") {

                        $condizioni = array(
                            "eq" => "="
                            , "ne" => "!="
                            , "lt" => "<"
                            , "gt" => ">"
                            , "le" => "<="
                            , "ge" => ">="
                            , "bw" => "like"
                            , "bn" => "not like"
                            , "ew" => "like"
                            , "en" => "not like"
                            , "cn" => "like"
                            , "nc" => "not like"
                        );
                        $likesPost = array(
                            "eq" => ""
                            , "ne" => ""
                            , "lt" => ""
                            , "gt" => ""
                            , "le" => ""
                            , "ge" => ""
                            , "bw" => "%"
                            , "bn" => "%"
                            , "ew" => ""
                            , "en" => ""
                            , "cn" => "%"
                            , "nc" => "%"
                        );
                        $likesPre = array(
                            "eq" => ""
                            , "ne" => ""
                            , "lt" => ""
                            , "gt" => ""
                            , "le" => ""
                            , "ge" => ""
                            , "bw" => ""
                            , "bn" => ""
                            , "ew" => "%"
                            , "en" => "%"
                            , "cn" => "%"
                            , "nc" => "%"
                        );



                        //global $logger;
                        //$logger->info($valore);
                        $val = "";
                        $filters = json_decode($valore);

                        if ($filters != null) {
                            $rules = $filters->rules;
                            $val.=" AND (";
                            $groupOp = "";
                            foreach ($rules as $rule) {

                                $c = $condizioni[$rule->op];
                                $post = $likesPost[$rule->op];
                                $pre = $likesPre[$rule->op];

                                if (strpos($rule->data, "TIMESTAMP_SOLO_DATA_MYSQL") === 0) {
                                    // per le date comunque aggiungo %
                                    if ($c == "like") {
                                        $c = "=";                                
                                    }
                                    $post = "";
                                } else if (strpos($rule->data, "TIMESTAMP_SOLO_DATA") === 0) {
                                    // per le date comunque aggiungo %
                                    $c = "like";
                                    $post = "%";
                                }

                                $datoDaCercare = sistemaQueryJQGrid($rule->data);


                                $val.=" $groupOp $rule->field $c '$pre" . fixApostrofe($datoDaCercare) . "$post'";

                                $groupOp = $filters->groupOp;
                            }
                            $val.=" ) ";
                        }
                    }
                }

            }
                // filtri speciali
                //filters	{"groupOp":"AND","rules":[{"field":"EMB_DATA_CREAZIONE","op":"eq","data":"02/15/2013"},{"field":"EMB_OGGETTO","op":"bw","data":"Invio"}]}


            $FILTROJQGRID=$val;


            $querySql = preg_replace("/\\" . "{" . $ricerca . "}/", $val, $querySql);
        } else {
            $val = getGet("$ricerca");
            $querySql = preg_replace("/\\" . "{" . $ricerca . "}/", $val, $querySql);
        }

        /* _search	true
          fa10	grass
          nd	1360079952459
          page	1
          rows	20
          sidx
          sord	asc
         */
    }






    //if ($limit!="") {
    //    $querySql.=" limit ".$limit;
    //}

    $querySql = preg_replace("/;$/", "", $querySql);

    return $querySql;
}


$SQL=  generaQueryDaTemplateQuery($SQL1);


if (isset( $queries[$query."_count"])) {
    $queryCount =  generaQueryDaTemplateQuery($queries[$query."_count"]);
} else {
    $queryCount1 = preg_replace("/SELECT.*FROM/", "SELECT COUNT(*) FROM", $SQL,1);
    $queryCount = preg_replace("/order\ by.*/", "", $queryCount1 ,1);
}


$count = dammiValoreDaQuery($queryCount);


if ($count > 0) {
    if ($limit<=0) {
        $total_pages = 1;
    } else {
        $total_pages = ceil($count / $limit);
    }
    
} else {
    $total_pages = 0;
}
if ($page > $total_pages) {
    $page = $total_pages;
}

$start = $limit * $page - $limit; // do not put $limit*($page - 1) 
if ($start < 0) {
    $start = 0;
}

//$rows = dammiArrayListDaQueryAss($SQL . " ORDER BY $sidx $sord;");
$limit_="";
if ($limit>0) {
    $limit_    = "LIMIT $start , $limit";
}

$rows = dammiArrayListDaQueryAss($SQL . " ORDER BY $sidx $sord $limit_;");



$responce = array();
$responce["page"] = $page;
$responce["total"] = $total_pages;
$responce["records"] = count($rows);
$responce["rows"] = array();


$t = 0;
foreach ($rows as $row) {
	if (! isset($row["id"])) {
    	$row["id"] = $t;
	}

    $responce["rows"][] = $row;
    $t++;
}





//$res=array("success"=>true,"data"=>$responce);



if ($tipoDati=='simpleJson' ) {
    $res = json_encode($rows);
    echo $res;
    exit;
}

if ($tipoDati=='firstRow' ) {
    $res = json_encode($rows[0]);
    echo $res;
    exit;
}

if ($tipoDati=='json' ) {
    $res = json_encode($responce);
    if ($tipoRisultato=='echoJson' ) {
        // situazione tipica
        echo $res;
        exit;
    } else {
        // scrivo un file
        $nomeFolder = sys_get_temp_dir() . "/";
        $fh = fopen($nomeFolder . $fileName, 'w');
        fwrite($fh, $res);
        fclose($fh);
    }
    
} else {
    // CSV
    $res="";
    
    $invio='';
    
    
    if ($nomeColonne!=null) {
        $k="";
        $res.=$invio;
        foreach ($nomeColonne as $colonna) {            
            $res.=$k.$colonna;
            $k="\t";
        }
        
        $invio="\r\n";
    }
    
    
    foreach ($rows as $row) {
        $res.=$invio;
        
        $k="";
        
        if ($nomeColonne!=null) {
            foreach ($nomeColonne as $colonna) {
                $res.=$k.$row[$colonna];
                $k="\t";
            }
        } else {
            foreach ($row as $cella) {            
                $res.=$k.$cella;
                $k="\t";
            }
        }
        
        
        
        $invio="\r\n";
    }    
    
    if ($tipoRisultato=='echoCsv' ) {
        echo $res;        
        exit;
    } else {
        // scrivo un file
        $nomeFolder = sys_get_temp_dir() . "/";
        $fh = fopen($nomeFolder . $fileName, 'w');
        fwrite($fh, $res);
        fclose($fh);        
    }
}


$res=array("success"=>true,"data"=>$fileName,"messaggio"=>"");
echo json_encode($res);
