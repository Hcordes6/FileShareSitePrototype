<?php
session_start();
require_once '../../../mysql/database.php'; // Include the database connection

$isLoggedIn = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : false;
if (!$isLoggedIn) {
    header('Location: ../../../user/login.php'); // Redirect to news site after successful registration
    exit();
}
$userId = $_SESSION["user_id"];

echo "there  ";

if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

echo "came here:  ";

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id  = (string) $_POST['comment_id'];
    $post_id  = (string) $_POST['post_id'];
    $text  = (string) $_POST['text'];

    echo $comment_id.$post_id.$text;

    if ($link === ""){
        $link = null;
    }
    $stmt = $mysqli->prepare("update comments set text=? where id=? and user_id=?");
    $stmt->bind_param("sss", $text, $comment_id, $userId);
    $stmt->execute();

    $stmt->close();
    header('Location: ../../display.php?id='.$post_id); // Redirect to news site after posting
}


?>
