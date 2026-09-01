<?php
session_start();

$message = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == "doctor" && $password == "1234") {
        $_SESSION['user'] = $username;

        header("Location: records.php");
        exit();
    } else {
        $message = "Invalid login details!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Secure Medical Records</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-box">

    <div class="symbol">✚</div>

    <h1>MEDICAL RECORDS</h1>
    <p>Secure Healthcare Document Portal</p>

    <form method="post">

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button name="login">Secure Login</button>

    </form>

    <?php if ($message != "") { ?>
        <div class="error"><?php echo $message; ?></div>
    <?php } ?>

</div>

</body>
</html>