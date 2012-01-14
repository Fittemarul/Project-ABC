<?php
include("../conf/sessionCheck.php");
include("../conf/db.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

$userID = mysql_real_escape_string( $_GET['id'] );
$newPass = mysql_real_escape_string( $_GET['pass']);

// Hashen
$newPass = sha1($newPass);


//
// Bewerken in database
//
$qry_edit = mysql_query("UPDATE users SET userpass = '$newPass' WHERE id = '$userID' LIMIT 1");

if(!$qry_edit){
	die("Kon wijziging niet doorvoeren.");
}else{
	echo "De wijziging werd doorgevoerd.";
}

?>
<script type="text/javascript">
setTimeout('history.go(-1)', 2000);
</script>