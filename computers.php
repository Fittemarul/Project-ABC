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

			<form action="edit/addComputer.php" method="post" onsubmit="return validate.form(this);" name="nieuwComputer">

			<label>PC groepnaam:</label> <input type="text" name="pc_naam" class="required"><br><br>
			<label>Aantal:</label> <input type="number" name="aantal" class="required"><br>

			<label>Computer type:</label>
				<select name="pc_type">
				  <option value="0">Vaste computer</option>
				  <option value="1">Laptop</option>
				</select>

			<br>

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



			<br><br>

			<h1>Image koppelen</h1>

			<!-- RECHTSE DIV -->
			<div id="geselecteerdSoft">
				<b>De door u geselecteerde image bevat:</b>
				<p id="selectedImage"> </p>
			</div>


			<!-- LINKSE DIV -->
			<div style="width:600px">
				Kies een image:
					<select id="nieuwImage" onchange="updateSelectedImage()" name="gekoppelde_image">
						<option value="0">Bezig met laden...</option>
					</select>
			</div>

			<br>
			<div style="clear:both"> </div>

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
				<th width="20%">PC naam</th>
				<th width="5%">#</th>
				<th width="5%">RAM <small>(MB)</small></th>
				<th width="5%">CPU <small>(GHz)</small></th>
				<th width="5%">HDD <small>(GB)</small></th>
				<th width="10%">Type</th>
				<th width="10%">Lokaal</th>
				<th width="15%">Leverancier</th>
				<th width="20%">Images</th>
			</tr>

		<?php
			$qry_lokalen = mysql_query("SELECT a.id, aantal, pc_naam, pc_ram, pc_cpu, pc_hdd, pc_gpu, pc_datumaankoop, pc_netwerkkaart, pc_leverancier, pc_type, lokaal, leverancier_naam, i.image_naam AS pc_images
			FROM inventaris a
			LEFT JOIN lokalen b ON a.lokaal_id = b.id
			LEFT JOIN leveranciers c ON a.pc_leverancier = c.id
			LEFT JOIN images i ON a.pc_images = i.id");


			while($row = mysql_fetch_assoc($qry_lokalen)){
				// Variabelen voor edit functie in JS
				$compID = $row['id'];
				$compNaam = $row['pc_naam'];
				$compSoftware = $row['pc_images'];
				$compType = $row['pc_type'];
				$aantal = $row['aantal'];
				$lokaal = $row['lokaal'];

				echo "<tr>";

					echo "<td style='text-align:center' class='noSelect'><a href=\"javascript:deletePC('$compID')\"><img src='img/delete.png'></a></td>";

					echo "<td>$compNaam</td>";
					echo "<td style='text-align:center'>$aantal</td>";
					echo "<td>". $row['pc_ram'] ."</td>";
					echo "<td>". $row['pc_cpu'] ."</td>";
					echo "<td>". $row['pc_hdd'] ."</td>";

					if($compType == "0"){
						echo "<td>Vast</td>";
					}else{
						echo "<td>Laptop</td>";
					}

					if($lokaal == ''){
						echo "<td> / </td>";
					}else{
						echo "<td>$lokaal</td>";
					}
					//echo "<td>". $row['lokaal'] ."</td>";
					echo "<td>". $row['leverancier_naam'] ."</td>";

					echo "<td>$compSoftware</td>";

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

	// mogelijkheid om geen lokaal te kiezen (laptops)
	$('nieuwLokaal').options[lokalen.length] = new Option('Geen lokaal', 'null');
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


// Werkt softwarelijst bij
function updateSelectedImage(){

	xhr("ajax/softwareInImage.php?id=" + $('nieuwImage').value, function(data){

		gekoppeld = eval("(" + data.responseText + ")"); // Parse the JSON array

		$('selectedImage').innerHTML = urldecode(gekoppeld[0].software);

	});
}

//
// Functie die pc verwijderd
//
function deletePC(pc_id){
	var answer = confirm("Bent u zeker dat u deze PC wilt verwijderen?");

	if(answer){
		window.location = "edit/deletePC.php?id=" + pc_id;
	}else{
		return false;
	}
}

</script>
</body>
</html>