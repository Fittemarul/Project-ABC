<?php
include("../conf/sessionCheck.php");
include("../conf/db.php");

$image_naam = mysql_real_escape_string( $_POST['image_naam'] );
$software = mysql_real_escape_string( $_POST['software'] );


$qry_insert = mysql_query("INSERT INTO images (`image_naam`, `image_software`) 	VALUES ('$image_naam', '$software')") or die(mysql_error());

if(!$qry_insert){
	$error = mysql_errno($link);

	if($error == "1062"){
		echo "Er bestaat al een image met deze naam!";
	}else{
		echo "Oops. Uw image kon niet bewaard worden.";
	}
}else{
	echo "Uw image werd toegevoegd";
}

?>
<script type="text/javascript">
setTimeout('history.go(-1)', 2000);
</script>