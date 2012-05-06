<?php

include("../conf/sessionCheck.php");
include("../conf/db.php");
include("../conf/functions.php");

$image_id = mysql_real_escape_string($_GET['id']);

$qry_images = mysql_query("SELECT image_software FROM images WHERE id = $image_id");

$gekoppeld = mysql_fetch_row($qry_images);
$gekoppeld = $gekoppeld[0];

$gekoppeld = explode(",", $gekoppeld);

$output = "[";
$output .= "{";
$output .= "\"software\":\"";


for($i = 0; $i <= count($gekoppeld)-1; $i++){
		$output .= urlencode(getSoftwarePackage($gekoppeld[$i]) . "\n");

}

$output .= "\"";

$output .= "}";


$output .= "]";

echo $output;

?>