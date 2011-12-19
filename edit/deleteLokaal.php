<?php

include("../conf/db.php");
include("../conf/sessionCheck.php");

$lokaalID = mysql_real_escape_string($_GET['id']);

$qry_delete = mysql_query("DELETE FROM lokalen WHERE id = '$lokaalID'");

if($qry_delete){
	echo "Het lokaal werd verwijderd.";
	echo "<br>U wordt zodadelijk teruggestuurd naar de vorige pagina.";
}else{
	echo "Er heeft zich een fout voorgedaan.";
}

?>

<script type="text/javascript">
setTimeout('history.go(-1)', 3000);
</script>