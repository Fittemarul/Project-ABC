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
				<th width="10%" class="sorttable_nosort">Opties</th>
				<th width="20%">Lokaal</th>
				<th width="40%">Beschrijving</th>
				<th width="40%">Voorzieningen</th>
			</tr>
		
		<?php
			$qry_lokalen = mysql_query("SELECT * FROM lokalen ORDER BY lokaal ASC");
			
			
			while($row = mysql_fetch_assoc($qry_lokalen)){
				// Variabelen voor edit functie in JS
				$lokaalID = $row['id'];
				$lokaal = $row['lokaal'];
				$beschrijving = $row['beschrijving'];
				$voorzieningen = $row['voorzieningen'];
				
				echo "<tr>";
				
					echo "<td style='text-align:center' class='noSelect'>".
							"<a href=\"javascript:editLokaal('$lokaalID', '$lokaal', '$beschrijving', '$voorzieningen') \"><img src='img/pencil.png' title='Lokaal bewerken'></a>".
							"<a href='javascript:confirmDelete(".$row['id'].")'><img src='img/delete.png' title='Lokaal verwijderen'></a></td>";
							
					echo "<td>". $row['lokaal'] ."</td>";
					echo "<td>". str_replace("\n", "<br>", $row['beschrijving']) ."</td>";
					echo "<td>". str_replace("\n", "<br>", $row['voorzieningen']) ."</td>";
				echo "</tr>";
			}
			
		
		?>
		
		</table>

		<div id="clear"> </div>
	</div>
	
	<?php include('conf/footer.php') ?>
	
<script type="text/javascript">

function confirmDelete(a){
	var msg = confirm("Bent u zeker dat u dit lokaal wilt verwijderen?\n(OPGELET: Alle computers die geassocieerd zijn met dit lokalen zullen ook verwijderd worden!)");
	
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