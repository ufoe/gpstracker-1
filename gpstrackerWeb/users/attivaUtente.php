<?php session_start();?>
<html>
	<body>
            <br/>
            <br/>
            <br/>
            <center><? require("user_config.php"); ?><?


	$anno=date("Y");
	$mese=date("m");
	$giorno=date("d");
	$ore=date("H");
	$minuti=date("i");
	$secondi=date("s");
	
	// SISTEMO PER FUSO ORARIO
	$data_server = mktime ($ore+8,$minuti,$secondi,$mese ,$giorno,$anno);	
	$anno=date("Y",$data_server);
	$mese=date("m",$data_server);
	$giorno=date("d",$data_server);
	$ore=date("H",$data_server);
	$minuti=date("i",$data_server);
	$secondi=date("s",$data_server);	
		

	$data_db=$anno.$mese.$giorno;
	$orario_db=$ore.$minuti.$secondi;
	$data_ora=$anno."/".$mese."/".$giorno." ".$ore.".".$minuti.".".$secondi;


	$id = $_GET['id'];

         if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$IP = $_SERVER['HTTP_X_FORWARDED_FOR']; 
	elseif(isset($_SERVER['HTTP_CLIENT_IP']))   
		$IP = $_SERVER['HTTP_CLIENT_IP'];   
	else
		$IP = $_SERVER['REMOTE_ADDR'];   



	// CONNESSIONE AL DATABASE
	$connesione = mysql_connect($mysql_host,$mysql_user,$mysql_pass);
	mysql_select_db($mysql_db,$connesione);



         // CONTROLLO CHE NON CI SIA GIA' UN UTENTE CON LA STESSA EMAIL
        $trovato=false;
        $userTrovato="";        
        $risultato = mysql_query($user_new_enable_check_exists);
        while ($riga = mysql_fetch_array($risultato)) {
                
                if ($id==md5($riga[$user_new_enable_check_field])) {
                    $userTrovato=$riga[$user_new_enable_check_field];
                    $trovato=true;		
                    break;
                }
                //$_SESSION['ANA_LOG']=$riga["ANA_LOG"];
                //$_SESSION['ANA_PWD']=$riga["ANA_PWD"];
                //$_SESSION['ANA_TPO']=$riga["ANA_TPO"];
        }
        mysql_free_result($risultato);

        if ($userTrovato!="") {

            $query=str_replace("%USER%", addslashes($userTrovato), $user_new_enable_update_enable);
            $res= mysql_query($query);
            if ($res) {
                // TUTTO OK
                 ?>
                    L'account e' stato confermato, potete procedere ora al <a href="login.php">login</a>
                 <?php                                                                         
            } else {
                 ?>
                    Errore nel confermare l'account.
                 <?php                                                                         
            }                
        } else {
             ?>
                Errore nellindividuare l'account.
             <?php                                                                                         
        }


        // CHIUDO CONNESSIONE CON DB
        mysql_close($connesione);


?></center>
	</body>
</html>
