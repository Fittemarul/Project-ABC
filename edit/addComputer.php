<?php
include("../conf/sessionCheck.php");
include("../conf/db.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}


$lokaal = mysql_real_escape_string( $_POST['lokaal'] );
$aantal = mysql_real_escape_string( $_POST['aantal'] );
$pc_naam = mysql_real_escape_string( $_POST['pc_naam'] );
$ram = mysql_real_escape_string( $_POST['ram'] );
$cpu = mysql_real_escape_string( $_POST['cpu'] );
$hdd = mysql_real_escape_string( $_POST['hdd'] );
$gpu = mysql_real_escape_string( $_POST['gpu'] );
$aankoop = mysql_real_escape_string( $_POST['aankoop'] );
$nic = mysql_real_escape_string( $_POST['nic'] );
$leverancier = mysql_real_escape_string( $_POST['leverancier'] );
$pc_type = mysql_real_escape_string( $_POST['pc_type'] );
$gekoppelde_image = mysql_real_escape_string($_POST['gekoppelde_image']);


$qry_insert = mysql_query("INSERT INTO inventaris (`pc_naam` ,`lokaal_id` ,`pc_ram` ,`pc_cpu` ,`pc_hdd` ,`pc_gpu` ,`pc_datumaankoop` ,`pc_netwerkkaart` ,`pc_leverancier` ,`pc_type` ,`pc_images`, `aantal`)
							VALUES ('$pc_naam', '$lokaal', '$ram', '$cpu', '$hdd', '$gpu', '$aankoop', '$nic', '$leverancier', '$pc_type', '$gekoppelde_image', '$aantal')");

if(!$qry_insert){
	$error = mysql_errno($link);

	if($error == "1062"){
		die("Deze computer staat al in de database!");
	}
}else{
	echo "De computer werd toegevoegd aan de inventaris!";
}

?>
<script type="text/javascript">
setTimeout('history.go(-1)', 2000);
</script>