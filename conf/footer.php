<?php
	// huidige revisie hash uit de git repository halen
	$ref = file_get_contents('.git/refs/heads/master');
	
	// hash verkorten naar 7 karakters
	$ref = substr($ref, 0, 7);
?>

<div id="footer">Copyright 2011-2012, Xavier Decuyper<br />
	<span style="font-family:courier">Ref: <?php echo $ref ?></span>
</div>