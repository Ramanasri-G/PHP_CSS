<?php
session_start();

// Prevent unauthorized access
if (!isset($_SESSION['student'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Examination System</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="exam-box">

    <div class="icon">✓</div>

    <h1>Welcome to Examination</h1>

    <p>
        Student:
        <strong><?php echo $_SESSION['student']; ?></strong>
    </p>

    <div class="secure">
        🔒 Authorized Access
    </div>

    <h2>Online Examination</h2>

    <p>Your examination session is ready.</p>

    <a href="logout.php">Logout</a>

</div>

</body>
</html>