<?php
include("../conf/sessionCheck.php");
include("../conf/db.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

$pakket = mysql_real_escape_string( $_POST['pakket'] );
$software = mysql_real_escape_string( $_POST['software']);
$id = mysql_real_escape_string($_POST['id']);


//
// Bewerken in database
//
$qry_edit = mysql_query("UPDATE software SET naam = '$pakket', software = '$software' WHERE id = '$id' LIMIT 1");

if(!$qry_edit){
	die("Kon wijziging niet doorvoeren.");
}else{
	echo "De wijziging werd doorgevoerd.";
}

?>
<script type="text/javascript">
setTimeout('history.go(-1)', 2000);
</script>