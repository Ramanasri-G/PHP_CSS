<?php
session_start();

// If already logged in, go to dashboard
if (isset($_SESSION["username"])) {
    header("Location: dashboard.php");
    exit();
}

// If remember cookie exists, create a session
if (isset($_COOKIE["remember_user"])) {
    $_SESSION["username"] = $_COOKIE["remember_user"];
    $_SESSION["login_time"] = date("d-m-Y h:i A");

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Secure Login Management</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-box">

    <div class="login-header">

        <div class="lock">🔐</div>

        <h1>Secure Login</h1>

        <p>Session & Cookie Management System</p>

    </div>


    <div class="login-form">

        <h2>Welcome Back!</h2>

        <p class="description">
            Login to access your secure dashboard
        </p>

        <form action="login.php" method="POST">

            <label for="username">Username</label>

            <input
                type="text"
                id="username"
                name="username"
                placeholder="Enter username"
                required
            >


            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter password"
                required
            >


            <div class="remember">

                <input
                    type="checkbox"
                    id="remember"
                    name="remember"
                    value="yes"
                >

                <label for="remember">
                    Remember me
                </label>

            </div>


            <button type="submit">
                Login Securely
            </button>

        </form>


        <div class="demo-box">

            <strong>Demo Login</strong>

            <p>Username: <b>admin</b></p>

            <p>Password: <b>admin123</b></p>

        </div>

    </div>

</div>

</body>
</html>
