<?php
require_once dirname(__FILE__).'/../../../mysql/database.php';

function getUserVote($storyId) {
    global $mysqli;
    $isLoggedIn = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : false;

    if (!$isLoggedIn){
        return 0;
    }

    $userVote = 0;
    $userId = $_SESSION["user_id"];
    $stmt = $mysqli->prepare("SELECT vote_value FROM votes WHERE user_id = ? AND story_id = ?");
    $stmt->bind_param("ii", $userId, $storyId);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userVote);
        $stmt->fetch();
    }
    $stmt->close();
    return $userVote;
}

?>
