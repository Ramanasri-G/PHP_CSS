<?php

// Check whether the form was submitted
if ($_SERVER["REQUEST_METHOD"] != "POST") {

    header("Location: index.html");

    exit();
}


// Get username
$username = trim($_POST["username"] ?? "");


// Validate username
if ($username == "") {

    die("Username is required.");
}


// Get current date and time
$currentLoginTime = date("d-m-Y h:i:s A");


// Check whether previous login cookie exists
$lastLogin = $_COOKIE["last_login"] ?? "";


// Create cookie for username
setcookie(
    "username",
    $username,
    time() + (30 * 24 * 60 * 60),
    "/",
    "",
    false,
    true
);


// Store current login time in cookie
setcookie(
    "last_login",
    $currentLoginTime,
    time() + (30 * 24 * 60 * 60),
    "/",
    "",
    false,
    true
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login Information</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

<div class="result-card">

    <h1>🔐 Login Successful</h1>


    <div class="welcome">

        Welcome,
        <?php
        echo htmlspecialchars($username);
        ?>! 👋

    </div>


    <?php if ($lastLogin != ""): ?>

        <div class="login-info">

            <p>

                <strong>Username:</strong>

                <?php
                echo htmlspecialchars($username);
                ?>

            </p>


            <p>

                <strong>Last Login:</strong>

                <?php
                echo htmlspecialchars($lastLogin);
                ?>

            </p>


            <p>

                <strong>Current Login:</strong>

                <?php
                echo htmlspecialchars(
                    $currentLoginTime
                );
                ?>

            </p>

        </div>


    <?php else: ?>

        <div class="first-login">

            🎉 This is your first login!

            <br><br>

            Your login time has been saved.

        </div>

    <?php endif; ?>


    <a
        href="index.html"
        class="back-button"
    >
        Logout / Back to Login
    </a>

</div>

</div>

</body>
</html>