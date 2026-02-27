<?php
// edit the current user's post from id

session_start();

require_once './actions/story/loadStory.php';

$isLoggedIn = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : false;
if(!$isLoggedIn){
    header('Location: ../user/login.php');
    exit();
}
$userId = $_SESSION["user_id"];

if (!isset($_GET["id"])){
    echo "couldn't get the id";
    exit();
}

$id = $_GET["id"];

$story = loadStory($id);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
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
        <form class="createPostForm" action="actions/story/edit.php" method="POST">
            <h2>Edit Post</h2>

            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $story->title; ?>" required />

            <label for="body">Body:</label>
            <textarea id="body" name="body" rows="8" required><?php echo $story->body; ?></textarea>

            <label for="link">Link (optional):</label>
            <input type="url" id="link" name="link" <?php echo $story->link==null ?"" :"value='".$story->link."'" ?> />
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
            <input type="hidden" name="post_id" value="<?php echo $id;?>" />

            <button class="button" type="submit">Save Post</button>
        </form>
    </main>
</body>

</html>
