<?php

require_once("ConnessioneDB.php");
require_once("inclusione.inc.php");
require_once("user_config.php");

function checkLogin() {
    global $mysql_host, $mysql_user, $mysql_pass, $mysql_db, $prefix_table;
    global $user_query_check_login, $user_id_field, $user_id_field_session_name;
    global $user_confirmed_field, $user_confirmed_field_value;
    global $user_redirect_to;

//	$anno=date("Y");
//	$mese=date("m");
//	$giorno=date("d");
//	$ore=date("H");
//	$minuti=date("i");
//	$secondi=date("s");

    $user = "";
    $pass = "";
    if (isset($_GET['username'])) {
        $user = $_GET['username'];
    }
    if (isset($_GET['password'])) {
        $pass = $_GET['password'];
    }
    if (isset($_POST['username']) && isSet($_POST['password'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];
    }

    // cifratura password
    //$md5pass=md5($pass);
    $md5pass = $pass;


    $errore = "NT";

    $trovato = false;


    $query = str_replace("%USER%", addSlashes($user), $user_query_check_login);
    $query = str_replace("%PASS%", addSlashes($md5pass), $query);
    $riga = dammiRigaDaQueryAss($query);
    
    if ($user_confirmed_field_value == "" || $riga[$user_confirmed_field] == $user_confirmed_field_value) {
        $trovato = true;

        $_SESSION[$user_id_field_session_name] = $riga[$user_id_field];
        $_SESSION["userData"] = $riga;

        eseguiDopoLogin();

        $errore = "";        
    } else {
        $errore = "NC";
    }




    if ($trovato) {
        session_regenerate_id();
        $_SESSION['session_id'] = session_id();

        // REGISTRO LOGIN EFFETTUATO
//		$res=mysql_query(
//			"INSERT INTO ".$prefix_table."log (ANA_LOG,ANA_DATA_ORA,ANA_IP,TIPO,ESITO) VALUES ('".$user."','".$data_ora."','".$IP."','LOGIN','S');"
//		);


        return "ok";
    } else {

        // REGISTRO LOGIN NON EFFETTUATO
        //$res=mysql_query(
        //  "INSERT INTO ".$prefix_table."log (ANA_LOG,ANA_DATA_ORA,ANA_IP,TIPO,ESITO) VALUES ('".$user."','".$data_ora."','".$IP."','LOGIN','N');"
        //);

        return $errore;
    }
}

ob_start();
session_start();

$resCheckLogin = checkLogin();

if ($resCheckLogin == "ok") {
    if ($user_redirect_to != "") {
        header("Location: " . $user_redirect_to);
        return;
    }
    header("Location: index.php");
    //header("Location: getTemplate.php?template=elencoClienti.tpl&cache=0");
    
} else {
    header("Location: login.php?errore=" . $resCheckLogin);
}
?>
