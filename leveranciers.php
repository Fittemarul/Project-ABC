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
	<script type="text/javascript" src="js/sorttable.js"></script>
	<script type="text/javascript" src="js/core.js"></script>
</head>
<body>
	<div id="overlay">
		<h1 id="leverancierAddEdit">Gebruiker toevoegen</h1>
		
			<form action="edit/addLeverancier.php" method="post" onsubmit="return validate.form(this);" name="nieuwLeverancier">
		
			Leveranciernaam: <input type="text" name="leverancier" class="required"><br>
		
			<br><br>
			
			<input type="submit" value="Opslaan" id="btnSubmit"/>

		</form>
	</div>
	
	<div id="appBox">
		
		<?php include('conf/header.php') ?>

		<h1>Leveranciers beheren</h1>
		
		<p><a href="#" onclick="toggleShade()"><img src="img/user_add.png"> Leverancier toevoegen</a></p>
		
		<table class="sortable" width="100%">
			<tr class="noSelect">
				<th width="10%" class="sorttable_nosort">Opties</th>
				<th width="90%">Leveranciernaam</th>
			</tr>
		
		<?php
			$qry_users = mysql_query("SELECT id, leverancier_naam  FROM leveranciers ORDER BY leverancier_naam ASC LIMIT 100");
			
			while($row = mysql_fetch_assoc($qry_users)){
                               $leverancier = $row['leverancier_naam'];
                               $id = $row['id'];
				

				echo "<tr>";
					echo "<td style='text-align:center'>".
							"<a href='#' onclick='deleteLeverancier($id)'><img src='img/leverancier_delete.png' title='Leverancier verwijderen'></a> ".
							"<a href=\"javascript:editLeverancier('$id', '$leverancier')\"><img src='img/leverancier_edit.png' title='Leverancier bewerken'></a>".
						"</td>";
					echo "<td>$leverancier</td>";
				echo "</tr>";
			}
		?>
		
		</table>

		<div id="clear"> </div>
	</div>
	
	<?php include('conf/footer.php') ?>
	
<script type="text/javascript">

function deleteLeverancier(id){
	var msg = confirm("Bent u zeker dat u deze leverancier wilt verwijderen?\n(Actie onomkeerbaar)");
	
	if(msg){
		window.location = "edit/deleteLeverancier.php?id=" + id;
	}else{
		return false
	}
}

function editLeverancier(id, leverancier){
	toggleShade(); // Bewerk overlay tonen
	
	//
	// Waardes te wijzigen gebruiker wegschrijven in formulier
	//
	$('leverancierAddEdit').innerHTML = "Leverancier bewerken";
	
	document.nieuwLeverancier.leverancier.value = leverancier;
	
	
	//
	// Hidden input maken voor id
	//
	var hiddenInput = document.createElement('input');
	hiddenInput.setAttribute('type', 'hidden');
	hiddenInput.setAttribute('name', 'id');
	hiddenInput.setAttribute('value', id);
	
	document.nieuwLeverancier.appendChild(hiddenInput); // element in formulier schrijven
	
	document.nieuwLeverancier.action = "edit/editLeverancier.php";
	
}

function resetPsw(userID, username){
	var bevestig = confirm("Weet u zeker dat u het wachtwoord van '" + username + "' wilt resetten?");
	
	if(bevestig){
		var password = prompt("Geef het nieuwe wachtwoord voor '" + username + "' op:", "");
		
		if(password != "" && password != " "){
			window.location = "edit/user_resetpass.php?id=" + userID + "&pass=" + password;
		}
	}
}
</script>
</body>
</html>