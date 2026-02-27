<?php
// post story function

session_start();
require '../../../mysql/database.php'; // Include the database connection

$isLoggedIn = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : false;
if (!$isLoggedIn) {
    header('Location: ../../../user/login.php'); // Redirect to news site after successful registration
    exit();
}
$userId = $_SESSION["user_id"];

if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}


// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = (string) $_POST['title'];
    $body = (string) $_POST['body'];
    $link = (string) $_POST['link'];


    if ($link === ""){
        $link = null;
    }

    printf('insert into posts (user_id, title, body, link, vote_count) values ("%s", "%s", "%s", "%s", 0)', $userId, $title, $body, $link);
    // insert post into database
    $stmt = $mysqli->prepare("insert into posts (user_id, title, body, link, vote_count) values (?, ?, ?, ?, 0)");
    $stmt->bind_param("ssss", $userId, $title, $body, $link);
    if($stmt->execute()){
        header('Location: ../../../newsSite.php'); // Redirect to news site after posting
    }else{
        header('Location: ../../createPost.php'); // Redirect to post creation after an error
    }
    $stmt->close();
}


?>
