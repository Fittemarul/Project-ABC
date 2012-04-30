<?php

function getSoftwarePackage($id){
	$qry_package = mysql_query("SELECT naam, software FROM software WHERE id = '$id'");

	while($row = mysql_fetch_assoc($qry_package)){
		return "- ". $row['naam']. "<br>";
	}
}

function getSoftwareNameById($id){
	$qry_name = mysql_query("SELECT naam FROM software WHERE id = '$id' LIMIT 1");

	while($row = mysql_fetch_assoc($qry_name)){
		return $row['naam'];
	}
}

function getSoftwarepackByImageId($id){
	$qry_image = mysql_query("SELECT image_naam FROM images WHERE id='$id' ");

	while($row = mysql_fetch_assoc($qry_image)){
		return "- " . $row['image_naam']. "<br>";
	}
}

?>