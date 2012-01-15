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
		<h1 id="lokaalAddEdit">Nieuw lokaal toevoegen</h1>
		
			<form action="edit/addLokaal.php" method="post" onsubmit="return validate.form(this);" name="nieuwLokaal">
		
			Lokaal: <input type="text" name="lokaal" class="required"><br><br>
			Beschrijving: <br><textarea cols="40" rows="5" name="beschrijving" class="linebreak"></textarea><br><br>
			Voorzieningen: <br><textarea cols="40" rows="5" name="voorzieningen" class="required linebreak"></textarea>
		
			<br><br>
		
			<input type="submit" value="Opslaan" id="btnSubmit"/>
		
		</form>
	</div>
	
	<div id="appBox">
		
		<?php include('conf/header.php') ?>

		<h1>Lokalen beheren</h1>
		<p><a href="#" onclick="toggleShade()"><img src="img/add.png"> Lokaal toevoegen</a></p>
		<table class="sortable" width="100%">
			<tr class="noSelect">
				<th class="sorttable_nosort"> </th>
				<th width="20%">Lokaal</th>
				<th width="40%">Beschrijving</th>
				<th width="40%">Voorzieningen</th>
			</tr>
		
		<?php
			$qry_lokalen = mysql_query("SELECT * FROM lokalen LIMIT 100");
			
			
			while($row = mysql_fetch_assoc($qry_lokalen)){
				// Variabelen voor edit functie in JS
				$lokaalID = $row['id'];
				$lokaal = $row['lokaal'];
				$beschrijving = str_replace(array("\r", "\r\n", "\n"), "<br>", $row['beschrijving']);
				$voorzieningen = str_replace(array("\r", "\r\n", "\n"), "<br>", $row['voorzieningen']);
				
				echo "<tr>";
				
					echo "<td style='text-align:center' class='noSelect'>".
							"<input type='radio' name='actions' onClick=\"selectRecord('$lokaalID', '$lokaal', '$beschrijving', '$voorzieningen')\">"
							
						//	"<a href=\"javascript:editLokaal('$lokaalID', '$lokaal', '$beschrijving', '$voorzieningen') \"><img src='img/pencil.png' title='Lokaal bewerken'></a>".
						//	"<a href='javascript:confirmDelete(".$row['id'].")'><img src='img/delete.png' title='Lokaal verwijderen'></a></td>"
						;
							
					echo "<td>". $row['lokaal'] ."</td>";
					echo "<td>". str_replace("\n", "<br>", $row['beschrijving']) ."</td>";
					echo "<td>". str_replace("\n", "<br>", $row['voorzieningen']) ."</td>";
				echo "</tr>";
			}
			
		
		?>
		
		</table>
		
		<p>Met geselecteerde record: <a href="javascript:">

		<div id="clear"> </div>
	</div>
	
	<?php include('conf/footer.php') ?>
	
<script type="text/javascript">
//
// Variabelen die globaal nodig zijn en gedeeld worden door meerdere functies
//
var lokaalID, lokaalNaam, lokaalBeschrijving, lokaalVoorzieningen;

function confirmDelete(a){
	var msg = confirm("Bent u zeker dat u dit lokaal wilt verwijderen?");
	
	if(msg){
		window.location = "edit/deleteLokaal.php?id=" + a;
	}else{
		return false
	}
}

//
// Functie die de variabelen wegschrijft die nodig zijn bij bewerken van een record
//
function selectRecord(id, lokaal, beschrijving, voorzieningen){
	alert("selectedRecord");
	lokaalID = id;
	lokaalNaam = lokaal;
	lokaalBeschrijving = beschrijving;
	lokaalVoorzieningen = voorzieningen;
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