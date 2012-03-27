<?php

include("../conf/db.php");
include("../conf/sessionCheck.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}


$qry_delete = mysql_query("DELETE FROM users WHERE is_admin = 0");

if($qry_delete){
	echo "De gebruikers werden verwijderd.";
	echo "<br>U wordt zodadelijk teruggestuurd naar de vorige pagina.";
}else{
	echo "Er heeft zich een fout voorgedaan.";
}

?>

<script type="text/javascript">
setTimeout('window.location = "../abc.php"', 3000);
</script>