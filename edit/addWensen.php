<?php
include("../conf/sessionCheck.php");
include("../conf/db.php");

$klas = mysql_real_escape_string( $_POST['klas'] );
$vak = mysql_real_escape_string( $_POST['vak'] );
$uren = mysql_real_escape_string( $_POST['uren'] );
$lokaal = mysql_real_escape_string( $_POST['lokaal'] );
$software = mysql_real_escape_string( $_POST['software'] );
$notes = mysql_real_escape_string( $_POST['notes'] );

$leerkracht = mysql_real_escape_string($username); // huidige gebruiker

$qry_insert = mysql_query("INSERT INTO wensen (`date`, `leerkracht`, `vak`, `klas`, `uren`, `lokaal`, `software`, `notes`)
							VALUES (NOW(), '$leerkracht', '$vak', '$klas',  '$uren', '$lokaal', '$software', '$notes')") or die(mysql_error());

if(!$qry_insert){
	echo "Oops. Uw wens kon niet bewaard worden.";
}else{
	echo "Uw wens werd toegevoegd";
}

?>
<script type="text/javascript">
setTimeout('history.go(-1)', 2000);
</script>