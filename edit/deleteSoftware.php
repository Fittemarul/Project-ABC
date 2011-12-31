<?php

include("../conf/db.php");
include("../conf/sessionCheck.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

$softID = mysql_real_escape_string($_GET['id']);

$qry_delete = mysql_query("DELETE FROM software WHERE id = '$softID'");

if($qry_delete){
	echo "Het softwarepakket werd verwijderd.";
	echo "<br>U wordt zodadelijk teruggestuurd naar de vorige pagina.";
}else{
	echo "Er heeft zich een fout voorgedaan.";
}

?>

<script type="text/javascript">
setTimeout('history.go(-1)', 3000);
</script>