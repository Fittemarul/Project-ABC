<?php
include("../conf/sessionCheck.php");
include("../conf/db.php");

$image_naam = mysql_real_escape_string( $_POST['image_naam'] );
$software = mysql_real_escape_string( $_POST['software'] );
$id = mysql_real_escape_string( $_POST['id'] );


$qry_insert = mysql_query("UPDATE images SET image_naam = '$image_naam', image_software = '$software' WHERE id = '$id'") or die(mysql_error());

if(!$qry_insert){
	$error = mysql_errno($link);

	echo "Oops. Uw image kon niet bewaard worden.";
}else{
	echo "Uw image werd gewijzigd";
}

?>
<script type="text/javascript">
setTimeout('history.go(-1)', 2000);
</script>