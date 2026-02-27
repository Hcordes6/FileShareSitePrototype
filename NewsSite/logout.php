<!-- Logout manager page-->

<?php
// This is a logout page that destroys the session and redirects to fileShare.php
// Separate page was necessary for logout to work properly
session_start();
$_SESSION = [];
session_destroy();
header("Location: newsSite.php");
?>