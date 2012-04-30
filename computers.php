<?php

include("conf/db.php");
include("conf/sessionCheck.php");
include("conf/functions.php"); // voor functie getSoftwarePackage

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}



?>
<!DOCTYPE html>
<html>
<head>
	<title>Project ABC</title>
	<link href="style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8">
	<link rel="icon" href="img/favicon.ico">

	<script type="text/javascript" src="js/sorttable.js"></script>
	<script type="text/javascript" src="js/core.js"></script>
	<script type="text/javascript" src="js/xhr.js"></script>
	<script src="js/calendar.js" type="text/javascript" charset="utf-8"></script>

	<style type="text/css">
		#geselecteerdSoft{
			float:right;
			border-left: solid 1px #CCC;
			padding-left: 10px;
			width: 300px;
			font-size:0.8em;
		}
	</style>
</head>
<body onload="calendar.set('aankoopdatum');">
	<div id="overlay">
		<h1 id="lokaalAddEdit">Computer toevoegen</h1>

			<form action="edit/addComputer.php" method="post" onsubmit="return verzendForm();" name="nieuwComputer">

			<label>PC naam:</label> <input type="text" name="pc_naam" class="required"><br><br>

			<label>Lokaal:</label>
				<select name="lokaal" id="nieuwLokaal">
				  <option value="0">Bezig met laden...</option>
				</select>

			<br>

			<label>RAM:</label> <input type="text" name="ram">MB<br>
			<label>CPU:</label> <input type="text" name="cpu">GHz<br>
			<label>HDD:</label> <input type="number" name="hdd">GB<br>
			<label>GPU:</label> <input type="text" name="gpu"><br>
			<label>Aankoopdatum:</label> <input type="date" id="aankoopdatum" name="aankoop"><br>
			<label>Netwerkkaart:</label> <input type="text" name="nic"><br>

			<label>Leverancier:</label>
				<select name="leverancier" id="nieuwLeverancier">
					<option value="0">Bezig met laden...</option>
				</select>

            <br>


			<label>Type:</label>
				<select name="pc_type">
				  <option value="0">Vaste computer</option>
				  <option value="1">Laptop</option>
				</select>

			<br><br>

			<h1>Images koppelen</h1>

			<!-- RECHTSE DIV -->
			<div id="geselecteerdSoft">
				<b>De door u geselecteerde software bevat:</b>
				<p id="selectedImage"> </p>
			</div>


			<!-- LINKSE DIV -->
			<div style="width:600px">
				Toevoegen:
					<select id="nieuwImage" onchange="updateSelectedImage()">
						<option value="0">Bezig met laden...</option>
					</select>
				<button type="button" onclick="voegImageToe()">Voeg toe</button>
			</div>

			<br>
			<div style="clear:both"> </div>

			<ul id="gelinkteSoftware">
			</ul>

			<br><br>
			<center><input type="submit" value="Opslaan" id="btnSubmit"/></center>

		</form>
	</div>

	<div id="appBox">

		<?php include('conf/header.php') ?>

		<h1>Computer inventaris</h1>
		<p><a href="#" onclick="addComputer()"><img src="img/add.png"> Computer toevoegen</a></p>
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
			$qry_lokalen = mysql_query("SELECT a.id, pc_naam, pc_ram, pc_cpu, pc_hdd, pc_gpu, pc_datumaankoop, pc_netwerkkaart, pc_leverancier, pc_type, pc_software, lokaal, leverancier_naam
			FROM inventaris a
			INNER JOIN lokalen b ON a.lokaal_id = b.id
			INNER JOIN leveranciers c ON a.pc_leverancier = c.id");




			while($row = mysql_fetch_assoc($qry_lokalen)){
				// Variabelen voor edit functie in JS
				$compID = $row['id'];
				$compNaam = $row['pc_naam'];
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
					echo "<td>". getSoftwarePackage($row['pc_software']) ."</td>";
				echo "</tr>";
			}


		?>

		</table>

		<div id="clear"> </div>
	</div>

	<?php include('conf/footer.php') ?>

<script type="text/javascript">
var geselecteerdSoftware = new Array;
var software;
function confirmDelete(a){
	var msg = confirm("Bent u zeker dat u dit lokaal wilt verwijderen?");

	if(msg){
		window.location = "edit/deleteLokaal.php?id=" + a;
	}else{
		return false
	}
}

//
// Functie voor het toevoegen van een computer
//
function addComputer(){
	toggleShade(); // Bewerk overlay tonen

	// Lokalen via AJAX ophalen van server
	xhr("ajax/lokalen.php", verwerkLokalen);

	// Leveranciers via AJAX ophalen van server
    xhr("ajax/leveranciers.php", verwerkLeveranciers);

	// Softwarepakketten ophalen
	xhr("ajax/images.php", verwerkImages);

}

function verwerkLokalen(text){
	var lokalen = eval("(" + text.responseText + ')');

	for(i=0; i<= lokalen.length -1; i++){
	    $('nieuwLokaal').options[i] = new Option(lokalen[i].lokaalnaam, lokalen[i].id);
	}
}

function verwerkLeveranciers(data){
    var leveranciers = eval("(" + data.responseText + ")"); // Parse the JSON array

    for(i=0; i<= leveranciers.length -1; i++){
        $('nieuwLeverancier').options[i] = new Option(leveranciers[i].leverancier,leveranciers[i].id);
    }
}

function verwerkImages(data){
	images = eval("(" + data.responseText + ")"); // Parse the JSON array

    for(i=0; i<= images.length -1; i++){
        $('nieuwImage').options[i] = new Option(images[i].imagenaam, images[i].id);
    }

    // Eerste software in image al tonen
    updateSelectedImage();
}

//
// functie die geselecteerd software pakket toevoegd aan
//

function voegImageToe(){

	// Welk software pakket?
	var pakket_naam = $('nieuwSoftware')[$('nieuwSoftware').selectedIndex].text;
	var pakket_id = $('nieuwSoftware')[$('nieuwSoftware').selectedIndex].value;

	//
	// Eerst controleren of pakket reeds werd toegevoegd
	//
	for(i=0; i<=geselecteerdSoftware.length -1; i++){
		if(pakket_id == geselecteerdSoftware[i]){
			alert("Pakket werd reeds toegevoegd aan uw selectie");
			return; // niet verder gaan
		}
	}

	geselecteerdSoftware.push(pakket_id);

	// Toevoegen aan lijst
	var parent = document.getElementById('gelinkteSoftware');
	var nieuw = document.createElement("li");

	nieuw.innerHTML = pakket_naam;

	parent.appendChild(nieuw);

}

// Werkt softwarelijst bij
function updateSelectedImage(){

	xhr("ajax/softwareInImage.php?id=" + $('nieuwImage').value, function(data){

		gekoppeld = eval("(" + data.responseText + ")"); // Parse the JSON array

		$('selectedImage').innerHTML = urldecode(gekoppeld[0].software);

	});

}

function verzendForm(form){
	//
	// Hidden input maken voor id
	//
	var hiddenInput = document.createElement('input');
	hiddenInput.setAttribute('type', 'hidden');
	hiddenInput.setAttribute('name', 'software');
	hiddenInput.setAttribute('value', geselecteerdSoftware.join(','));

	document.nieuwWens.appendChild(hiddenInput); // element in formulier schrijven

	return validate.form(form);

}

</script>
</body>
</html>