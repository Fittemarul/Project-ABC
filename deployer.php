<?php
include("conf/sessionCheck.php");

if(!$is_admin){
	die("U heeft geen toegang tot deze pagina");
}
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


		<h1>Deployer log</h1>
		<?php
			echo str_replace("\n", "<br>", file_get_contents("http://abc.savjee.be/gitDeploy/log.txt"));
		?>

		<div id="clear"> </div>
	</div>

	<?php include('conf/footer.php') ?>
</body>
</html>
