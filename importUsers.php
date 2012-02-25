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
</head>
<body>
	<div id="appBox">

		<?php include('conf/header.php') ?>

		<h1>Leerkrachten importeren</h1>

		<div class="warning">
			OPGELET! Het CSV bestand dat u upload moet de juiste structuur zijn!<br />
			In de eerste kolom moet de gebruikersnaam staan (maximum 3 karakters lang).<br />
			In de tweede kolom moet het wachtwoord van de gebruiker staan. (Geen beperking)<br><br>
			De velden moeten gescheiden zijn door een puntkomma.
		</div>

		<form action="uploadCSV.php" method="post" enctype="multipart/form-data">

			<p>CSV bestand: <input name="file" type="file" size="35" /></p>
			<input type="submit" name="Submit" value="Upload" />

		</form>

		<div id="clear"> </div>
	</div>

	<?php include('conf/footer.php') ?>

<script type="text/javascript">
</script>
</body>
</html>