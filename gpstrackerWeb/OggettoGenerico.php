<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'inclusione.inc.php';
include_once 'ConnessioneDB.php';

/**
 * Description of OggettoGenerico
 *
 * @author francesco
 */
class OggettoGenerico {

    var $mysql_db = "";
    var $nomeTabella = "";
    var $idField = "";
    public static $idFieldIsMultiple = null;
    public static $tableStruct = array();
    public static $tipoCampi = array();
    
    //public static $quotePG = '"';
    public static $quotePG = '';
    
    //var $altriCampiCaricati=array();

    // controllo se chiavi univoche vuote
    private function  isChiaveUnivocheVuote() {
        if (static::$idFieldIsMultiple==null) {
            return $this->{$this->idField} == 0 || $this->{$this->idField} == "";
        } 
        
        // ho piu' chiavi univoche
        foreach (static::$idFieldIsMultiple as $nomeChiave ) {
            $c=$this->{$nomeChiave};
            if ($c === 0 || $c === "") {
                return true;
            }
        }
        
        return false;
    }


    function salvati() {
        if ($this->isChiaveUnivocheVuote()) {
            return $this->salvatiIns();
        } else {
            return $this->salvatiUpdate();
        }
    }

    function cancellati() {
        global $connesione;
        if (! $this->isChiaveUnivocheVuote()) {
            $fields = $this->getTableStruct();
            $reflectionObject = new ReflectionObject($this);

            $query = "DELETE FROM $this->nomeTabella ";
            $query.=" where ";
            $messoUno = false;
            foreach ($fields as $key => $value) {
                if ($this->hasIdField($value)) {
                    if ($reflectionObject->hasProperty($value)) {
                        if ($messoUno) {
                            $query.=" AND ";
                        }

                        $query.=static::$quotePG.$value.static::$quotePG . "=" . "'" . $this->fixApostrofe($this->{$value}) . "'";
                        $messoUno = true;
                    }
                }
            }

            mysql_select_db($this->mysql_db, $connesione);
            $execution = query($query);
            return $execution;            
        }
    }

    function getTableStruct() {
        global $connesione;

        if (!isset(static::$tableStruct[$this->getMyClassName()])) {
            //echo $this->getMyClassName()."\r\n";
            $ts=array();
            mysql_select_db($this->mysql_db, $connesione);
            $arr = fetchArray(query("SHOW COLUMNS FROM $this->nomeTabella"));
            for ($t = 0; $t < count($arr); $t++) {
                $riga = $arr[$t];
                
                static::$tipoCampi[$riga[0]]=$riga["Type"];
                $ts[] = $riga[0];                
            }
            static::$tableStruct[$this->getMyClassName()] = $ts;
            
            static::$idFieldIsMultiple=explode( "," , $this->idField );
            if (count(static::$idFieldIsMultiple)<2) {
                static::$idFieldIsMultiple=null;
            }            
        }
        
        
        return static::$tableStruct[$this->getMyClassName()];
    }

    public function newMe() {
        return new static();
    }

    public function getMyClassName() {
        return get_class($this);
    }

