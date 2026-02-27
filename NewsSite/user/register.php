<!-- This is the login page to Register as a user-->
<?php
session_start();

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Site -- Register</title>
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
    
    if (isset($_SESSION['username'])) {
        header('Location: ../newsSite.php');
        exit();
    }
    ?>
    <main>
        <form class="loginForm" action="auth/register.php" method="POST" autocomplete="on">
            <h2>Register</h2>

            <label for="Email">Email:</label>
            <input type="email" id="Email" name="email" required />

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required />

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required />

            <br />
            <button class="button" type="submit">Register</button>

            <p>
                Already have an account?
                <a href="login.php">Login</a>
            </p>
            <?php
            // Display error message if registration failed
            if (isset($_SESSION['failed_registration']) && $_SESSION['failed_registration'] === true) {
                echo "<p class='error'>Registration failed. Please try again.</p>";
                unset($_SESSION['failed_registration']); // Clear the error message after displaying
            }
            // Display error message if user already exists
            if (isset($_SESSION['user_exists']) && $_SESSION['user_exists'] === true) {
                echo "<p class='error'>User already exists. Please choose a different username or email, or login below.</p>";
                unset($_SESSION['user_exists']); // Clear the error message after displaying
            }
            ?>

        </form>
    </main>

</body>

</html>
