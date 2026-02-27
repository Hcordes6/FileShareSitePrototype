<!-- 
Require this file when database query is needed
Use "require 'database.php';" in the file that needs to use the database
-->
<?php
$mysqli = new mysqli('localhost', 'wustl_inst', 'wustl_pass', 'newsSite');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>
