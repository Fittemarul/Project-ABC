<?php
include("../conf/sessionCheck.php");
include("../conf/db.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

$username = strtoupper($_POST['username']); // Wordt eerst geconverteerd naar uppercase
$username = mysql_real_escape_string($username); // veilig maken voor db

$pass = sha1( $_POST['password'] ); // direct hashen!

if($_POST['admin'] == true){
	$admin = "1";
}else {
	$admin = "0";
}

$qry_insert = mysql_query("INSERT INTO users (`username`, `userpass`, `time_lastlogon`, `is_admin`, `active`) VALUES ('$username', '$pass', '', '$admin', '1')");

if(!$qry_insert){
	$error = mysql_errno($link);
	
	if($error == "1062"){
		die("Er bestaat al een gebruiker met deze naam!");
	}
}else{
	echo "De gebruiker werd toegevoegd.";
}

?>
<script type="text/javascript">
setTimeout('history.go(-1)', 2000);
</script>