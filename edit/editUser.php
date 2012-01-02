<?php
include("../conf/sessionCheck.php");
include("../conf/db.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}


$id = mysql_real_escape_string($_POST['id']);

$username = strtoupper($_POST['username']); // Wordt eerst geconverteerd naar uppercase
$username = mysql_real_escape_string($username); // veilig maken voor db

$actief = ($_POST['actief'] == 'on' ? '1' : '0'); // Is de gebruiker actief?
$admin = ($_POST['admin'] == 'on' ? '1' : '0'); // Is de gebruiker admin?

//
// Bewerken in database
//
$qry_edit = mysql_query("UPDATE users SET username = '$username', is_admin = '$admin', active = '$actief' WHERE id = '$id' LIMIT 1");

if(!$qry_edit){
	die("Kon wijziging niet doorvoeren.");
}else{
	echo "De wijziging werd doorgevoerd.";
}

?>
<script type="text/javascript">
setTimeout('history.go(-1)', 2000);
</script>