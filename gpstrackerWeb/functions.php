<?php
function unsetPost($campo) {
    if (isset($_POST[$campo])) {
        unset($_POST[$campo]);
        unset($_REQUEST[$campo]);
    }
}

function getOrEmpty($arr, $val,$default='') {
    if (isset($arr[$val])) {
        return $arr[$val];
    }

    return $default;
}

function getGet($campo, $default = '') {
    return getOrEmpty($_REQUEST, $campo,$default);    
}

function fixApostrofe($str) {
    return addSlashes($str);
}

function getListaFilesDaCartella($cartella, $estensioniPossibiliTxt="") {
    $files = Array();

    if ($estensioniPossibiliTxt != "") {
        $estensioni = split("|", $estensioniPossibiliTxt);
    } else {
        $estensioni = array();
    }

    if (!file_exists($cartella)) {
        mkdir($cartella);
    }

    if (is_dir($cartella)) {
        if ($dh = opendir($cartella)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != "." && $file != "..") {
                    if (is_dir($file)) {
                        $temp = getListaFilesDaCartella($cartella . "/" . $file, $estensioniPossibiliTxt);
                        for ($t = 0; $t < count($temp); $t++) {
                            $files[] = $file . "/" . $temp[$t];
                        }
                    } else {
                        if (count($estensioni) > 0) {
                            foreach ($estensioni as $estensionePossibile) {
                                if (substr(strtolower($file), -4) == ("." . $estensionePossibile)) {
                                    $files[] = $file;
                                }
                            }
                        } else {
                            $files[] = $file;
                        }
                    }
                }
            }
            closedir($dh);
        }
    }

    return $files;
}

function isAdmin() {
    if (isset($_SESSION["userData"]["OPE_ADM"])) {
        if ($_SESSION["userData"]["OPE_ADM"] == 1) {
            return true;
        }
    }
    return false;
}

function generaQuery($query, $sostituzioni) {
    $testo = $query;
    $cosaCercare = "{(.*?)}";


    while (preg_match("/\\$cosaCercare/", $testo, $matches)) {
        $ricerca = $matches[1];

        $val = $sostituzioni["$ricerca"];
        $testo = preg_replace("/\\" . "{" . $ricerca . "}/", $val, $testo);
    }

    return $testo;
}

function scriviTemp($id, $testo) {
    $nomeFolder = sys_get_temp_dir() . "/lavorazioni/";
    if (!file_exists($nomeFolder)) {
        mkdir($nomeFolder, 0777, true);
    }


    $i=session_id();
    $fh = fopen($nomeFolder . "/" . $i . "_" . $id . ".txt", 'w');
    fwrite($fh, $testo);
    fclose($fh);
}

function scriviLavorazione($lavId = "", $totale = 1, $progress = 0, $testo = "", $stato = "",$altriDatiAggiuntivi=array()) {

    session_write_close();

    if ($lavId == "") {
        $lavId = getGet("lavId","lastLavId");        
    }

    if ($totale!=0) {
        $perc=number_format($progress/$totale*100);
    } else {
        $perc="0";
    }
    
    scriviTemp(
            $lavId
            , json_encode(
                    array(
                        "lavId" => $lavId
                        , "TOTALE" => $totale
                        , "PROGRESS" => $progress
                        , "TESTO" => $testo
                        , "STATO" => $stato
                        , "PERC" => $perc
                        , "ALTRO" => $altriDatiAggiuntivi
                    )
            )
    );
}

function aggiugiMessaggioInCoda($testo="ok",$tipo="m") {
    if (!isset($_SESSION["codaMessaggi"])) {
        $_SESSION["codaMessaggi"]=array();
    }

    $_SESSION["codaMessaggi"][]=array("testo"=>$testo,"tipo"=>$tipo);
}
