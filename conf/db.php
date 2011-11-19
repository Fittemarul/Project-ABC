<?
$db_host = 'localhost:8889';
$db_user = 'root';
$db_pwd = 'root';

$db_database = 'abc';

$link = mysql_connect($db_host, $db_user, $db_pwd);
if (!mysql_select_db($db_database)) die("Couldn't connect to the database. Probably on fire or something.");

?>