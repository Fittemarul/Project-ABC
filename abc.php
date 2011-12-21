<?php
include("conf/sessionCheck.php");
?>
<html>
<head>
	<title>Project ABC</title>
	<link href="style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8">
</head>
<body>
	<div id="appBox">
		<?php include('conf/header.php') ?>

		<ul id="selectieLeerkrachten">

			<a href="wensen.php">
				<li><img src="img/pencil.png">
					Wensen invoeren
				</li>
			</a>
			
			<a href="lokalen.php">
				<li><img src="img/klassen.png">
					Lokalen beheren
				</li>
			</a>
			
			<a href="gebruikers.php">
				<li><img src="img/users.png">
				Gebruikers beheren
				</li>
			</a>

		</ul>

		<div id="clear"> </div>
	</div>
	
	<?php include('conf/footer.php') ?>
</body>
</html>