<?php
include("../conf/sessionCheck.php");
include("../conf/db.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

$lokaal = mysql_real_escape_string( $_POST['lokaal'] );
$beschrijving = mysql_real_escape_string( $_POST['beschrijving']);
$voorzieningen = mysql_real_escape_string($_POST['voorzieningen']);
$aantalpersonen = mysql_real_escape_string($_POST['aantalpersonen']);
$gekoppelde_image = mysql_real_escape_string( $_POST['image'] );

$qry_insert = mysql_query("INSERT INTO lokalen (`lokaal`, `beschrijving`, `voorzieningen`, `aantalpersonen`, `image`) VALUES ('$lokaal', '$beschrijving', '$voorzieningen', '$aantalpersonen', '$gekoppelde_image')");

if(!$qry_insert){
	$error = mysql_errno($link);

	if($error == "1062"){
		die("Dit lokaal bestaat al in de database!");
	}
}else{
	echo "Het lokaal werd toevoegd!";
}

?>
<script type="text/javascript">
setTimeout('history.go(-1)', 2000);
</script>