<?php
include("conf/sessionCheck.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Project ABC</title>
	<link href="style.css" rel="stylesheet" type="text/css" media="screen" charset="utf-8">
	<link rel="icon" href="img/favicon.ico">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
<body>
	<div id="appBox">
		<?php include('conf/header.php') ?>


	<?php
		if(!$is_admin){ // gebruiker is GEEN administrator
	?>
	<div style="margin:0 auto; width:480px">
		<ul class="selectieMenu">
			<h1>Leerkracht</h1>

			<a href="wensen.php">
				<li><img src="img/pencil.png">
					Wensen invoeren
				</li>
			</a>
		</ul>
	</div>
	<?php
		} // einde if GEEN admin
		if($is_admin){ // gebruiker IS admin
	?>
	<div style="width: 480px; float:left;">
		<ul class="selectieMenu">
			<h1>Administratie</h1>

			<a href="wensen.php">
				<li><img src="img/pencil.png">
					Wensen invoeren
				</li>
			</a>

			<a href="admWensen.php">
				<li><img src="img/wensen.png">
					Wensen bekijken
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

			<a href="software.php">
				<li><img src="img/software.png">
					Softwarepakketten beheren
				</li>
			</a>

			<a href="computers.php">
				<li><img src="img/inventaris.png">
					Computer inventaris
				</li>
			</a>

			<a href="leveranciers.php">
				<li><img src="img/leveranciers.png">
					Leveranciers beheren
				</li>
			</a>
		</ul>
	</div>

	<div style="width:480px; float:right">
		<ul class="selectieMenu">
			<h1>Tools</h1>
			<a href="backup.php">
				<li><img src="img/backup.png">
					Maak backup
				</li>
			</a>

			<a href="deployer.php">
				<li><img src="img/deployer.png">
					Deployer log
				</li>
			</a>
		</ul>
	</div>
		<?php
			} // einde if Admin
		?>

	<div id="clear"> </div>
</div>

<?php include('conf/footer.php') ?>
</body>
</html>
