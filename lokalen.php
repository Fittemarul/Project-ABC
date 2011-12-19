<?php

include("conf/db.php");
include("conf/sessionCheck.php");

echo $_SESSION['is_admin'];

?>
<html>
<head>
	<title>Project ABC</title>
	<link href="style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8">
	<script type="text/javascript" src="js/sorttable.js"></script>
	<script type="text/javascript" src="js/core.js"></script>
	
</head>
<body>
	<div id="shade" onclick="toggleShade()"></div>
	<div id="overlay">
		<h1>Nieuw lokaal toevoegen</h1>
		<p>geef<br>hier<br>wat<br>info</p>
	</div>
	
	<div id="appBox">
		<a href="abc.php"><div id="logoSmall"> </div></a>

		<div id="loggedInAs">
			Welkom <?php echo $username ?><br />
			<a href="logout.php">Uitloggen</a>
		</div>

		<div style="clear:both;"> </div>

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
					echo "<td style='text-align:center' class='noSelect'><a href='edit/lokaal.php?id=" . $row['id'] ."'><img src='img/pencil.png'></a>".
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
	<div id="footer">Copyright 2011, Xavier Decuyper</div>
<script type="text/javascript">

function confirmDelete(a){
	var msg = confirm("Bent u zeker dat u dit lokaal wilt verwijderen?");
	
	if(msg){
		window.location = "edit/deleteLokaal.php?id=" + a;
	}else{
		return false
	}
}

</script>
</body>
</html>