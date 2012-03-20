<?php

function getSoftwarePackage($id){
	$qry_package = mysql_query("SELECT naam, software FROM software WHERE id = '$id'");

	while($row = mysql_fetch_assoc($qry_package)){
		return "- ". $row['naam']. "<br>";
	}
}

?>