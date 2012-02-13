<?php
/*
 * Script oorspronkelijk van: http://davidwalsh.name/backup-mysql-database-php
 *
 * Aangepast zodat dit werkt voor 1 database en de output in gzip is
 * om plaats en bandbreedte te sparen.
 *
 */

include("conf/sessionCheck.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

include("conf/db.php");

$tables = array();
$result = mysql_query('SHOW TABLES');
while($row = mysql_fetch_row($result)){
	$tables[] = $row[0];
}

//cycle through
foreach($tables as $table){
	$result = mysql_query('SELECT * FROM '.$table);
	$num_fields = mysql_num_fields($result);
  
	$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
	$return.= $row2[1].";\n\n";
  
	for ($i = 0; $i < $num_fields; $i++) {
		while($row = mysql_fetch_row($result)){
			
			$return.= 'INSERT INTO '.$table.' VALUES(';
			
			for($j=0; $j<$num_fields; $j++) {
				$row[$j] = addslashes($row[$j]);
				$row[$j] = ereg_replace("\n","\\n",$row[$j]);
				if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
 				if ($j<($num_fields-1)) { $return.= ','; }
      		}

      		$return.= ");\n";
    	}
	}
	
	$return.="\n\n\n";
}


$filename= 'db-backup-'.date("Ymd-His").'.sql.gz';

//save file
/*$handle = fopen('backups/'.$filename,'w+');
fwrite($handle,gzcompress($return, 9));
fclose($handle);*/

$gz = gzopen('backups/'.$filename, "w9");
gzwrite($gz, $return);
gzclose($gz);


echo "Alles alles goed ging, is de database gebackupt op de server.<br>";
echo "<a href='backups/$filename'>Klik hier om de backup te downloaden (Gzip archief)</a>";


?>