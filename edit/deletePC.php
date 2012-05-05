<?php
include("../conf/sessionCheck.php");
include("../conf/db.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}


$pc_id = mysql_real_escape_string( $_GET['id'] );

$qry_delete = mysql_query("DELETE FROM inventaris WHERE id = '$pc_id' LIMIT 1");

if($qry_delete){
	echo "De computer werd verwijderd.";
}else{
	echo "Er is iets misgegaan. De computer kon niet worden verwijderd.";
}

?>
<script type="text/javascript">
setTimeout('history.go(-1)', 2000);
</script>