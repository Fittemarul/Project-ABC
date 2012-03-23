<?php

include("conf/db.php");
include("conf/sessionCheck.php");
include("conf/functions.php"); // voor functie getSoftwarePackage


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
</head>
<body>
	<div id="appBox">

		<?php include('conf/header.php') ?>

		<h1>Wensen bekijken</h1>

		<table class="sortable" width="100%">
			<tr class="noSelect">
				<th width="70px">Opties</th>
				<th width="170px">Datum</th>
				<th width="100px">Leerkracht</th>
				<th>Vak</th>
				<th>Klas</th>
				<th>Uren</th>
				<th>Lokaal</th>
				<th>Software</th>
			</tr>

		<?php
			$qry_wensen = mysql_query("SELECT a.id, a.date, a.leerkracht, a.vak, a.klas, a.uren, a.software, b.lokaal
										FROM wensen a
										INNER JOIN lokalen b ON a.lokaal = b.id");


			while($row = mysql_fetch_assoc($qry_wensen)){
				// Variabelen voor edit functie in JS
				$id = $row['id'];
				$date = $row['date'];
				$leerkracht = $row['leerkracht'];
				$vak = $row['vak'];
				$klas = $row['klas'];
				$uren = $row['uren'];
				$lokaal = $row['lokaal'];

				$software = explode(",", $row['software']);
				$software_html = "";

				for($i=0; $i<= count($software)-1; $i++){
					$software_html .= getSoftwarePackage($software[$i]);
				}

				echo "<tr>";
					echo "<td>".
						"<a href='#' onclick='deleteWish($id)'>".
							"<img src='img/delete.png' title='Wens verwijderen'></a> ".
						"</td>";
					echo "<td>$date</td>";
					echo "<td>$leerkracht</td>";
					echo "<td>$vak</td>";
					echo "<td>$klas</td>";
					echo "<td>$uren</td>";
					echo "<td>$lokaal</td>";
					echo "<td>$software_html</td>";

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
	document.nieuwLokaal.voorzieningen.value = voorzieningen.replace(/<br>/g, "\n");


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
// Functie voor het verwijderen van een wens
//
function deleteWish(id){
	var msg = confirm("Bent u zeker dat u deze wens wilt verwijderen?\n(Actie onomkeerbaar)");

	if(msg){
		window.location = "edit/deleteWish.php?id=" + id;
	}else{
		return false
	}
}

</script>
</body>
</html>