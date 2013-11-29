<?php
    #DB CONNECTION INFO
    global $mysql_host,$mysql_user,$mysql_pass,$mysql_db,$prefix_table;
    $mysql_host="127.0.0.1";
    $mysql_user="root";
    $mysql_pass="";
    $mysql_db="test2";
    $prefix_table="";


    #EMAIL SETTINGS
    $mail_Host="";  // specify main and backup server
    $mail_SMTPAuth = false;     // turn on SMTP authentication
    $mail_Username="";
    $mail_Password="";
    $mail_From="";
    $mail_FromName="";

    global $RICHIEDI_CONFERMA_SU_ABBANDONO_PAGINA;
    $RICHIEDI_CONFERMA_SU_ABBANDONO_PAGINA=false;

    global $CARTELLA_SITO,$DR,$CARTELLA_IMPORTAZIONE,$CARTELLA_FATTI,$CARTELLA_XML;
    $CARTELLA_SITO="/gps";
    $DR=$_SERVER["DOCUMENT_ROOT"].$CARTELLA_SITO;

    
