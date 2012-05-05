<?php
include("../conf/sessionCheck.php");
include("../conf/db.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

$id = mysql_real_escape_string( $_POST['id'] );
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


//
// Bewerken in database
//
$qry_edit = mysql_query("UPDATE inventaris SET pc_naam = '$pc_naam',
												lokaal_id = '$lokaal',
												pc_ram = '$ram',
												pc_cpu = '$cpu',
												pc_hdd = '$hdd',
												pc_gpu = '$gpu',
												pc_datumaankoop = '$aankoop',
												pc_netwerkkaart = '$nic',
												pc_leverancier = '$leverancier',
												pc_type = '$pc_type',
												pc_images = '$gekoppelde_image',
												aantal = '$aantal'
										WHERE id = '$id' LIMIT 1") or die(mysql_error());

if(!$qry_edit){
	die("Kon wijziging niet doorvoeren.");
}else{
	echo "De wijziging werd doorgevoerd.";
}

?>
<script type="text/javascript">
setTimeout('history.go(-1)', 2000);
</script>