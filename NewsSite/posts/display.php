<?php
// display the post from id

session_start();
require dirname(__FILE__).'/actions/story/loadStory.php';
require dirname(__FILE__).'/actions/comment/load.php';
$id = $_GET["id"];
$story = loadStory($id);
$isLoggedIn = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : false;
if ($isLoggedIn){
    $userId = $_SESSION["user_id"];
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Site</title>
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <header>
        <h1>News Site</h1>
        <div>
            <!-- Conditionally renders Login/signout button based on $_SESSION["user_id"] status -->
            <?php if ($isLoggedIn): ?>
                <form action="../logout.php" method="post" id="signoutForm">
                    <button class="button" id="signout" type="submit">Sign Out</button>
                </form>
            <?php else: ?>
                <button class="button" id="login" onclick="window.location.href='user/login.php'">Login</button>
            <?php endif; ?>
        </div>
    </header>
    <main>
        <article class="post">
            <div class="post-header">
                <h2> <?php echo htmlentities($story->title) ?> </h2>
                <div class="story-meta">
                    <span class="vote-display"><?php echo $story->vote_count ?> points</span>
                    <span class="post-date"><?php echo date("M j, Y \a\t g:i A", strtotime($story->created)) ?></span>
                </div>
                <?php if ($story->creatorId == $userId): ?>
                 <div>
                    <form action="actions/story/delete.php" method="post">
                        <button class="edit" formaction='editPost.php?id=<?php echo $id?>'>Edit</button>
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                        <input type="hidden" name="post_id" value="<?php echo $id;?>" />
                        <button type="submit" class="delete">Delete</button>
                    </form>
                 </div>
                <?php endif ?>
            </div>
            <p><strong><?php echo htmlentities($story->authorUname); ?></strong></p>
            <?php echo htmlentities($story->body) ?>
            <?php
                if ($story->link != null){
                    echo "<p class='storyLink'><a href='".$story->link."'>".$story->link."</a></p>";
                }
            ?>
            <div class="comments">
                <?php 
                    $comments = loadComments($id);
                    $comments_len = count($comments);
                ?>
                <div class="comments-header">
                <h3>Comments (<?php echo $comments_len ?>)</h3>
                    <!-- Show if the user is logged in-->
                </div>
                <form class="commentForm" action="actions/comment/comment.php" method="post">
                    <input class="text" type="text" name="text" required />
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                    <input type="hidden" name="post_id" value="<?php echo $id;?>" />
                    <button class="post" type="submit">post comment</button>
                </form>
                <?php foreach($comments as $comment): ?>
                    <div class="comment">
                        <?php if($_POST["edit_comment"] == true && $_POST["comment_id"] == $comment->comment_id): ?>
                            <p>
                                <strong><?php echo htmlentities($comment->username)?>:</strong>
                            </p>
                            <?php if($comment->user_id == $userId): ?>
                                <div>
                                    <form method="post">
                                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                                        <input type="hidden" name="comment_id" value="<?php echo $comment->comment_id;?>" />
                                        <input type="hidden" name="post_id" value="<?php echo $id;?>" />
                                        <input class="text" type="text" name="text" value="<?php echo htmlentities($comment->text) ?>" required/>
                                        <button type="submit"
                                            formaction="actions/comment/edit.php" class="edit">Edit
                                        </button>
                                    </form>
                                </div>
                            <?php endif ?>
                        <?php else: ?>
                            <p>
                                <strong><?php echo $comment->username?>:</strong>
                                <?php echo $comment->text ?>
                            </p>
                            <?php if($comment->user_id == $userId): ?>
                                <div>
                                    <form method="post">
                                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                                        <input type="hidden" name="comment_id" value="<?php echo $comment->comment_id;?>" />
                                        <input type="hidden" name="post_id" value="<?php echo $id;?>" />
                                        <input type="hidden" name="edit_comment" value="true" />
                                        <button type="submit"
                                            formaction="<?php echo $_SERVER['PHP_SELF'].'?id='.$id; ?>" class="edit">Edit
                                        </button>
                                        <button type="submit" formaction="actions/comment/delete.php" class="delete">Delete</button>
                                    </form>
                                </div>
                            <?php endif ?>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
        </article>
    </main>
</body>

</html>

