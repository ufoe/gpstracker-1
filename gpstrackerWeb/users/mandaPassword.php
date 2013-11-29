<?php 
    session_start();

    require_once( '../settings.inc.php' );
    
    require_once( $DR.'/log4php/Logger.php' );
    Logger::configure($DR.'/prg.xml');
    $logger = Logger::getLogger("main");

    require_once( $DR.'/phpmailer/bfaSendEmail.php' );
    

?>
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


	$user = $_POST['email'];

	if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$IP = $_SERVER['HTTP_X_FORWARDED_FOR']; 
	elseif(isset($_SERVER['HTTP_CLIENT_IP']))   
		$IP = $_SERVER['HTTP_CLIENT_IP'];   
	else
		$IP = $_SERVER['REMOTE_ADDR'];   



	// CONNESSIONE AL DATABASE
	$connesione = mysql_connect($mysql_host,$mysql_user,$mysql_pass);
	mysql_select_db($mysql_db,$connesione);


        if(! preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $user)) {
            // ERRORE, INDIRIZO EMAIL
             ?>
                Indirizzo email non valido !
             <?php                 
        } else {


             // CONTROLLO CHE NON CI SIA GIA' UN UTENTE CON LA STESSA EMAIL
            $trovato=false;
            $query=str_replace("%USER%", addslashes($user), $user_send_password);
            $risultato = mysql_query($query);
            while ($riga = mysql_fetch_array($risultato)) {
                    $trovato=true;		
                    //$_SESSION['ANA_LOG']=$riga["ANA_LOG"];
                    //$_SESSION['ANA_PWD']=$riga["ANA_PWD"];
                    //$_SESSION['ANA_TPO']=$riga["ANA_TPO"];
                    
                    $pass=$riga[$user_send_password_field];
                    
                    break; 
            }
            mysql_free_result($risultato);

             if (! $trovato) {
                 // ERRORE, EMAIL NON PRESENTE
                 ?>
                    Impossibile continuare, l'indirizzo di posta elettronica scelto non e' presente nel sistema !
                 <?php             
             } else {
                 // ok mando una mail
                 $sostituzioni=array();

                $sostituzioni["PASSWORDPASSWORD"]=$pass;
                $sostituzioni["USERUSER"]=$user;



                $email=new BfaHtmlEmail();
                $email->setSostituzioni($sostituzioni);                

                if ($email->send($user,"Email con dati password","passwordDimenticata/templateEmailPasswordDimenticata.html")) {
                    // TUTTO OK
                     ?>
                        La password e' stata mandata all'indirizzo di posta specificato.
                     <?php                                                                         
                } else {
                 // ERRORE, EMAIL GIA PRESENTE
                 ?>
                    Errore nella spedizione dei dati.
                 <?php                                                                         
                }
                                
             }

        }

        // CHIUDO CONNESSIONE CON DB
        mysql_close($connesione);


?></center>
	</body>
</html>
