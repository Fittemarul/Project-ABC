<?php

session_start();

if(!isset($_SESSION['username'])){
	die(header("Location: index.php"));
}

$username = $_SESSION["username"];

?>