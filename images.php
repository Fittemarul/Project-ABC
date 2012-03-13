<?php

include("conf/db.php");
include("conf/sessionCheck.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Project ABC</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link href="style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8">
	<link rel="icon" href="img/favicon.ico">

	<script type="text/javascript" src="js/sorttable.js"></script>
	<script type="text/javascript" src="js/core.js"></script>
	<script type="text/javascript" src="js/xhr.js"></script>

</head>
<body>
	<div id="overlay">
		<h1 id="softwareEditAdd">Nieuwe image toevoegen</h1>

		<div id="geselecteerdSoft" style="height:300px; overflow:scroll">
			<p style="font-weight:bold">Het door u geselecteerde softwarepakket bevat:</p>
			<p id="selectedSoftware"> </p>
		</div>

		<!-- Linkse DIV -->
		<div style="width: 660px">
			<form action="edit/addImage.php" method="post" onsubmit="return verzendForm(this);" name="nieuwImage">

				Image naam: <input type="text" name="image_naam" class="required">

				<br><br>

				<label>Koppel softwarepakket:</label>

				<select id="software" onchange="updateSelectSoft()">
			  		<option value="0">Bezig met laden...</option>
				</select>

				<button type="button" onclick="voegSoftToe()">Voeg toe</button>

				<br><br>
				<input type="submit" value="Opslaan" id="btnSubmit"/>

			</form>
		</div>

		<div style="clear:both"> </div>

		<h1>Gekoppelde softwarepakketten:</h1>
		<ul id="gewensteSoftware" style="padding:5px; list-style-type:none;">
		</ul>
	</div>

	<div id="appBox">

		<?php include('conf/header.php') ?>

		<h1>Images beheren</h1>
		<p><a href="#" onclick="toggleShade()"><img src="img/image_add.png"> Nieuwe image toevoegen</a></p>
		<table class="sortable" width="100%">
			<tr class="noSelect">
				<th width="10%" class="sorttable_nosort">Opties</th>
				<th width="20%">Pakketnaam</th>
				<th width="70%">Software</th>
			</tr>

		</table>

		<div id="clear"> </div>
	</div>

	<?php include('conf/footer.php') ?>


<script type="text/javascript">
// Variabelen die later voor de hele pagina nodig zijn:
var lokalen;
var software;
var geselecteerdSoftware = new Array();

//onload: Softwarepakketten via AJAX ophalen
xhr("ajax/software.php", verwerkSoftware);

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

	nieuw.innerHTML = '<a href="javascript:void(0);"onclick="removeMe(this);geselecteerdSoftware.remove(\''+ pakket_id +'\')">'+
						'<img src="img/delete.png" title="Verwijder softwarepakket"></a> ' +
						pakket_naam;

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

	document.nieuwImage.appendChild(hiddenInput); // element in formulier schrijven

	return validate.form(form);

}

</script>
</body>
</html>