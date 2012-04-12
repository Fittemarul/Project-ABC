<?php

include("../conf/sessionCheck.php");
include("../conf/db.php");
include("../conf/functions.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

if(!is_numeric($_GET['id'])){
	die("Parameter te kort");
}

$image_id = mysql_real_escape_string($_GET['id']);

$qry_leverancier = mysql_query("SELECT * FROM images WHERE id='$image_id' LIMIT 1");

if(mysql_num_rows($qry_leverancier) != 1){
	die("oops");
}

//
// Resultaat van db ophalen
//
$row = mysql_fetch_row($qry_leverancier);


//
// String maken met namen in van software pakketten
//
$softwarePakketten = $row[2];
$softwarePakketten = explode(",", $softwarePakketten);

for($i=0; $i <= count($softwarePakketten) -1; $i++){
	$softwareNamen .= getSoftwareNameById($softwarePakketten[$i]) . ",";
}

$softwareNamen = substr($softwareNamen, 0, -1); // laatste komma verwijderen


//
// Een JSON genereren die javascript kan gebruiken om een selectbox op te vullen
//
$output = "[";
$output .= "{";
	$output .= "\"image_id\":\"" .$row[0] ."\",";
	$output .= "\"image_naam\":\"" .$row[1] ."\",";
	$output .= "\"ids\":\"" .$row[2]."\",";
	$output .= "\"software_names\":\"" .$softwareNamen. "\"";

$output .= "}";



//$output = substr($output, 0, -1); // laatste komma verwijderen

$output .= "]";

echo $output;

?>