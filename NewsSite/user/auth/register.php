<!-- Handles register POST request -->
<?php
session_start();
require '../../mysql/database.php'; // Include the database connection

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = (string) $_POST['email'];
    $username = (string) $_POST['username'];
    $password = (string) $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    try {
        $stmt = $mysqli->prepare("INSERT INTO users (email, username, password_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $username, $hashed_password);
        if ($stmt->execute()) {
            $stmt = $mysqli->prepare('SELECT user_id FROM users WHERE username = ?');
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->bind_result($user_id);
            $stmt->fetch();
            $_SESSION['user_id'] = $user_id; // Store user_id in session for future use    
            $_SESSION['token'] = bin2hex(random_bytes(32)); // generate token to prevent CSRF
            header('Location: ../../newsSite.php'); // Redirect to news site after successful registration
            exit();
        } else {
            $_SESSION['failed_registration'] = true; // Set a session variable to indicate registration failure
            header('Location: ../register.php'); // Redirect back to registration page on failure";
        }
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        // Handle duplicate entry error (e.g., username or email already exists)
        if ($e->getCode() === 1062) { // 1062 is the error code for duplicate entry
            $_SESSION['user_exists'] = true;
            header('Location: ../register.php');
        } else {
            throw $e;
        }
    }

}


?>
