<?php

include("conf/db.php");
include("conf/sessionCheck.php");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Project ABC</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link href="style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8">
	<link rel="icon" href="img/favicon.ico">

	<script type="text/javascript" src="js/core.js"></script>
	<script type="text/javascript" src="js/xhr.js"></script>
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
<body>
	<div id="appBox">

		<?php include('conf/header.php') ?>


		<h1>Wensen invullen</h1>

		<div id="geselecteerdSoft">
			<p style="font-weight:bold">Het door u geselecteerde softwarepakket bevat:</p>
			<p id="selectedSoftware"> </p>
		</div>

		<!-- Linkse DIV -->
		<div style="width: 660px">
			<form action="edit/addWensen.php" method="post" onsubmit="return verzendForm(this);" name="nieuwWens">

				<label>Klas:</label> <input type="text" name="klas" class="required"> (bv: 6IB)<br>
				<label>Vak:</label>	<input type="text" name="vak" class="required"> (bv: Engels)<br>
				<label>Aantal uren:</label> <input type="number" name="uren" class="required"> (bv: 4)<br>

				<label>Gewenst lokaal:</label>
					<select name="lokaal" id="lokaal">
				  		<option value="0">Bezig met laden...</option>
					</select>

				<br><br>

				<label>Gewenste software:</label>

				<select id="software" onchange="updateSelectSoft()">
			  		<option value="0">Bezig met laden...</option>
				</select>

				<button type="button" onclick="voegSoftToe()">Voeg toe</button>

				<input type="submit" value="Wensen indienen"/>

			</form>
		</div>

		<div id="clear"> </div>
		<br>

		<h1>Gewenste softwarepakketten:</h1>
		<ul id="gewensteSoftware">
		</ul>




	</div>

	<?php include('conf/footer.php') ?>

<script type="text/javascript">
// Variabelen die later voor de hele pagina nodig zijn:
var lokalen;
var software;
var geselecteerdSoftware = new Array();

//onload: Lokalen via AJAX ophalen van server
xhr("ajax/lokalen.php", verwerkLokalen);

//onload: Softwarepakketten via AJAX ophalen
xhr("ajax/software.php", verwerkSoftware);


function verwerkLokalen(text){
	lokalen = eval("(" + text.responseText + ')');

	for(i=0; i<= lokalen.length -1; i++){
	    $('lokaal').options[i] = new Option(lokalen[i].lokaalnaam, lokalen[i].id);
	}
}

function verwerkSoftware(text){
	software = eval("(" + text.responseText + ')');

	for(i=0; i<= software.length -1; i++){
	    $('software').options[i] = new Option(software[i].softnaam, software[i].id);
	}

	updateSelectSoft();
}

// Werkt softwarelijst bij
function updateSelectSoft(){

	for(i=0; i<= software.length -1; i++){
		if(software[i].softnaam == $('software')[$('software').selectedIndex].text){
			$('selectedSoftware').innerHTML = software[i].software;
		}
	}

}

function voegSoftToe(){

	// Welk software pakket?
	var pakket_naam = $('software')[$('software').selectedIndex].text;
	var pakket_id = $('software')[$('software').selectedIndex].value;

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
	var parent = document.getElementById('gewensteSoftware');
	var nieuw = document.createElement("li");

	nieuw.innerHTML = pakket_naam;

	parent.appendChild(nieuw);

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