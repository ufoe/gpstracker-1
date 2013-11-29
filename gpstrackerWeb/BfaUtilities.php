<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BfaUtilities
 *
 * @author francesco
 */
class BfaUtilities {

    static $formatoData="d/m/Y";
    static $formatoOra="H:i:s";
    static $formatoDataMysql="Y-m-d H:i:s";
    
    static $giorniFestivi=null;
    
    static function dammiDataOdiernaPerMysql() {
        return date(BfaUtilities::$formatoDataMysql,time());
    }
    
    static function dammiDataOdierna() {
        return date(BfaUtilities::$formatoData,time());
    }
    static function dammiOraMinutiSecondiOdierna() {
        return date(BfaUtilities::$formatoOra,time());
    }
    
    static function dammiGiornoSettimana($data) {        
        $miaData = date_create_from_format(BfaUtilities::$formatoData, $data);        
        $date=$miaData->format('Y-m-d');
        $s=strtotime($date);
        return date("w",$s)+1;
    }
    static function dammiAnno($data) {        
        $miaData = date_create_from_format(BfaUtilities::$formatoData, $data);        
        return date("Y",strtotime($miaData->format('Y-m-d')));
    }
    
    static function dateDiff($strDate1_,$strDate2_) {
        $datetime1 = date_create_from_format(BfaUtilities::$formatoData, $strDate1_);
        $datetime2 = date_create_from_format(BfaUtilities::$formatoData, $strDate2_);
        $interval = date_diff($datetime1, $datetime2);
        return $interval->days;
    }
    
    static function dateDiffMysql($strDate1_,$strDate2_) {
        $datetime1 = date_create_from_format("Y-m-d", $strDate1_);
        $datetime2 = date_create_from_format("Y-m-d", $strDate2_);
        $interval = date_diff($datetime1, $datetime2);
        return $interval->days;
    }
    
    static function dammiDataMysql($data) {               
        $miaData = date_create_from_format(BfaUtilities::$formatoData, $data);        
        return $miaData->format('Y-m-d');
    }

    
     static function isGiornoLavorativo($data) {
        $gs=BfaUtilities::dammiGiornoSettimana($data);
        if (! ($gs>1 && $gs<7)) {
            return false;
        }
        
        if (BfaUtilities::$giorniFestivi==null) {
            BfaUtilities::$giorniFestivi=array();
            
            if (file_exists("config/giorniFestivi.txt")) {
                BfaUtilities::$giorniFestivi=file("config/giorniFestivi.txt",FILE_IGNORE_NEW_LINES);            
            }            
        }

        $giorno="";
        for ($t=0;$t<count(BfaUtilities::$giorniFestivi);$t++) {
            $giorno=  strtolower(BfaUtilities::$giorniFestivi[$t]);
            if (strlen($giorno)>4) {                
                if (substr($giorno,-4)=="xxxx") {
                    $anno=BfaUtilities::dammiAnno($data);
                    $giorno=  preg_replace("/(.*)xxxx$/", "$1", $giorno).$anno;
                }
            }
            
            if (BfaUtilities::dateDiff($data,$giorno)==0) {
                return false;
            }
        }
        
        return true;
    }

    static function sottraiNGiorni($data,$numeroGiorniDaSottrarre) {
        $miaData = date_create_from_format(BfaUtilities::$formatoData, $data);        
        $date=$miaData->format('Y-m-d');
        $s=strtotime("-$numeroGiorniDaSottrarre day", strtotime($date));
        return date(BfaUtilities::$formatoData,$s);
    }

    
    
    static function dammiGiornoSeguente($data) {
        $miaData = date_create_from_format(BfaUtilities::$formatoData, $data);        
        $date=$miaData->format('Y-m-d');
        $s=strtotime('+1 day', strtotime($date));
        return date(BfaUtilities::$formatoData,$s);
    }

    static function dammiGiornoPrecedente($data) {
        $miaData = date_create_from_format(BfaUtilities::$formatoData, $data);        
        $date=$miaData->format('Y-m-d');
        $s=strtotime('-1 day', strtotime($date));
        return date(BfaUtilities::$formatoData,$s);
    }
    
    static function sommaNGiorni($data,$numeroGiorniDaSommare) {
        $miaData = date_create_from_format(BfaUtilities::$formatoData, $data);        
        $date=$miaData->format('Y-m-d');
        $s=strtotime("+$numeroGiorniDaSommare day", strtotime($date));
        return date(BfaUtilities::$formatoData,$s);
    }

    
    
    static function sommaNGiorniLavorativi($data,$numeroGiorniDaSommare) {
        while (! BfaUtilities::isGiornoLavorativo($data)) {
            $data=BfaUtilities::dammiGiornoSeguente($data);
        }
        
        for ($t=0;$t<$numeroGiorniDaSommare;$t++)  {
            $data=BfaUtilities::dammiGiornoSeguente($data);   
            
            while (! BfaUtilities::isGiornoLavorativo($data)) {
                $data=BfaUtilities::dammiGiornoSeguente($data);
            }
        }
        
        return $data;
    }
    
    static function daStringMysqlADate($stringa) {
        if (strlen($stringa)>=10) {
            return substr($stringa, 8,2)."/".substr($stringa, 5,2)."/".substr($stringa, 0,4);
        }
        return "";
    }
    
    
    static function daStringADate($stringa) {
        if (strlen($stringa)==8) {
            return substr($stringa, 6,2)."/".substr($stringa, 4,2)."/".substr($stringa, 0,4);
        }
        return "";
    }
    
    static function daDateAString($data) {
        return substr($data, 6,4).substr($data, 3,2).substr($data, 0,2);
    }
    
    
    static function daOraAString($stringa) {
        return substr($stringa, 0,2).substr($stringa, 3,2).substr($stringa, 6,2);
    }
    
    
    
    
    
    static function getValoreCampo($padre,$nome) {
        if (property_exists ( $padre ,$nome)) {
            return $padre->{$nome};
        }
        
        return "";
    }
    
    
    
    static function togliZeriIniziali($str) {
        $str = ltrim($str, '0');        
        return $str ;
    }
    
    static function fixApostrofe($str) {
        $strOri=$str;
        
        $str=  str_replace("'","''",$str);
        $str=  str_replace("\\","\\\\",$str);
        
        $str=  str_replace("\n", "\\n", $str);
        $str=  str_replace("\r", "\\r", $str);
        $str=  str_replace("\r\n", "\\r\\n", $str);
        
        if ($strOri!=$str) {
            $strOri=$strOri;
        }
        
        return $str;
    }
    
}

//echo BfaUtilities::daStringADate("20121130")."<br/>";