<!-- Handles login POST request -->
<?php
session_start();
require '../../mysql/database.php'; // Include the database connection



// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = (string) $_POST['username'];
    $password_att = (string) $_POST['password'];

    $stmt = $mysqli->prepare("SELECT COUNT(*), user_id, password_hash FROM users WHERE username=?");
    $stmt->bind_param('s', $username);
    $stmt->execute();

    // Bind the results
    $stmt->bind_result($cnt, $user_id, $pwd_hash);
    $stmt->fetch();

    // Compare the submitted password to the actual password hash
    if ($cnt == 1 && password_verify($password_att, $pwd_hash)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['token'] = bin2hex(random_bytes(32)); // generate token to prevent CSRF
        header('Location: ../../newsSite.php');
        exit();
    } else {
        // Login failed; redirect back to the login screen
        $_SESSION['login_failed'] = true;
        header('Location: ../login.php');
        exit();
    }
}
?>
