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
		<h1 id="lokaalAddEdit">Computer toevoegen</h1>
		
			<form action="edit/addComputer.php" method="post" onsubmit="return validate.form(this);" name="nieuwComputer">
		
			PC naam: <input type="text" name="lokaal" class="required"><br><br>
			Lokaal: PICKLIST<br>
			RAM: <input type="text"><br>
			CPU: <input type="text">GHz<br>
			HDD: <input type="number">GB<br>
			GPU: <input type="text"><br>
			Datum aankoop: <input type="date"><br>
			Netwerkkaart: <input type="text"><br>
			Leverancier: PICKLIST<br>
			Type: PICKLIST (LAPTOP/DESKTOP)<br>
			Software: ????<br>
			
			
			<br><br>
		
			<input type="submit" value="Opslaan" id="btnSubmit"/>
		
		</form>
	</div>
	
	<div id="appBox">
		
		<?php include('conf/header.php') ?>

		<h1>Computer inventaris</h1>
		<p><a href="#" onclick="toggleShade()"><img src="img/add.png"> Lokaal toevoegen</a></p>
		<table class="sortable" width="100%">
			<tr class="noSelect">
				<th width="10%" class="sorttable_nosort">Opties</th>
				<th width="20%">PC naam</th>
				<th width="20%">RAM</th>
				<th width="20%">CPU</th>
				<th width="20%">HDD</th>
				<th width="20%">Type</th>
				<th width="35%">Lokaal</th>
				<th width="35%">Leverancier</th>
				<th width="35%">Software</th>
			</tr>
		
		<?php
			$qry_lokalen = mysql_query("SELECT a.id, pc_naam, pc_ram, pc_cpu, pc_hdd, pc_gpu, pc_datumaankoop, pc_netwerkkaart, pc_leverancier, pc_type, pc_software, lokaal, leverancier_naam
										FROM inventaris a 
										INNER JOIN lokalen b 
										ON a.lokaal_id = b.id

										INNER JOIN leveranciers c
										ON a.pc_leverancier = c.id");
			
			
			
			
			while($row = mysql_fetch_assoc($qry_lokalen)){
				// Variabelen voor edit functie in JS
				$compID = $row['id'];
				$compNaam = $row['pc_naam'];
				$compLokaal = $row['lokaal_id'];
				$compSoftware = $row['pc_software'];
				$compType = $row['pc_type'];
				
				echo "<tr>";
				
					echo "<td style='text-align:center' class='noSelect'>-</td>";
							
					echo "<td>". $row['pc_naam'] ."</td>";
					echo "<td>". $row['pc_ram'] ."</td>";
					echo "<td>". $row['pc_cpu'] ."</td>";
					echo "<td>". $row['pc_hdd'] ."</td>";
					
					if($compType == "0"){
						echo "<td>Vast</td>";
					}else{
						echo "<td>Laptop</td>";
					}
					
					echo "<td>". $row['lokaal'] ."</td>";
					echo "<td>". $row['leverancier_naam'] ."</td>";
					echo "<td>". $row['pc_software'] ."</td>";
				echo "</tr>";
			}
			
		
		?>
		
		</table>

		<div id="clear"> </div>
	</div>
	
	<?php include('conf/footer.php') ?>
	
<script type="text/javascript">

function confirmDelete(a){
	var msg = confirm("Bent u zeker dat u dit lokaal wilt verwijderen?");
	
	if(msg){
		window.location = "edit/deleteLokaal.php?id=" + a;
	}else{
		return false
	}
}

//
// Functie voor bewerken van een lokaal
// maakt gebruik van het nieuwLokaal formulier (geen extra formulieren: yeah!)
//
function editLokaal(id, lokaal, beschrijving, voorzieningen){
	toggleShade(); // Bewerk overlay tonen
	
	//
	// Waardes te wijzigen lokaal wegschrijven in formulier
	//
	$('lokaalAddEdit').innerHTML = "Lokaal bewerken";
	
	document.nieuwLokaal.lokaal.value = lokaal;
	document.nieuwLokaal.beschrijving.value = beschrijving;
	document.nieuwLokaal.voorzieningen.value = voorzieningen;
	
	
	//
	// Hidden input maken voor id
	//
	var hiddenInput = document.createElement('input');
	hiddenInput.setAttribute('type', 'hidden');
	hiddenInput.setAttribute('name', 'id');
	hiddenInput.setAttribute('value', id);
	
	document.nieuwLokaal.appendChild(hiddenInput); // element in formulier schrijven
	
	document.nieuwLokaal.action = "edit/editLokaal.php";
	
}

</script>
</body>
</html>