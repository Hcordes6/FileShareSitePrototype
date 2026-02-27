<!-- This is the main page for News Site-->

<?php
session_start();
require_once './posts/actions/vote/getVote.php';
require_once './posts/actions/story/loadStories.php';

$isLoggedIn = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : false;
if ($isLoggedIn) {
    $userId = $_SESSION["user_id"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Site</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>News Site</h1>
        <div>
            <!-- Conditionally renders Login/signout button based on $_SESSION["user_id"] status -->
            <?php if ($isLoggedIn): ?>
                <form action="logout.php" method="post" id="signoutForm">
                    <button class="button" id="signout" type="submit">Sign Out</button>
                </form>
            <?php else: ?>
                <button class="button" id="login" onclick="window.location.href='user/login.php'">Login</button>
            <?php endif; ?>
        </div>
    </header>
    <main>
        <!-- Show if the user is logged in -->
        <form class="searchForm" action="posts/createPost.php" method="GET">
            <button class="button" id="upload" type="submit">Create Post</button>
        </form>
        
        <div class="sort-toggle">
            <a href="?sort=new" class="<?php echo (!isset($_GET['sort']) || $_GET['sort'] === 'new') ? 'active' : '' ?>">New</a> | 
            <a href="?sort=hot" class="<?php echo (isset($_GET['sort']) && $_GET['sort'] === 'hot') ? 'active' : '' ?>">Hot</a> |
            <a href="?sort=my-votes" class="<?php echo (isset($_GET['sort']) && $_GET['sort'] === 'my-votes') ? 'active' : '' ?>">My votes</a>
        </div>
        
        <!-- Example Post -->
        <?php foreach ($stories as $story): ?>
            <article class="post_short">
                <div class="story-votes">
                    <?php if ($isLoggedIn): ?>
                        <form class="vote-form" action="posts/actions/vote/vote.php" method="POST">
                            <input type="hidden" name="story_id" value="<?php echo $story->id ?>">
                            <input type="hidden" name="vote_value" value="1">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
                            <button type="submit" class="vote-btn upvote <?php if(getUserVote($story->id) == 1) echo 'voted'; ?>">▲</button>
                        </form>
                    <?php endif; ?>
                    <span class="vote-count"><?php echo $story->vote_count ?></span>
                    <?php if ($isLoggedIn): ?>
                        <form class="vote-form" action="posts/actions/vote/vote.php" method="POST">
                            <input type="hidden" name="story_id" value="<?php echo $story->id ?>">
                            <input type="hidden" name="vote_value" value="-1">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
                            <button type="submit" class="vote-btn downvote <?php if(getUserVote($story->id) == -1) echo 'voted'; ?>">▼</button>
                        </form>
                    <?php endif; ?>
                </div>
                <div class="story-content">
                    <a class="noeffecthref" href="posts/display.php?id=<?php echo $story->id ?>">
                        <div class="post-header">
                            <h2> <?php echo $story->title ?> </h2>
                        </div>
                        <?php echo substr($story->body, 0, 100) ?>
                    </a>
                </div>
            </article>
        <?php endforeach ?> 
    </main>
</body>

</html>
