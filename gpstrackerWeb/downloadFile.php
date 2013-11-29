<?php
    include("functions.php");

    function mimeTypes($file) {
        if (!is_file($file) || !is_readable($file)) return false;
        $types = array();
        $fp = fopen($file,"r");
        while (false != ($line = fgets($fp,4096))) {
            if (!preg_match("/^\s*(?!#)\s*(\S+)\s+(?=\S)(.+)/",$line,$match)) continue;
            $tmp = preg_split("/\s/",trim($match[2]));
            foreach($tmp as $type) $types[strtolower($type)] = $match[1];
        }
        fclose ($fp);

        return $types;
    }



    $nomeFolder = sys_get_temp_dir() . "/";
    $fullpath = $nomeFolder.getGet("file");
    $fileName = getGet("fileName",basename($fullpath));
    $ext = strtolower(substr(strrchr(getGet("file"),"."),1));




    # read the mime-types
    $mimes = mimeTypes('mime.types');

    # use them ($ext is the extension of your file)
    if (isset($mimes[$ext])) {
        header("Content-Type: ".$mimes[$ext]);    
    }
    if ($ext=="csv") {
        header('Content-type: text/csv');
    }
    
    header("Content-Length: ".@filesize($fullpath));
    header('Cache-Control: private',false);
    header('Content-Disposition: inline; filename="'.$fileName.'"');
    header('Content-Transfer-Encoding: binary');
    header('Pragma: public');  // required
    header('Expires: 0'); // no cache
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    readfile($fullpath); exit;
