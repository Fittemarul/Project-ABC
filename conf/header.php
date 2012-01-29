<?php
    if(strpos($GLOBALS['HTTP_USER_AGENT'], "MSIE")){
        exit(header("Location: ieSorry.php"));
    } 
?>
<a href="abc.php"><div id="logoSmall"> </div></a>

<div id="loggedInAs">
	Welkom <?php echo $username ?><br />
	<a href="logout.php">Uitloggen</a>
</div>

<div style="clear:both;"> </div>