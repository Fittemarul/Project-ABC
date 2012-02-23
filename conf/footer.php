<?php
	// huidige revisie hash uit de git repository halen
	$ref = file_get_contents('http://abc.savjee.be/gitDeploy/currentBranch');
?>

<div id="footer">Copyright 2012, Xavier Decuyper<br />
	<span style="font-family:courier">Ref: <?php echo $ref ?></span>
</div>