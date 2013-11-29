<?php

if (file_exists('OggettoGenerico.php')) {
    include_once 'OggettoGenerico.php';
} else {
    include_once '../OggettoGenerico.php';
}

/**
 * Description of Esito
 *
 * @author francesco
 */
class Point extends OggettoGenerico {

    public $PNT_ID, $PNT_AID="0000000000000000", $PNT_SES=0,$PNT_DTA, $PNT_LAT=0, $PNT_LON=0;
    public $PNT_SPEED=0, $PNT_BEARING=0, $PNT_SIGNAL=0, $PNT_PROVIDER=0, $PNT_SATS=0, $PNT_SATSFIX=0;

    public function __construct() {
        global $mysql_db;
        $this->mysql_db = $mysql_db;
        $this->idField = "PNT_ID";
        $this->nomeTabella = "points";

        $this->getTableStruct();
        
        
        // defaults
        $this->PNT_DTA=  BfaUtilities::dammiDataOdiernaPerMysql();
        
    }


    
    
    
}
