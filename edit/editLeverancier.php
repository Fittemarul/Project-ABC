<?php
include("../conf/sessionCheck.php");
include("../conf/db.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

$id = mysql_real_escape_string( $_POST['id'] );
$leverancier = mysql_real_escape_string( $_POST['leverancier']);


//
// Bewerken in database
//
$qry_edit = mysql_query("UPDATE leveranciers SET leverancier_naam = '$leverancier' WHERE id = '$id' LIMIT 1");

if(!$qry_edit){
	die("Kon wijziging niet doorvoeren.");
}else{
	echo "De wijziging werd doorgevoerd.";
}

?>
<script type="text/javascript">
setTimeout('history.go(-1)', 2000);
</script>