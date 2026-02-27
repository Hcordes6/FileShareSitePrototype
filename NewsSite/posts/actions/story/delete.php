<?php
// delete story request

session_start();
require_once '../../../mysql/database.php'; // Include the database connection
require_once './loadStory.php';

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
    $id  = (string) $_POST['post_id'];
    echo $id;
    $story = loadStory($id);
    if ($story->creatorId != $userId){
        echo "this user is not creator of this post";
        exit();
    }


    if ($link === ""){
        $link = null;
    }
    $stmt = $mysqli->prepare("delete from comments where post_id=?");
    $stmt->bind_param("s", $id);
    $stmt->execute();

    $stmt = $mysqli->prepare("delete from posts where id=?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->close();
    header('Location: ../../../newsSite.php'); // Redirect to news site after posting
}


?>
