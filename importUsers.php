<?php

include("conf/sessionCheck.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}

//
// De modus voor deze pagina ophalen
// er kunnen gebruikers of klassen geïmporteerd worden
//
if( isset($_GET['mode']) ){
	$mode = $_GET['mode'];
} else{
	die("Er is iets mis gegaan. Gelieve terug te keren naar de vorig pagina.");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Project ABC</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link href="style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8">
	<link rel="icon" href="img/favicon.ico">
</head>
<body>
	<div id="appBox">

		<?php include('conf/header.php') ?>

		<?php
			//
			// Code voor het importeren van gebruikers CSV
			//
			if($mode == 'gebruikers'){
		?>

			<h1>OPGELET!</h1>

			<div class="warning">
				OPGELET! Het CSV bestand dat u upload moet de juiste structuur zijn!<br />
				<ul>
					<li>In de eerste kolom moet de gebruikersnaam staan (maximum 3 karakters lang)</li>
					<li>In de tweede kolom moet het wachtwoord van de gebruiker staan. (Geen beperking)</li>
					<li>De velden moeten gescheiden zijn door een puntkomma</li>
				</ul>
			</div>

			<div class="info">
				Accounts worden NIET overschreven. Gebruik eerst de wis functie om alle leerkrachten accounts te verwijderen.<br />
				Nadien kan de CSV geimporteerd worden.
			</div>

			<br>

			<h1>Gebruikers wissen</h1>
			<p>Met deze functie verwijderd u ALLE niet-administrator accounts. Deze actie is onomkeerbaar!</p>
			<button onclick="return confirmDelete()">Accounts verwijderen</button>


		<?php
			} // einde importeren gebruikers

			//
			// Importfunctie voor klassen
			//
			if($mode == 'klassen'){
		?>
			<h1>OPGELET!</h1>

			<div class="warning">
				OPGELET! Het CSV bestand dat u upload moet de juiste structuur zijn!<br />
				<ul>
					<li>In de eerste kolom moet de naam van het lokaal staan staan (maximaal 10 karakters lang)</li>
					<li>In de tweede kolom moet de beschrijving van het lokaal staan. (Maximaal 50 karakters lang)</li>
					<li>In de derde kolom moeten de voorzieningen van het lokaal staan. (Geen maximale lengte) </li>
					<li>De velden moeten gescheiden zijn door een puntkomma</li>
				</ul>
			</div>

			<div class="info">
				Bestaande lokalen worden door de importeer functie NIET overschreven.
			</div>
		<?php
			} // einde importfunctie klassen
		?>

			<br><br>

		<?php
			if($mode == 'gebruikers'){
				echo "<h1>CSV met gebruikers importeren</h1>";
			}else{
				echo "<h1>CSV met lokalen importeren</h1>";
			}
		?>
			<form action="edit/uploadCSV.php" method="post" enctype="multipart/form-data">

				<p>CSV bestand: <input name="file" type="file" size="35" /></p>
				<input type="submit" name="Submit" value="Upload" />
				<input type="hidden" name="mode" value="<?php echo $mode ?>" />
			</form>



		<div id="clear"> </div>
	</div>

	<?php include('conf/footer.php') ?>
<script type="text/javascript">
function confirmDelete(){
	var answer = confirm("Bent u zeker dat u alle leerkrachten account wilt wissen? Deze actie is onomkeerbaar!");
	if(answer){
		window.location = "edit/removeAllUserAcc.php"
	}
}
</script>
</body>
</html>