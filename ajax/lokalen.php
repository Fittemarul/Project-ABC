<?php

include("../conf/sessionCheck.php");
include("../conf/db.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

$qry_lokalen = mysql_query("SELECT id, lokaal FROM lokalen ORDER BY  lokaal ASC");

//
// Een JSON genereren die javascript kan gebruiken om een selectbox op te vullen
//
$output = "[";

while($row = mysql_fetch_assoc($qry_lokalen)){
	
	$output .= "{";
		
		$output .= "\"id\":" .$row['id'].",";
		$output .= "\"lokaalnaam\":\"" .$row['lokaal']. "\"";
		
	$output .= "},";
	
}

$output = substr($output, 0, -1); // laatste komma verwijderen

$output .= "]";

echo $output;

?>