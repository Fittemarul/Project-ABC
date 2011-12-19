<?php

include("conf/sessionCheck.php");

$ref = file_get_contents('.git/refs/heads/master');
$ref = substr($ref, 0, 7);
///c7ea14e
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

	<div id="footer">Copyright 2011, Xavier Decuyper<br />
		<span style="font-family:courier">Ref: <?php echo $ref ?></span></div>

</body>
</html>