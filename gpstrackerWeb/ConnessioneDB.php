<?php

    require_once 'settings.inc.php';


    function connessioneADB() {        
        global $mysql_host,$mysql_user,$mysql_pass,$mysql_db,$prefix_table;
        global $connesione;
        
        
        $connesione = mysql_connect($mysql_host,$mysql_user,$mysql_pass);
        
        if ($connesione!=false) {
            mysql_set_charset('utf8',$connesione );                
//        } else {
//            $err=mysql_error();
//            die('Invalid db: ' .$err);
        }
        mysql_select_db($mysql_db,$connesione);
        
        return $connesione;
    }
    
    function testConnessioneADB() {
        global $mysql_host,$mysql_user,$mysql_pass,$prefix_table;
        global $connesione;
        
        $res=mysql_query("show tables;",$connesione);
        return $res;
        

    }



$_lastError="";
function erroreMysql($query) {
    global $logger,$_lastQuery,$_lastError;
    $logger->error($query);    
    $_lastError=mysql_error();
    aggiugiMessaggioInCoda($_lastError."<BR/><HR/>".$query, "ef");
    $logger->error($_lastError);
}
    
$_lastQuery="";    
function query($query) {
    //debugQuery($query);
    global $logger,$_lastQuery,$_lastError,$_SESSION;
    //$logger->info($query);
     
    $_lastQuery=$query;
    $_lastError="";

    $res = mysql_query($query);
    if ($res===false) {
        erroreMysql($query);
//    } else {
//        aggiugiMessaggioInCoda($_lastQuery, "q");         
    }
    return $res;
}

    
    
     /**
    * fetchRows
    *
    * @return $tmp An array with the array fetched from the database
    *
    * @version 0.1
    */
    function fetchArray($execution){
            $tmp=array();
            while ( $row = @mysql_fetch_array($execution) ) {
                    $tmp[]=$row;
            }
            return $tmp;
    }


    function dammiArrayListDaQuery($query) {
        $rq = query($query);

        $res=fetchArray($rq);

        mysql_free_result($rq);

        return $res;
    }
    
    function dammiArrayListDaQueryNoAss($query) {
        $rq = query($query);

        $res=array();
        while ( $row = @mysql_fetch_array($rq,MYSQL_NUM) ) {
                $res[]=$row;
        }
        

        mysql_free_result($rq);

        return $res;
    }
    
    
    
    /**
    * fetchRows
    *
    * @return $tmp An array with the array fetched from the database
    *
    * @version 0.1
    */
    function fetchArrayAss($execution){
            $tmp=array();
            while ( $row = @mysql_fetch_assoc($execution) ) {
                    $tmp[]=$row;
            }
            return $tmp;
    }

    function dammiArrayListDaQueryAss($query) {
        $rq = query($query);

         $res=fetchArrayAss($rq);

        mysql_free_result($rq);

        return $res;
    }

    function dammiRigaDaQueryAss($query) {
        $res=dammiArrayListDaQueryAss($query);
        if (count($res)>0) {
            return $res[0];
        }

        return null;
    }

    function dammiValoreDaQuery($query) {
        $res=dammiArrayListDaQuery($query);
        if (count($res)>0) {
            return $res[0][0];
        }

        return null;
    }

     function getRowFromKeyValue($arrayToTest,$fieldName,$fieldValue) {
        for ($t=0;$t<count($arrayToTest);$t++) {
            if (isSet($arrayToTest[$t][$fieldName])) {
                if ($arrayToTest[$t][$fieldName]==$fieldValue) {
                    return $arrayToTest[$t];
                }
            }
        }

        return null;
    }

     function getArrayValue($arrayToTest,$fieldName,$fieldValue,$valueField) {
        for ($t=0;$t<count($arrayToTest);$t++) {
            if (isSet($arrayToTest[$t][$fieldName])) {
                if ($arrayToTest[$t][$fieldName]==$fieldValue) {
                    if (isSet($arrayToTest[$t][$valueField])) {
                        return $arrayToTest[$t][$valueField];
                    }

                    return "";
                }
            }
        }

        return null;
    }

    
    function compilaQuery($SQL,$sostituzioni) {
        
        $cosaCercare = "{(.*?)}";
        while (preg_match("/\\$cosaCercare/", $SQL, $matches)) {
            $ricerca = $matches[1];
            
            if (isset($sostituzioni[$ricerca])) {
                $val = $sostituzioni[$ricerca];
            } else {
                $val ="";
            }
            
            
            $SQL = preg_replace("/\\" . "{" . $ricerca . "}/", $val, $SQL);
        }
        
        return $SQL;
    }
    
    
    
    $resConnessione=connessioneADB();
	
//if ($resConnessione!==false) {
//	error_log("connessione avvenuta");
//	} else {
//	error_log("ERRORE CONNESSIONE");
//}

