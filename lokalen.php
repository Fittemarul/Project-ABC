<?php

include("conf/db.php");
include("conf/sessionCheck.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

?>
<html>
<head>
	<title>Project ABC</title>
	<link href="style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8">
	<link rel="icon" href="img/favicon.ico">

	<script type="text/javascript" src="js/sorttable.js"></script>
	<script type="text/javascript" src="js/core.js"></script>
	<script type="text/javascript" src="js/xhr.js"></script>

</head>
<body>
	<div id="overlay">
		<h1 id="lokaalAddEdit">Nieuw lokaal toevoegen</h1>

			<form action="edit/addLokaal.php" method="post" onsubmit="return validate.form(this);" name="nieuwLokaal">

			Lokaal: <input type="text" name="lokaal" class="required"><br><br>
			Aantal personen: <input type="number" name="aantalpersonen"><br><br>
			Beschrijving: <br><textarea cols="40" rows="5" name="beschrijving" class="linebreak"></textarea><br><br>
			Voorzieningen: <br><textarea cols="40" rows="5" name="voorzieningen" class="linebreak"></textarea>

			<br><br>

			<h1>Image koppelen</h1>

			<!-- RECHTSE DIV -->
			<div id="geselecteerdSoft">
				<b>De door u geselecteerde software bevat:</b>
				<p id="selectedImage"> </p>
			</div>


			<!-- LINKSE DIV -->
			<div style="width:600px">
				Kies een image die u wilt koppelen aan dit lokaal:
					<select id="nieuwImage" onchange="updateSelectedImage()" name="image">
						<option value="0">Bezig met laden...</option>
					</select>
			</div>

			<br>
			<div style="clear:both"> </div>

			<input type="submit" value="Opslaan" id="btnSubmit"/>

		</form>
	</div>

	<div id="appBox">

		<?php include('conf/header.php') ?>

		<h1>Lokalen beheren</h1>
		<p><a href="#" onclick="toggleShade(); addLokaal();"><img src="img/add.png"> Lokaal toevoegen</a></p>
		<table class="sortable" width="100%">
			<tr class="noSelect">
				<th width="10%" class="sorttable_nosort">Opties</th>
				<th width="10%">Lokaal</th>
				<th width="20%">Beschrijving</th>
				<th width="10%">Capaciteit</th>
				<th width="20%">Voorzieningen</th>
				<th width="30%">Gekoppelde image</th>
			</tr>

		<?php
			$qry_lokalen = mysql_query("SELECT lokalen.id, lokaal, beschrijving, voorzieningen, aantalpersonen, lokalen.image AS image_id, images.image_naam AS image_naam FROM lokalen
										LEFT JOIN images ON lokalen.image = images.id");

			while($row = mysql_fetch_assoc($qry_lokalen)){
				// Variabelen voor edit functie in JS
				$lokaalID = $row['id'];
				$lokaal = $row['lokaal'];
				$beschrijving = $row['beschrijving'];
				$voorzieningen = str_replace("\n", "<br>", $row['voorzieningen']);
				$aantalpersonen = $row['aantalpersonen'];
				$gekoppelde_image = $row['image_naam'];
				$gekoppelde_image_id = $row['image_id'];

				echo "<tr>";

					echo "<td style='text-align:center' class='noSelect'>".
							"<a href=\"javascript:editLokaal('$lokaalID', '$lokaal', '$beschrijving', '$voorzieningen', '$aantalpersonen', '$gekoppelde_image_id') \"><img src='img/pencil.png' title='Lokaal bewerken'></a>".
							"<a href='javascript:confirmDelete(".$row['id'].")'><img src='img/delete.png' title='Lokaal verwijderen'></a></td>";

					echo "<td>". $row['lokaal'] ."</td>";
					echo "<td>". str_replace("\n", "<br>", $row['beschrijving']) ."</td>";
					echo "<td>$aantalpersonen</td>";
					echo "<td>". str_replace("\n", "<br>", $row['voorzieningen']) ."</td>";
					echo "<td>$gekoppelde_image</td>";

				echo "</tr>";
			}


		?>

		</table>

		<div id="clear"> </div>
	</div>

	<?php include('conf/footer.php') ?>

<script type="text/javascript">

//
// Functie die opgeroepen wordt als er een nieuw lokaal wordt toegevoegd
//
function addLokaal(){
	// Softwarepakketten ophalen
	xhr("ajax/images.php", verwerkImages);
}

//
// Functie die de JSON met images verwerkt
//
function verwerkImages(data, gekoppelde_image){
	images = eval("(" + data.responseText + ")"); // Parse the JSON array

    for(i=0; i<= images.length -1; i++){
    	console.log(gekoppelde_image + " ?= "+ images[i].id);
    	// image toevoegen aan selectie
    	$('nieuwImage').options[i] = new Option(images[i].imagenaam, images[i].id);

    	// indien gelijk is aan gekoppelde image:
    	// deze image geselecteerd zetten
    	if(images[i].id == gekoppelde_image){
    		$('nieuwImage').options[i].setAttribute('selected', 'selected');
    		$('nieuwImage').options[i].selected = true;
    	}
    }

    //
    // Mogelijkheid om gekoppelde image te verwijderen
    //
    $('nieuwImage').options[images.length] = new Option('Geen image', 'null');
    if(gekoppelde_image == 0){
    	$('nieuwImage').options[images.length].selected = true;
    }

    // Eerste software in image al tonen
    updateSelectedImage();
}



//
// Functie die weergeeft welke softwarepakketten er in image zitten
//
function updateSelectedImage(){

	xhr("ajax/softwareInImage.php?id=" + $('nieuwImage').value, function(data){

		gekoppeld = eval("(" + data.responseText + ")"); // Parse the JSON array

		$('selectedImage').innerHTML = urldecode(gekoppeld[0].software);

	});

}

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
function editLokaal(id, lokaal, beschrijving, voorzieningen, aantalpersonen, gekoppelde_image){
	//
	// Images ophalen en gekoppelde image als standaard selcteren
	//
	xhr("ajax/images.php", function(data){
		verwerkImages(data, gekoppelde_image)
	});

	toggleShade(); // Bewerk overlay tonen

	//
	// Waardes te wijzigen lokaal wegschrijven in formulier
	//
	$('lokaalAddEdit').innerHTML = "Lokaal bewerken";

	document.nieuwLokaal.lokaal.value = lokaal;
	document.nieuwLokaal.beschrijving.value = beschrijving;
	document.nieuwLokaal.voorzieningen.value = voorzieningen.replace(/<br>/g, "\n");
	document.nieuwLokaal.aantalpersonen.value = aantalpersonen;


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