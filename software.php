<?php

include("conf/db.php");
include("conf/sessionCheck.php");

?>
<html>
<head>
	<title>Project ABC</title>
	<link href="style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8">
	<script type="text/javascript" src="js/sorttable.js"></script>
	<script type="text/javascript" src="js/core.js"></script>
	
</head>
<body>
	<div id="overlay">
		<h1 id="softwareEditAdd">Nieuw softwarepakket toevoegen</h1>
		
			<form action="edit/addSoftware.php" method="post" onsubmit="return validate.form(this);" name="nieuwSoftware">
		
			Softwarepakket: <input type="text" name="pakket" class="required"><br><br>
			Bijhorende software: <br><textarea cols="40" rows="5" name="software" class="required"></textarea>
		
			<br><br>
		
			<input type="submit" value="Opslaan" id="btnSubmit"/>
		
		</form>
	</div>
	
	<div id="appBox">
		
		<?php include('conf/header.php') ?>

		<h1>Softwarepakketten beheren</h1>
		<p><a href="#" onclick="toggleShade()"><img src="img/software_add.png"> Nieuw pakket toevoegen</a></p>
		<table class="sortable" width="100%">
			<tr class="noSelect">
				<th width="10%" class="sorttable_nosort">Opties</th>
				<th width="20%">Pakketnaam</th>
				<th width="70%">Software</th>
			</tr>
		
		<?php
			$qry_lokalen = mysql_query("SELECT * FROM software LIMIT 100");
			
			
			while($row = mysql_fetch_assoc($qry_lokalen)){
				$softID = $row['id'];
				$softNaam = $row['naam'];
				$softSoft = $row['software'];
				
				echo "<tr>";
				
					echo "<td style='text-align:center' class='noSelect'>".
							"<a href='javascript:confirmDelete($softID)'><img src='img/software_delete.png'></a> ".
							"<a href=\" javascript:editSoft('$softID', '$softNaam', '$softSoft')\"><img src='img/software_edit.png'></a>".
						"</td>";
					echo "<td>$softNaam</td>";
					echo "<td>$softSoft</td>";
				echo "</tr>";
			}
			
		
		?>
		
		</table>

		<div id="clear"> </div>
	</div>
	
	<?php include('conf/footer.php') ?>
	
<script type="text/javascript">

function confirmDelete(a){
	var msg = confirm("Bent u zeker dat u dit softwarepakket wilt verwijderen?");
	
	if(msg){
		window.location = "edit/deleteSoftware.php?id=" + a;
	}else{
		return false
	}
}

function editSoft(id, naam, software){
	toggleShade(); // Bewerk overlay tonen
	
	//
	// Waardes te wijzigen lokaal wegschrijven in formulier
	//
	$('softwareEditAdd').innerHTML = "Softwarepakket bewerken";
	
	document.nieuwSoftware.pakket.value = naam;
	document.nieuwSoftware.software.value = software;
	
	
	//
	// Hidden input maken voor id
	//
	var hiddenInput = document.createElement('input');
	hiddenInput.setAttribute('type', 'hidden');
	hiddenInput.setAttribute('name', 'id');
	hiddenInput.setAttribute('value', id);
	
	document.nieuwSoftware.appendChild(hiddenInput); // element in formulier schrijven
	
	document.nieuwSoftware.action = "edit/editSoftware.php";
}

</script>
</body>
</html>