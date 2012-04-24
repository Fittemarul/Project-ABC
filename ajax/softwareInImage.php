<?php

include("../conf/sessionCheck.php");
include("../conf/db.php");

$image_id = mysql_real_escape_string($_GET['id']);

$qry_images = mysql_query("SELECT software FROM software WHERE id = $image_id");

$gekoppeld = mysql_fetch_row($qry_images);
$gekoppeld = str_replace("\n", "<br>", $gekoppeld[0]);


$output = "[";

$output .= "{";

	$output .= "\"software\":\"" .urlencode($gekoppeld). "\"";


$output .= "}";


$output .= "]";

echo $output;

?>