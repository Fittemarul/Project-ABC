<?php
include("../conf/sessionCheck.php");
include("../conf/db.php");

$lokaal = mysql_real_escape_string( $_POST['lokaal'] );
$beschrijving = mysql_real_escape_string( $_POST['beschrijving']);
$voorzieningen = mysql_real_escape_string($_POST['voorzieningen']);

$qry_insert = mysql_query("INSERT INTO lokalen (`lokaal`, `beschrijving`, `voorzieningen`) VALUES ('$lokaal', '$beschrijving', '$voorzieningen')");

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