<?php

require_once dirname(__FILE__).'/../../../mysql/database.php'; // Include the database connection

class Comment {
    public $username, $comment_id, $user_id, $text;
    function __construct($username, $comment_id, $user_id, $text) {
        $this->username = $username;
        $this->user_id = $user_id;
        $this->comment_id = $comment_id;
        $this->text = $text;
    }
}

// load the comments for post with id $id
function loadComments($id){
    global $mysqli;
    $comments = array();
    $stmt = $mysqli->prepare('select users.username, id, comments.user_id, text from comments join users on (comments.user_id=users.user_id) where post_id = ?');
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->bind_result($username, $comment_id, $user_id, $text);

    $comments = array();

    while($stmt->fetch()){
        $comment = new Comment($username, $comment_id, $user_id, $text);
        array_push($comments, $comment);
    }
    return $comments;
}
?>
