<?php
include("../conf/sessionCheck.php");
include("../conf/db.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

$leverancier = mysql_real_escape_string( $_POST['leverancier'] );

$qry_insert = mysql_query("INSERT INTO leveranciers (`leverancier_naam`) VALUES ('$leverancier')");

if(!$qry_insert){
	$error = mysql_errno($link);
	
	if($error == "1062"){
		die("Deze leverancier staat al in de database!");
	}
}else{
	echo "De leverancier werd toevoegd!";
}

?>
<script type="text/javascript">
setTimeout('history.go(-1)', 2000);
</script>