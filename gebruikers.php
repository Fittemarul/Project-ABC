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
		<h1 id="userAddEdit">Gebruiker toevoegen</h1>
		
			<form action="edit/addUser.php" method="post" onsubmit="return validate.form(this);" name="nieuwUser">
		
			Gebruikersnaam: <input type="text" name="username" maxlength="3" class="required"><br>
			
			<span id="psswd">
				Wachtwoord: <input type="password" name="password" class="required"> 
							(<input type="checkbox" onchange="validate.pass(this)"/> Toon wachtwoord)<br>
			</span>
			Administrator: <input type="checkbox" name="admin"/><br>
			Actief ? <input type="checkbox" name="actief" checked="true">
		
			<br><br>
			
			<input type="submit" value="Opslaan" id="btnSubmit"/>

		</form>
	</div>
	
	<div id="appBox">
		
		<?php include('conf/header.php') ?>

		<h1>Gebruikers beheren</h1>
		
		<p><a href="#" onclick="toggleShade()"><img src="img/user_add.png"> Gebruiker toevoegen</a></p>
		
		<table class="sortable" width="100%">
			<tr class="noSelect">
				<th width="10%" class="sorttable_nosort">Opties</th>
				<th width="20%">Gebruikersnaam</th>
				<th width="35%">Laatst ingelogd</th>
				<th width="10%">Admin?</th>
				<th width="10%">Actief?</th>
			</tr>
		
		<?php
			$qry_users = mysql_query("SELECT id, username, time_lastlogon, is_admin, active  FROM users LIMIT 100");
			
			while($row = mysql_fetch_assoc($qry_users)){
				$user_id = $row['id'];
				$user_name = $row['username'];
				
				$admin = ($row['is_admin'] == '1' ? 'Ja' : "Nee");
				$active = ($row['active'] == '1' ? 'Ja' : "Nee");
				
				// Variabelen voor bewerkfunctie in JS
				$admin_edit = ($row['is_admin'] == '1' ? 'true' : "false");
				$active_edit = ($row['active'] == '1' ? 'true' : "false");
				
				$time_lastlogon = ($row['time_lastlogon'] == "0000-00-00 00:00:00" ? "Nog niet ingelogd" : $row['time_lastlogon']);

				echo "<tr>";
					echo "<td style='text-align:center'>".
							"<a href='#' onclick='deleteUser($user_id)'><img src='img/user_delete.png' title='Verwijderen'></a> ".
							"<a href=\"javascript:editUser('$user_id', '$user_name', $admin_edit, $active_edit)\"><img src='img/user_edit.png'></a>".
						"</td>";
					echo "<td>$user_name</td>";
					echo "<td>$time_lastlogon</td>";
					echo "<td>$admin</td>";
					echo "<td>$active</td>";
				echo "</tr>";
			}
		?>
		
		</table>

		<div id="clear"> </div>
	</div>
	
	<?php include('conf/footer.php') ?>
	
<script type="text/javascript">

validate.pass = function(a){
	if(a.checked){
		document.nieuwUser.password.type = "text";
	}else{
		document.nieuwUser.password.type = "password";
	}
}

function deleteUser(id){
	var msg = confirm("Bent u zeker dat u deze gebruiker wilt verwijderen?\n(Actie onomkeerbaar)");
	
	if(msg){
		window.location = "edit/deleteUser.php?id=" + id;
	}else{
		return false
	}
}

function editUser(id, username, is_admin, active){
	toggleShade(); // Bewerk overlay tonen
	
	//
	// Waardes te wijzigen gebruiker wegschrijven in formulier
	//
	$('userAddEdit').innerHTML = "Gebruiker bewerken";
	$('psswd').style.display = "none";
	document.nieuwUser.password.setAttribute("class", "");
	
	
	document.nieuwUser.username.value = username;
	document.nieuwUser.admin.checked = is_admin;
	document.nieuwUser.actief.checked = active;
	
	
	//
	// Hidden input maken voor id
	//
	var hiddenInput = document.createElement('input');
	hiddenInput.setAttribute('type', 'hidden');
	hiddenInput.setAttribute('name', 'id');
	hiddenInput.setAttribute('value', id);
	
	document.nieuwUser.appendChild(hiddenInput); // element in formulier schrijven
	
	document.nieuwUser.action = "edit/editUser.php";
	
}
</script>
</body>
</html>