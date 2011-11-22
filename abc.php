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
		<div id="logoSmall"> </div>

		<div id="loggedInAs">
			Welkom <?php echo $username ?><br />
			<a href="logout.php">Uitloggen</a>
		</div>

		<div style="clear:both;"> </div>

		<ul id="selectieLeerkrachten">

			<li><img src="img/pencil.png">
				<a href="wensen.php">Wensen invoeren</a>
			</li>
			
			<li><img src="img/klassen.png">
				<a href="lokalen.php">Lokalen bekijken</a>
			</li>

		</ul>

		<div id="clear"> </div>
	</div>

	<div id="footer">Copyright 2011, Xavier Decuyper</div>

</body>
</html>