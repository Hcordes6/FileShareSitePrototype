<?php
// create post page

session_start();
$isLoggedIn = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : false;
if(!$isLoggedIn){
    header('Location: ../user/login.php');
    exit();
}
$userId = $_SESSION["user_id"];
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
        <form class="createPostForm" action="actions/story/post.php" method="POST">
            <h2>Create Post</h2>

            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required />

            <label for="body">Body:</label>
            <textarea id="body" name="body" rows="8" required></textarea>

            <label for="link">Link (optional):</label>
            <input type="url" id="link" name="link" />
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />

            <button class="button" type="submit">Create Post</button>
        </form>
    </main>
</body>

</html>
