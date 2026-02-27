<?php

// load the story for display

require_once dirname(__FILE__).'/../../../mysql/database.php'; // Include the database connection
require_once dirname(__FILE__).'/story.php'; // Include the database connection

function loadStory($id) {
    global $mysqli;
    $stmt = $mysqli->prepare('select id, users.user_id, title, body, link, created, users.username, posts.vote_count from posts join users on (users.user_id=posts.user_id) where id=?');
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->bind_result($id, $creatorId, $title, $body, $link, $created, $authorUname, $voteCount);
    $stmt->fetch();
    $story = new Story($id, $creatorId, $title, $body, $link, $created, $authorUname, $voteCount);
    return $story;
}

?>
