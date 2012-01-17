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
	<script type="text/javascript" src="js/xhr.js"></script>
</head>
<body>
	<div id="overlay">
		<h1 id="lokaalAddEdit">Computer toevoegen</h1>
		
			<form action="edit/addComputer.php" method="post" onsubmit="return validate.form(this);" name="nieuwComputer">
		
			<label>PC naam:</label> <input type="text" name="lokaal" class="required"><br><br>
			
			<label>Lokaal:</label> 
				<select name="lokaal" id="nieuwLokaal">
				  <option value="0">Bezig met laden...</option>
				</select>
			
			<br>
			
			<label>RAM:</label> <input type="text">MB<br>
			<label>CPU:</label> <input type="text">GHz<br>
			<label>HDD:</label> <input type="number">GB<br>
			<label>GPU:</label> <input type="text"><br>
			<label>Aankoopdatum:</label> <input type="date"><br>
			<label>Netwerkkaart:</label> <input type="text"><br>
			
			<label>Leverancier:</label> PICKLIST<br>
			
			
			<label>Type:</label>
				<select name="pc_type">
				  <option value="0">Vaste computer</option>
				  <option value="1">Laptop</option>
				</select>
			<br>
				
			<label>Software:</label> ????<br>
			
			
			<br><br>
		
			<input type="submit" value="Opslaan" id="btnSubmit"/>
		
		</form>
	</div>
	
	<div id="appBox">
		
		<?php include('conf/header.php') ?>

		<h1>Computer inventaris</h1>
		<p><a href="#" onclick="addComputer()"><img src="img/add.png"> Lokaal toevoegen</a></p>
		<table class="sortable" width="100%">
			<tr class="noSelect">
				<th width="5%" class="sorttable_nosort"></th>
				<th width="10%">PC naam</th>
				<th width="10%">RAM (MB)</th>
				<th width="10%">CPU (GHz)</th>
				<th width="10%">HDD (GB)</th>
				<th width="10%">Type</th>
				<th width="10%">Lokaal</th>
				<th width="15%">Leverancier</th>
				<th width="35%">Software</th>
			</tr>
		
		<?php
			$qry_lokalen = mysql_query("SELECT a.id, pc_naam, pc_ram, pc_cpu, pc_hdd, pc_gpu, pc_datumaankoop, pc_netwerkkaart, pc_leverancier, pc_type, pc_software, lokaal, leverancier_naam, software
			FROM inventaris a
			INNER JOIN lokalen b ON a.lokaal_id = b.id
			INNER JOIN leveranciers c ON a.pc_leverancier = c.id
			INNER JOIN software d ON a.pc_software = d.id");
			
			
			
			
			while($row = mysql_fetch_assoc($qry_lokalen)){
				// Variabelen voor edit functie in JS
				$compID = $row['id'];
				$compNaam = $row['pc_naam'];
				$compLokaal = $row['lokaal_id'];
				$compSoftware = $row['pc_software'];
				$compType = $row['pc_type'];
				
				echo "<tr>";
				
					echo "<td style='text-align:center' class='noSelect'>-</td>";
							
					echo "<td>$compNaam</td>";
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
					echo "<td>". str_replace("\n", "<br>", $row['software']) ."</td>";
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

//
// Functie voor het toevoegen van een computer
//
function addComputer(){
	toggleShade(); // Bewerk overlay tonen
	
	// Lokalen via AJAX ophalen van server
	xhr("ajax/lokalen.php", verwerkLokalen);
	
	
}

function verwerkLokalen(text){
	var lokalen = eval("(" + text.responseText + ')');
	
	for(i=0; i<= lokalen.length -1; i++){
	    $('nieuwLokaal').options[i] = new Option(lokalen[i].lokaalnaam);
	}
	
	
	alert(obj[0].id);
	
}

</script>
</body>
</html>