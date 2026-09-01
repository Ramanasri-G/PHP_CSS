<?php
session_start();

if (!isset($_SESSION['visits'])) {
    $_SESSION['visits'] = 0;
}

$_SESSION['visits']++;

$page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Visitor Session Tracking</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>Visitor Tracking</h1>
    <p class="subtitle">Session-Based Page Visit Monitor</p>

    <div class="card">
        <h2>Welcome!</h2>

        <p>You are currently visiting:</p>

        <strong><?php echo $page; ?></strong>

        <div class="count">
            <?php echo $_SESSION['visits']; ?>
        </div>

        <p>Pages visited in this session</p>
    </div>

    <a href="index.php">Visit Page Again</a>

</div>

</body>
</html>