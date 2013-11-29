<?php session_start();?><html>
	<body background="../logo tea in acqua.gif">
            <br/>
            <br/>
            <br/>
            <center><? 
            
            require("../settings.inc.php");
            require_once("user_config.php");



	$user = $_POST['email'];
	$pass = $_POST['password'];
        $pass2 = $_POST['password2'];




	// CONNESSIONE AL DATABASE
	$connesione = mysql_connect($mysql_host,$mysql_user,$mysql_pass);
	mysql_select_db($mysql_db,$connesione);


        if(! eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $user)) {
            // ERRORE, INDIRIZO EMAIL
             ?>Indirizzo email non valido !<?php                 
        } else {
            if ($pass=="") {
                // ERRORE, EMAIL GIA PRESENTE
                 ?>La password non puo' essere vuota !<?php                 
            } else {

                if ($pass!=$pass2) {
                // ERRORE, EMAIL GIA PRESENTE
                 ?>Le password non coincidono !<?php                 
                } else {
                     // CONTROLLO CHE NON CI SIA GIA' UN UTENTE CON LA STESSA EMAIL
                    $trovato=false;
                    $query=str_replace("%USER%", addslashes($user), $user_new_check_already_exists);
                    $risultato = mysql_query($query);
                    while ($riga = mysql_fetch_array($risultato)) {
                            $trovato=true;		
                            break; 
                    }
                    mysql_free_result($risultato);

                     if ($trovato) {
                         // ERRORE, EMAIL GIA PRESENTE
                         ?>Impossibile continuare, l'indirizzo di posta elettronica scelto e' gia' presente nel sistema !<?php             
                     } else {
                         // ok mando una mail
                         require_once("../mandaEmail/email.php");

                         $allegati=array();
                         $sostituzioni=array();

                        $sostituzioni["PASSWORDPASSWORD"]=$pass;
                        $sostituzioni["USERUSER"]=$user;

                        $uri="http://".$_SERVER["SERVER_NAME"].substr($_SERVER['REQUEST_URI'],0,-strlen(basename($_SERVER['SCRIPT_FILENAME'])))."attivaUtente.php?id=".md5($user);
                        $sostituzioni["LINKATTIVAZIONE"]=$uri;
                        if (mandaMailConAllegati($user,$allegati,"Conferma creazione nuovo account","templateEmailNewUser.html",$sostituzioni)) {
                            $query=str_replace("%USER%", addslashes($user), $user_new_insert);
                            $query=str_replace("%PASS%", addslashes($pass), $query);
                            $res= mysql_query($query);
                            if ($res) {
                                // TUTTO OK
                                 ?>L'account e' stato creato, riceverete a breve una mail di conferma per convalidare l'utente.<?php                                                                         
                            } else {
                                 ?>Errore nel creare l'account.<?php                                                                         
                            }
                        } else {
                         // ERRORE, EMAIL GIA PRESENTE
                         ?>Errore nella spedizione della mail di conferma, riprovare in un secondo momento e controllare l'indirizzo inserito.<?php                                                                         
                        }
                     }
                }
            }
        }

        // CHIUDO CONNESSIONE CON DB
        mysql_close($connesione);


?></center>
	</body>
</html>
