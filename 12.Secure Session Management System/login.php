<?php

session_start();

// Demo login credentials
$correctUsername = "admin";
$correctPassword = "admin123";

// Get form values
$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";

// Check username and password
if ($username === $correctUsername && $password === $correctPassword) {

    // Create a new session ID for security
    session_regenerate_id(true);

    // Store username in session
    $_SESSION["username"] = $username;

    // Store login time
    $_SESSION["login_time"] = date("d-m-Y h:i A");


    // If Remember Me is selected
    if (isset($_POST["remember"])) {

        setcookie(
            "remember_user",
            $username,
            time() + (7 * 24 * 60 * 60),
            "/",
            "",
            false,
            true
        );
    }

    // Go to dashboard
    header("Location: dashboard.php");
    exit();

} else {

    // Invalid login
    header("Location: index.php?error=1");
    exit();
}

?>
