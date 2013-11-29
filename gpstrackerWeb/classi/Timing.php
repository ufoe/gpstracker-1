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
class Timing extends OggettoGenerico {
	public $tim_id,$tim_sessione,$tim_punto,$tim_dal,$tim_al,$tim_durata;


    public $elenco=array();
    
    var $lastTime=0;
    
    public function __construct() {
        global $mysql_db;
        $this->mysql_db=$mysql_db;
        $this->idField="tim_id";
        $this->nomeTabella="timing";       
        
        //$this->getTableStruct(); // la tabella non esiste
        
        $this->startT();
    }
    
    function ogniSecondo() {
        if (time()-$this->lastTime>=1) {
            $this->lastTime=time();
        }
    }
    
    function startT() {
        $this->tim_dal=  round(microtime(true) * 1000);
    }
    function stopT() {
        $this->tim_al=  round(microtime(true) * 1000);
        $this->tim_durata=$this->tim_al-$this->tim_dal;        
    }
    
    function stopAndPrint() {
        $this->stopT();
        //global $logger;
        //$logger->info("timing: ".$this->tim_durata);
    }

    function parzialeAndPrint($testo='') {
        $this->stopT();
        $this->elenco[]=array($this->tim_durata,$testo);
        //global $logger;
        //$logger->info("timing $testo: ".$this->tim_durata);
        $this->tim_dal=$this->tim_al;
    }

}
