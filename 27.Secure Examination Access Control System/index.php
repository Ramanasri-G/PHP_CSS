<?php
session_start();

$error = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == "student" && $password == "1234") {

        $_SESSION['student'] = $username;

        // Cookie for user management
        setcookie("student", $username, time() + 3600);

        // Header for access control
        header("Location: exam.php");
        exit();

    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Examination Access Control</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-box">

    <div class="icon">◆</div>

    <h1>EXAM PORTAL</h1>
    <p class="subtitle">Secure Examination Access</p>

    <form method="post">

        <label>Student Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">
            Secure Login
        </button>

    </form>

    <?php if ($error != "") { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>

</div>

</body>
</html>