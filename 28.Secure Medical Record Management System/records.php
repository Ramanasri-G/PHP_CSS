<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$folder = "medical_records/";

if (!is_dir($folder)) {
    mkdir($folder);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Medical Records</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="records-box">

    <div class="top">
        <h1>Medical Records</h1>
        <a href="logout.php">Logout</a>
    </div>

    <p class="secure">🔒 Authorized Access Only</p>

    <h3>Available Reports</h3>

    <?php
    $files = scandir($folder);

    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            echo "<div class='file'>";
            echo "📄 $file";
            echo "<a href='download.php?file=" .
                 urlencode($file) . "'>View</a>";
            echo "</div>";
        }
    }
    ?>

</div>

</body>
</html>