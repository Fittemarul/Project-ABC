<?php
include("../conf/db.php");
include("../conf/sessionCheck.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

$allowed_filetypes = array('.csv');
$max_filesize = 524288; // Maximum filesize (currently 0.5MB).

$filename = $_FILES['file']['name']; // Get the name of the file (including file extension).
$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.

if(!in_array($ext,$allowed_filetypes)){
	die('Dit bestandstype is niet toegelaten! Upload enkel CSV bestanden!');
}

if(filesize($_FILES['file']['tmp_name']) > $max_filesize){
	die('Het bestand is te groot en kan niet geupload worden. (Max grootte: 0.5MB)');
}

$input = file_get_contents($_FILES['file']['tmp_name']);

//
// Verwijder ALLE spaties (Voor veiligheid)
//
$input = str_replace(' ', '', $input);

//
// Door de CSV lijnen lopen. Gebruikt automatisch de gebruikte line-endings
// bron: http://stackoverflow.com/questions/1462720/iterate-over-each-line-in-a-string-in-php
//
foreach(preg_split("/(\r?\n)/", $input) as $line)
{
    $velden = explode(";", $line);
	$username = $velden[0];
	$pass = sha1($velden[1]);

	//
	// Excel heeft de neiging om een lege lijn aan het einde van CSV toe te voegen.
	// dit is geen gebruiker en mag dus niet geimporteerd worden!
	//
	if($line == "" || $line == " "){
		continue;
	}

	$qry_insert = mysql_query("INSERT INTO users (username, userpass, time_lastlogon, is_admin, active) VALUES ('$username', '$pass', '0000-00-00 00:00:00', '0', '1')");

	if(!$qry_insert){
		$error = mysql_errno($link);

		if($error == "1062"){

			echo "<br> Gebruiker $username bestaat al! Niet geimporteerd.";
			continue;

		}
		else{
			die("Er heeft zich een fout voorgedaan.");
		}
	}

	echo "<br>&bull; Gebruiker $username toegevoegd.";
}

/*
$rijen = explode("\r", $input);

for($i = 0; $i<= count($rijen) -1; $i++){

	$velden = explode(";", $rijen[$i]);
	$username = $velden[0];
	$pass = sha1($velden[1]);

	$qry_insert = mysql_query("INSERT INTO users (username, userpass, time_lastlogon, is_admin, active) VALUES ('$username', '$pass', '0000-00-00 00:00:00', '0', '1')");

	if(!$qry_insert){
		$error = mysql_errno($link);

		if($error == "1062"){
			echo "<br> Gebruiker $username bestaat al! Niet geimporteerd.";
		}else{
			die("Er heeft zich een fout voorgedaan");
		}
	}

	echo "<br>Gebruiker $username toegevoegd.";
}*/

echo "<br><br> Importeren voltooid.<br>";
echo "<a href='../abc.php'>Klik hier om terug te keren</a><br>";
echo "<a href='../gebruikers.php'>Klik hier om de gebruikers te bekijken.</a>";

?>