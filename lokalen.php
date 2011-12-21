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
		<h1>Nieuw lokaal toevoegen</h1>
		
			<form action="edit/addLokaal.php" method="post" onsubmit="return validate.nieuwlokaal()" name="nieuwLokaal">
		
			Lokaal: <input type="text" name="lokaal"><br><br>
			Beschrijving: <br><textarea cols="40" rows="5" name="beschrijving"></textarea><br><br>
			Voorzieningen: <br><textarea cols="40" rows="5" name="voorzieningen"></textarea>
		
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
			$qry_lokalen = mysql_query("SELECT * FROM lokalen LIMIT 100");
			
			
			while($row = mysql_fetch_assoc($qry_lokalen)){
				echo "<tr>";
					echo "<td style='text-align:center' class='noSelect'>".
							"<a href='edit/lokaal.php?id=" . $row['id'] ."'><img src='img/pencil.png'></a>".
							"<a href='javascript:confirmDelete(".$row['id'].")'><img src='img/delete.png'></a>";
					echo "<td>". $row['lokaal'] ."</td>";
					echo "<td>". $row['beschrijving'] ."</td>";
					echo "<td>". $row['voorzieningen'] ."</td>";
				echo "</tr>";
			}
			
		
		?>
		
		</table>

		<div id="clear"> </div>
	</div>
	
	<?php include('conf/footer.php') ?>
	
<script type="text/javascript">

function confirmDelete(a){
	var msg = confirm("Bent u zeker dat u dit lokaal wilt verwijderen?");
	
	if(msg){
		window.location = "edit/deleteLokaal.php?id=" + a;
	}else{
		return false
	}
}

validate.nieuwlokaal = function(){
	
	var lokaal = document.nieuwLokaal.lokaal.value;
	var beschrijving = document.nieuwLokaal.beschrijving.value;
	var voorziening = document.nieuwLokaal.voorzieningen.value;
	
	if(lokaal == "" || lokaal == " " || beschrijving == " " || beschrijving == "" || voorziening == "" || voorziening == " "){
		alert("Gelieve alle velden in te vullen.");
		return false; // Form mag niet door!
	}else{
		$('btnSubmit').value = "Bezig met lokaal toe te voegen...";
		$('btnSubmit').disabled = true; // niet meer aanklikbaar
	}
	
}

</script>
</body>
</html>