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
class Config extends OggettoGenerico {

    public $con_id, $con_cod, $con_des, $con_val, $con_tpo;

    public function __construct() {
        global $mysql_db;
        $this->mysql_db = $mysql_db;
        $this->idField = "con_id";
        $this->nomeTabella = "config";

        $this->getTableStruct();
    }


    public static function creaTabella() {
        query("CREATE TABLE IF NOT EXISTS config (
        `con_id` int(11) NOT NULL AUTO_INCREMENT,
        `con_cod` varchar(255) NOT NULL DEFAULT '',
        `con_val` varchar(255) NOT NULL DEFAULT '',
        `con_tpo` enum('testo','numero','euro','bool') NOT NULL default 'testo',
        `con_des` varchar(255) NOT NULL DEFAULT '',
        PRIMARY KEY (`con_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

    }
    
    static private $config=null;
    
    public static function getConfigs() {
        if (self::$config===null) {
            $c=new Config();
            self::$config=$c->settatiInBloccoDaQuery("select * from ".$c->nomeTabella);
        }
        
        return self::$config;
    }
    
    public static function getConfigObject($codice) {
        foreach (self::getConfigs() as $c) {
            if ($c->con_cod==$codice) {
                return $c;
            }
        }
        
        return null;
    }
    
    public static function getConfig($codice,$default="") {
        $c=self::getConfigObject($codice);
        if ($c!=null) {
            return $c->con_val;
        }
        
        return $default;
    }

    public static function addConfig($config_) {
        static::getConfigs();
        $config_->salvati();
        self::$config[]=$config_;
    }
    
}
