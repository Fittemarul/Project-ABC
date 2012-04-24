<?php

include("../conf/sessionCheck.php");
include("../conf/db.php");

$qry_images = mysql_query("SELECT id, image_naam, image_software FROM images ORDER BY image_naam ASC");

//
// Een JSON genereren die javascript kan gebruiken om een selectbox op te vullen
//
$output = "[";

while($row = mysql_fetch_assoc($qry_images)){

	$output .= "{";

		$output .= "\"id\":" .$row['id'].",";
		$output .= "\"imagenaam\":\"" .$row['image_naam']. "\"";

	$output .= "},";

}

$output = substr($output, 0, -1); // laatste komma verwijderen

$output .= "]";

echo $output;

?>