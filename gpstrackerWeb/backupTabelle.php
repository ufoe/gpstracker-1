<?php
    include_once 'login.php';


    /* backup the db OR just a table */
    function backup_tables($tables = '*') {

            //get all of the tables
            if($tables == '*') {
                    $tables = array();
                    $result = mysql_query('SHOW TABLES');
                    while($row = mysql_fetch_row($result)) {
                            $tables[] = $row[0];
                    }
            } else {
                    $tables = is_array($tables) ? $tables : explode(',',$tables);
            }

            
            
            $nomeFolder = sys_get_temp_dir() . "/";
            $fullpath = $nomeFolder.'db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql';
            
            $handle = fopen($fullpath,'w+');
            
            $return="SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";
SET AUTOCOMMIT=0;
START TRANSACTION;
";
            
            
            //cycle through
            foreach($tables as $table) {
                    $tabTxt="";
                
                    $result = mysql_query('SELECT * FROM '.$table);
                    $num_fields = mysql_num_fields($result);

                    //$return.= 'DROP TABLE '.$table.';';
                    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
                    $tabTxt.= "\n\n".$row2[1].";\n\n";

                    $tabTxt = preg_replace("/CREATE TABLE/","CREATE TABLE IF NOT EXISTS",$tabTxt);
                    
                    
                    $tabTxt.= 'TRUNCATE TABLE '.$table.";\n";

                    
                    for ($i = 0; $i < $num_fields; $i++)  {
                            while($row = mysql_fetch_row($result)) {
                                    $tabTxt.= 'INSERT INTO '.$table.' VALUES(';
                                    for($j=0; $j<$num_fields; $j++) 
                                    {
                                            $row[$j] = addslashes($row[$j]);
                                            $row[$j] = preg_replace("/\n/","\\n",$row[$j]);
                                            if (isset($row[$j])) { $tabTxt.= '"'.$row[$j].'"' ; } else { $tabTxt.= '""'; }
                                            if ($j<($num_fields-1)) { $tabTxt.= ','; }
                                    }
                                    $tabTxt.= ");\n";
                            }
                    }
                    $tabTxt.="\n\n\n";
                    
                    $return.=$tabTxt;
                    
                    if ($return!=="") {
                        fwrite($handle,$return);$return="";
                    }
                    
            }

            
            
            $return.="SET FOREIGN_KEY_CHECKS=1;
COMMIT;
";
            
            
            //save file
            
            if ($return!=="") {
                fwrite($handle,$return);$return="";
            }
            
            fclose($handle);
            
            return $fullpath;
    }

    
    $fullpath=backup_tables(getGet("tabelle","*"));
    
    
    
    if (getGet("testo","")=="1") {
        header('Content-type: text/plain');
        readfile($fullpath);
    }
    
    
    if (getGet("scarica","")=="1") {
        header('Content-type: text/plain');
        header("Content-Length: ".@filesize($fullpath));
        header('Cache-Control: private',false);
        header('Content-Disposition: inline; filename="'.basename($fullpath).'"');
        header('Content-Transfer-Encoding: binary');
        header('Pragma: public');  // required
        header('Expires: 0'); // no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        readfile($fullpath); exit;
    }