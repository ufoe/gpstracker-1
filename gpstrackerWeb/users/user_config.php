<?php
    require_once("settings.inc.php");
    
    // PARTE SETTAGGIO USER
    $user_new_user_enabled=false;
    $user_new_user_forgot_password=true;
    
    $user_table="operatori";
    
    global $user_query_check_login,$user_id_field,$user_id_field_session_name;
    global $user_confirmed_field,$user_confirmed_field_value;
    global $user_redirect_to;
    $user_query_check_login="SELECT * FROM $user_table WHERE OPE_DES='%USER%' AND OPE_PWD='%PASS%';";
    $user_id_field="OPE_ID";
    $user_id_field_session_name="OPE_ID";
    $user_confirmed_field="";
    $user_confirmed_field_value="";
    $user_redirect_to="";

    // PARTE CREAZIONE NUOVO UTENTE
    //$user_new_check_already_exists="SELECT * FROM $user_table WHERE OPE_DES='%USER%';";
    //$user_new_insert="INSERT INTO $user_table (OPE_DES,OPE_PWD,OPE_NOME,OPE_ADM,OPE_UTE,OPE_SYS) values ('%USER%','%PASS%','%USER%',0,0,0);";

    // PARTE ATTIVAZIONE NUOVO UTENTE
    //$user_new_enable_check_exists="SELECT * FROM $user_table;";
    //$user_new_enable_check_field="OPE_DES";
    //$user_new_enable_update_enable="UPDATE $user_table SET OPE_UTE=1 WHERE OPE_DES='%USER%';";

    // PARTE MANDA PASSWORD
    //$user_send_password="SELECT * FROM $user_table WHERE OPE_EMAIL='%USER%';";
    //$user_send_password_field="OPE_PWD";
    
    function eseguiDopoLogin() {
//        $ana=new Anagrafica();
//        $ana->ANA_ID=$_SESSION["userData"]["ANA_ID"];
//        $ana->settati();
//        $_SESSION["userData"]["anagrafica"]=$ana;
        
        
    }
