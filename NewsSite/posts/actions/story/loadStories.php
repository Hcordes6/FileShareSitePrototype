<?php

// load stories for the main page
// different sorting/filtering based on sort var

require_once dirname(__FILE__).'/../../../mysql/database.php'; // Include the database connection
require_once dirname(__FILE__).'/story.php'; // Include the database connection


$stories = array();

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'new';


if($sort == "my-votes"){
    $isLoggedIn = isset($_SESSION["user_id"]);

    if (!$isLoggedIn){
        exit();
    }

    $userId = $_SESSION["user_id"];

    $stmt = $mysqli->prepare("select posts.id, posts.user_id, title, body, link, created, vote_count from posts join votes on votes.story_id = posts.id where votes.user_id = ?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->bind_result($id, $creatorId, $title, $body, $link, $created, $voteCount);


    while($stmt->fetch()){
        $story = new Story($id, $creatorId, $title, $body, $link, $created, null, $voteCount);
        array_push($stories, $story);
    }
    /* var_dump($stories); */
}else{
    if ($sort === 'hot') {
        $orderBy = "vote_count DESC, created DESC";
    } else {
        $orderBy = "created DESC";
    }

    $stmt = $mysqli->prepare("select id, user_id, title, body, link, created, vote_count from posts ORDER BY ".$orderBy);
    $stmt->execute();
    $stmt->bind_result($id, $creatorId, $title, $body, $link, $created, $voteCount);

    while($stmt->fetch()){
        $story = new Story($id, $creatorId, $title, $body, $link, $created, null, $voteCount);
        array_push($stories, $story);
    }
}
?>
