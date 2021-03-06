<?php
	session_start();

	// Al ingelogd?
	if( isset($_SESSION['username']) ){
		header("Location: abc.php");
	}

	// Controleer of er gegevens zijn gepost
	if($_POST){
		include("conf/db.php"); // verbinding maken met database

		$username = strtoupper($_POST['username']); // gebruikersnaam eerst naar uppercase
		$username = mysql_real_escape_string($username); // veilig maken voor db

		$password = sha1($_POST['password']); // wachtwoord direct hashen

		$qry_check = mysql_query("SELECT is_admin, active FROM users WHERE username = '$username' AND userpass = '$password'");


		//
		// Controleren of er slechts 1 record overeenkomt met de eisen
		//
		if(mysql_num_rows($qry_check) == 1){

			//
			// Info over gebruiker uit db halen
			//
			$row = mysql_fetch_row($qry_check);

			//
			// Is deze gebruiker actief?
			//
			if($row[1] == '0'){
				echo "<div class='warning' style='margin:0 auto;'>Deze account is niet meer actief</div>";
			}else{

				$_SESSION['username'] = $username; // Sessie met username opslaan


				//
				// Is deze gebruiker een administrator?
				//

				if($row[0] == "1"){
					$_SESSION['is_admin'] = true;
				}else{
					$_SESSION['is_admin'] = false;
				}

				//
				// Huidig tijdstip noteren als laatst ingelogd
				//
				$qry_lastlogon = mysql_query("UPDATE  users SET  time_lastlogon =  CURRENT_TIMESTAMP WHERE  username = '$username' LIMIT 1") or die(mysql_error());

				//
				// Alles in orde, gebruiker mag doorgaan!
				//
				header("Location: abc.php");

			}

		}else{ // Verkeerde gegevens

			echo "<div class='error' style='margin:0 auto;'>Gebruikersnaam en/of wachtwoord verkeerd.</div>";

		}

	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Project ABC</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link href="style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8">
	<link rel="icon" href="img/favicon.ico">
	<script type="text/javascript" src="js/core.js"></script>
	<script type="text/javascript">
		function validateInput(){
			var username = $('username').value,
				password = $('password').value;

			if(username.replace(" ", "") == "" || password == ""){
				alert("Vul uw gebruikersnaam en passwoord in alvorens in te loggen.");
				return false;
			}

			// Knop inloggen vervangen door bezig
			$('btnSubmit').value = "Bezig met inloggen...";
			$('btnSubmit').disabled = true; // niet meer aanklikbaar

		}
	</script>
</head>
<body onload="$('username').focus()">
	<div id="loginBox" style="text-align:center">
		<div id="logo"></div>

		<form action="index.php" method="POST" onsubmit="return validateInput()">

			<p style="text">Gebruikersnaam<br />
			<input type="text" class="loginInput" name="username" id="username" autocomplete="off"></p>

			<p>Wachtwoord<br />
			<input type="password" class="loginInput" name="password" id="password"></p>


			<input type="submit" value="Login" id="btnSubmit"/>

		</form>

	</div>

	<div id="footer">Copyright 2012, Xavier Decuyper</div>

</body>
</html>