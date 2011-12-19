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

			<li><img src="img/pencil.png">
				<a href="wensen.php">Wensen invoeren</a>
			</li>
			
			<li><img src="img/klassen.png">
				<a href="lokalen.php">Lokalen beheren</a>
			</li>

		</ul>

		<div id="clear"> </div>
	</div>
	
	<?php include('conf/footer.php') ?>
</body>
</html>