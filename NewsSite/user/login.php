<!-- This is the login page to login as a user-->
<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: ../newsSite.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Site -- Login</title>
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <header>
        <h1><a href="../newsSite.php">News Site</a></h1>
    </header>
    <?php
    // Page should automatically redirect if the session has saved a user login
    // case 1: User needs to log in
    // case 2: User needs to register
    ?>
    <main>

        <form class="loginForm" action="auth/login.php" method="POST" autocomplete="on">
            <h2>Login</h2>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required />

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required />

            <br />
            <button class="button" type="submit">Login</button>

            <p>
                New user?
                <a href="register.php">Register</a>
            </p>
            <?php
            if (isset($_SESSION['login_failed'])) {
                echo '<p class="error">Login failed. Please try again.</p>';
                unset($_SESSION['login_failed']);
            }
            ?>
        </form>
    </main>

</body>

</html>
