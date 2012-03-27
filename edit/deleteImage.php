<?php

include("../conf/db.php");
include("../conf/sessionCheck.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

$image_id = mysql_real_escape_string($_GET['id']);

$qry_delete = mysql_query("DELETE FROM images WHERE id = '$image_id'");

if($qry_delete){
	echo "De image werd verwijderd.";
	echo "<br>U wordt zodadelijk teruggestuurd naar de vorige pagina.";
}else{
	echo "Er heeft zich een fout voorgedaan.";
}

?>

<script type="text/javascript">
setTimeout('history.go(-1)', 3000);
</script>