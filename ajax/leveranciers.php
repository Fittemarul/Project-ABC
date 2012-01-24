<?php

include("../conf/sessionCheck.php");
include("../conf/db.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

$qry_leverancier = mysql_query("SELECT id, leverancier_naam FROM leveranciers ORDER BY leverancier_naam ASC");

//
// Een JSON genereren die javascript kan gebruiken om een selectbox op te vullen
//
$output = "[";

while($row = mysql_fetch_assoc($qry_leverancier)){
	
	$output .= "{";
		
		$output .= "\"id\":" .$row['id'].",";
		$output .= "\"leverancier\":\"" .$row['leverancier_naam']. "\"";
		
	$output .= "},";
	
}

$output = substr($output, 0, -1); // laatste komma verwijderen

$output .= "]";

echo $output;

?>