<?php
include("../conf/sessionCheck.php");
include("../conf/db.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

$lokaal = mysql_real_escape_string( $_POST['lokaal'] );
$beschrijving = mysql_real_escape_string( $_POST['beschrijving']);
$voorzieningen = mysql_real_escape_string($_POST['voorzieningen']);
$id = mysql_real_escape_string($_POST['id']);
$aantalpersonen = mysql_real_escape_string($_POST['aantalpersonen']);
$gekoppelde_image = mysql_real_escape_string( $_POST['image'] );


//
// Bewerken in database
//
$qry_edit = mysql_query("UPDATE lokalen SET lokaal = '$lokaal', beschrijving = '$beschrijving', voorzieningen = '$voorzieningen', aantalpersonen = '$aantalpersonen', image='$gekoppelde_image' WHERE id = '$id' LIMIT 1");

if(!$qry_edit){
	die("Kon wijziging niet doorvoeren.");
}else{
	echo "De wijziging werd doorgevoerd.";
}

?>
<script type="text/javascript">
setTimeout('history.go(-1)', 2000);
</script>