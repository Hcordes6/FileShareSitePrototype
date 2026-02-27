<?php
session_start();
require '../../../mysql/database.php'; // Include the database connection

$isLoggedIn = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : false;
if (!$isLoggedIn) {
    header('Location: ../../../user/login.php'); // Redirect to news site after successful registration
    exit();
}
$userId = $_SESSION["user_id"];

echo var_dump($_POST).'\n';

if(!hash_equals($_SESSION['token'], $_POST['token'])){
    echo $_SESSION['token']." /vs/ ".$_POST['token'];
	die("Request forgery detected");
}

// Check if form data is submitted
$post_id = (string) $_POST['post_id'];
$text = (string) $_POST['text'];

// insert post into database
$stmt = $mysqli->prepare("insert into comments (post_id, user_id, text) values (?, ?, ?)");
$stmt->bind_param("sss", $post_id, $userId, $text);
$stmt->execute();
header('Location: ../../display.php?id='.$post_id); // Redirect back to post page after posting
$stmt->close();

?>
