<?php
session_start();

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple authentication
    if ($username == "admin" && $password == "1234") {

        $_SESSION['user'] = $username;

        // HTTP Header Redirection
        header("Location: dashboard.php");
        exit();

    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Secure Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-box">

    <h1>LOGIN</h1>
    <p>Secure User Authentication</p>

    <form method="post">

        <input type="text"
               name="username"
               placeholder="Username"
               required>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <button type="submit" name="login">
            Sign In
        </button>

    </form>

    <?php
    if (isset($error)) {
        echo "<div class='error'>$error</div>";
    }
    ?>

</div>

</body>
</html>