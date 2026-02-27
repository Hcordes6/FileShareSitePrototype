<?php
// save editing request

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
    $id  = (string) $_POST['post_id'];

    if ($link === ""){
        $link = null;
    }

    printf("update posts set title=%s, body=%s, link=%s where id=%s", $title, $body, $link, $id);

    // insert post into database
    $stmt = $mysqli->prepare("update posts set title=?, body=?, link=? where id=?");
    $stmt->bind_param("ssss", $title, $body, $link, $id);
    if($stmt->execute()){
        header('Location: ../../../newsSite.php'); // Redirect to news site after posting
    }else{
        header('Location: ../../createPost.php.php'); // Redirect to post creation after an error
    }
    $stmt->close();
}


?>
