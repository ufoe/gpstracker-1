<?php
/**
 * Description of Monitoraggio
 *
 * @author francesco
 */


if (file_exists('OggettoGenerico.php')) {
    include_once 'OggettoGenerico.php';
} else {
    include_once '../OggettoGenerico.php';
}


class Monitoraggio extends OggettoGenerico {
    var $mon_id=0;
    var $mon_cod="";
    var $mon_des="";
    var $mon_val=0;
    var $mon_max=0;
    var $dbh=null;

    var $lastTime=0;




    public function __construct() {
        global $mysql_db;
        $this->mysql_db=$mysql_db;
        $this->idField="mon_id";
        $this->nomeTabella="monitoraggio";       
        
        $this->getTableStruct();
    }

    function salvatiOgniSecondo() {
        if (time()-$this->lastTime>=1) {
            $this->salvati();

            $this->lastTime=time();
        }
    }
    
    function cancellaTuttiConMioCodice() {
        query( "delete from monitoraggio where  mon_cod='$this->mon_cod';");
    }

    function caricatiConMioCodice() {
        $this->fromArray(dammiRigaDaQueryAss("select * from monitoraggio where  mon_cod='$this->mon_cod';"));
    }

}

if (
    getGet("mon_cod")!="" &&
    getGet("tipo")=="txt"
) {
    $res=getGet("mon_cod");

    $m=new Monitoraggio();
    $m->mon_cod=getGet("mon_cod");
    $m->caricatiConMioCodice();

    echo $m->mon_des." ".$m->mon_val."/".$m->mon_max;
}

if (
    getGet("mon_cod")!="" &&
    getGet("tipo")=="json"
) {
    $res=getGet("mon_cod");

    $m=new Monitoraggio();
    $m->mon_cod=getGet("mon_cod");
    $m->caricatiConMioCodice();

    unset ($m->dbh);// serve per evitare warning in json
    $arr = (array) $m;
    echo json_encode($arr);

}