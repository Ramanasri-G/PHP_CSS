<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="dashboard">

    <h1>Welcome, <?php echo $_SESSION['user']; ?>!</h1>

    <p>You have successfully logged in.</p>

    <div class="card">
        <h2>Dashboard</h2>
        <p>Authentication Successful</p>
    </div>

    <a href="index.php">Logout</a>

</div>

</body>
</html>