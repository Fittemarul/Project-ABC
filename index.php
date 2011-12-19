<?php
	session_start();

	// Al ingelogd?
	if( isset($_SESSION['username']) ){
		header("Location: abc.php");
	}

	// Controleer of er gegevens zijn gepost
	if($_POST){
		include("conf/db.php");

		$username = mysql_real_escape_string($_POST['username']);
		$password = sha1($_POST['password']);

		$qry_check = mysql_query("SELECT is_admin FROM users WHERE username = '$username' AND userpass = '$password' AND active = '1'");

		if(mysql_num_rows($qry_check) == 1){
						
			if(mysql_fetch_field($qry_check) == "1"){
				$_SESSION['is_admin'] = true;
			}
			
			$_SESSION['username'] = $username;
			
			header("Location: abc.php");
		}else{
			echo "<span class='error'>Gebruikersnaam en/of wachtwoord verkeerd.</span>";
		}

	}
?>
<html>
<head>
	<title>Project ABC</title>
	<link href="style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8">

	<script type="text/javascript">
		function $(a){return document.getElementById(a)} // korte functie voor getElementById

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
<body>
	<div id="loginBox" style="text-align:center">
		<div id="logo"></div>

		<form action="index.php" method="POST" onsubmit="return validateInput()">

			<p style="text">Gebruikersnaam<br />
			<input type="text" class="loginInput" name="username" id="username"></p>

			<p>Wachtwoord<br />
			<input type="password" class="loginInput" name="password" id="password"></p>
			

			<input type="submit" value="Login" id="btnSubmit"/>
		
		</form>

	</div>

	<div id="footer">Copyright 2011, Xavier Decuyper</div>

</body>
</html>