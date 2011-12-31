<?php
include("../conf/sessionCheck.php");
include("../conf/db.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

$pakket = mysql_real_escape_string( $_POST['pakket'] );
$software = mysql_real_escape_string( $_POST['software']);

$qry_insert = mysql_query("INSERT INTO software (`naam`, `software`) VALUES ('$pakket', '$software')");

if(!$qry_insert){
	$error = mysql_errno($link);
	
	if($error == "1062"){
		die("Dit pakket bestaat al!");
	}
}else{
	echo "Het softwarepakket werd toevoegd!";
}

?>
<script type="text/javascript">
setTimeout('history.go(-1)', 2000);
</script>