    private function fixApostrofe($str) {
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

    private function hasIdField($value) {
        if (static::$idFieldIsMultiple==null) {
            return $value == $this->idField;
        }
        
        return in_array($value, static::$idFieldIsMultiple);
    }
    
    function getChiaveUnivocaValue() {
        if (static::$idFieldIsMultiple==null) {
            return $this->{$this->idField};
        } else {            
            $res="";$k="";
            // ho piu' chiavi univoche
            foreach (static::$idFieldIsMultiple as $nomeChiave ) {
                $c=$this->{$nomeChiave};
                $res.=$k.$c;
                $k=",";
            }
            
            return $res;
        }
        
    }
    
    
    function sistemaCampoPerSalvataggioDB($nomeCampo) {
        if (static::$tipoCampi[$nomeCampo]=="timestamp" || static::$tipoCampi[$nomeCampo]=="date") {
            if (preg_match("/(\d\d).(\d\d).(\d\d\d\d)/",$this->{$nomeCampo}, $matches)) {
                $value=$matches[3]."-".$matches[2]."-".$matches[1];
            } else {
                $value=$this->fixApostrofe($this->{$nomeCampo});
            }
        } else {
            $value=$this->fixApostrofe($this->{$nomeCampo});
        }       
        
        return $value;
    }
    
    function salvatiIns() {
        global $connesione,$logger;
        $fields = $this->getTableStruct();

        $reflectionObject = new ReflectionObject($this);
        //$vars=get_object_vars($this);

        $query = "insert into $this->nomeTabella (";

        $valori = "";
        $messoUno = false;
        foreach ($fields as $key => $value) {
            if (
                ( static::$idFieldIsMultiple==null && (! $this->hasIdField($value)))
                || ( static::$idFieldIsMultiple!=null)
            ) {
            //if (! $this->hasIdField($value)) {
                if ($reflectionObject->hasProperty($value)) {
                    if ($messoUno) {
                        $query.=",";
                        $valori.=",";
                    }
                    $query.=static::$quotePG.$value.static::$quotePG;
                    $valori.="'" . $this->sistemaCampoPerSalvataggioDB($value) . "'";
                    $messoUno = true;
                }
            }
        }

        $query.=") values ( " . $valori . ");";
        mysql_select_db($this->mysql_db, $connesione);
$logger->info($query);
        $execution = query($query);

       

        if (static::$idFieldIsMultiple==null) {
            $this->{$this->idField} = mysql_insert_id();
        }
        return $execution;
    }

    function salvatiUpdate() {
        global $connesione;
        $fields = $this->getTableStruct();

        
        $reflectionObject = new ReflectionObject($this);
        
        $query = "update $this->nomeTabella set ";

        $messoUno = false;
        foreach ($fields as $key => $nomeCampo) {
            if (! $this->hasIdField($nomeCampo)) {
                if ($reflectionObject->hasProperty($nomeCampo)) {
                    if ($messoUno) {
                        $query.=",";
                    }
                    
                    $value=$this->sistemaCampoPerSalvataggioDB($nomeCampo);
                    $query.=static::$quotePG.$nomeCampo.static::$quotePG . "=" . "'$value'";
                    $messoUno = true;
                }
            }
        }

        $query.=" where ";
        $messoUno = false;
        foreach ($fields as $key => $value) {
            if ($this->hasIdField($value)) {
                if ($reflectionObject->hasProperty($value)) {
                    if ($messoUno) {
                        $query.=" AND ";
                    }

                    $query.=static::$quotePG.$value.static::$quotePG . "=" . "'" . $this->fixApostrofe($this->{$value}) . "'";
                    $messoUno = true;
                }
            }
        }


        
        
        
        
        
        mysql_select_db($this->mysql_db, $connesione);// POSTGRES
        $execution = query($query);
        return $execution;
    }

    function settatiInBloccoDaQuery($query) {
        global $connesione;
        $vars = get_object_vars($this);

        mysql_select_db($this->mysql_db, $connesione);
        $arr = fetchArray(query($query));

        $res = array();

        for ($t = 0; $t < count($arr); $t++) {
            $riga = $arr[$t];

            $temp = $this->newMe();

            foreach ($this->getTableStruct() as $key) {
                if (array_key_exists($key, $vars)) {
                    $temp->{$key} = $riga[$key];
                    //} else {
                    //echo "salto:$key\r\n";                    
                }
            }
            
//             foreach ($riga as $key=>$value) {
//                if (array_key_exists($key, $vars)) {
//                    $temp->{$key} = $value;
//                } else {
//                    if (!is_numeric($key)) {
//                        $temp->altriCampiCaricati[$key]=$value;
//                    }
//                    //echo "salto:$key\r\n";                    
//                }
//            }

            $res[] = $temp;
        }

        return $res;
    }

    function ricaricatiDaQuery($query) {
        $res = $this->settatiInBloccoDaQuery($query);
        if (count($res) > 0) {
            $riga = $res[0];
            $vars = get_object_vars($riga);

            $fields = $this->getTableStruct();
            foreach ($fields as $key => $value) {
                if (array_key_exists($value, $vars)) {
                    $this->{$value} = $vars[$value];
                }
            }
            //foreach ($vars as $key => $value) {
                //$this->{$key} = $value;
            //}
            return true;
        }

        return false;
    }

    function settati() {
        if (static::$idFieldIsMultiple==null) {
            $key = $this->idField;
            $value = $this->{$this->idField};
            return $this->ricaricatiDaQuery("select * from " . $this->nomeTabella . " where ".static::$quotePG.$key.static::$quotePG."='$value'");            
        } else {
            $query="";
            
            $fields = $this->getTableStruct();
            $reflectionObject = new ReflectionObject($this);

            
            $query.=" where ";
            $messoUno = false;
            foreach ($fields as $key => $value) {
                if ($this->hasIdField($value)) {
                    if ($reflectionObject->hasProperty($value)) {
                        if ($messoUno) {
                            $query.=" AND ";
                        }

                        $query.=$value . "=" . "'" . $this->fixApostrofe($this->{$value}) . "'";
                        $messoUno = true;
                    }
                }
            }
            
            return $this->ricaricatiDaQuery("select * from " . $this->nomeTabella . " $query");
        }

    }

    function __toString() {
        $fields = $this->getTableStruct();
        $reflectionObject = new ReflectionObject($this);
        
        $query = "";
        
        $messoUno = false;
        foreach ($fields as $key => $value) {
            if ($reflectionObject->hasProperty($value)) {
                if ($messoUno) {
                    $query.="\t";
                }

                $query.=$value . "=" . $this->fixApostrofe($this->{$value});
                $messoUno = true;
            }
        }

        return $query;
        
    }

    function toArray() {
        $fields = $this->getTableStruct();
        $reflectionObject = new ReflectionObject($this);
        
        $a=array();
        
        foreach ($fields as $key => $value) {
            if ($reflectionObject->hasProperty($value)) {
                //$a[$value]=$this->fixApostrofe($this->{$value});
                $a[$value]=$this->{$value};
            }
        }

        return $a;
    }
    
    var $fromArray_altriDati=null;
    function &getFromArrayAltriDati() {
        if ($this->fromArray_altriDati==null) {
            $this->fromArray_altriDati=array();
        }
        return $this->fromArray_altriDati;
    }
    function fromArray($arrayConDati) {
        $fields = $this->getTableStruct();
        $reflectionObject = new ReflectionObject($this);
        
        foreach ($arrayConDati as $key => $value) {
            if ($reflectionObject->hasProperty($key)) {
                //if (isset($arrayConDati[$value])) {
                    $this->{$key}=$value;                
                //}
            } else {
                    // qui mi hai passato nell'array un dato che non appartiene ai miei parametri
                   $arr=&$this->getFromArrayAltriDati();
                   $arr[$key]=$value;
                
            }
        }
    }
    
}

?>
