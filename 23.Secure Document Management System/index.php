<?php
session_start();

$folder = "secure_docs/";
$message = "";

// Create secure folder
if (!is_dir($folder)) {
    mkdir($folder);
}

// Upload document
if (isset($_POST['upload'])) {

    $file = $_FILES['document'];
    $name = basename($file['name']);
    $path = $folder . $name;

    $allowed = ["pdf", "doc", "docx"];
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        $message = "Only PDF, DOC and DOCX files are allowed.";
    }
    elseif (file_exists($path)) {
        $message = "Duplicate file! This document already exists.";
    }
    elseif ($file['error'] != 0) {
        $message = "Invalid file upload.";
    }
    else {
        move_uploaded_file($file['tmp_name'], $path);
        $message = "Document uploaded securely.";
    }
}

// Login
if (isset($_POST['login'])) {
    $_SESSION['user'] = "admin";
    $message = "Access granted.";
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Secure Document Management</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="header">
    <h1>SECURE DOCS</h1>
    <p>Professional Document Management System</p>
</div>

<div class="container">

<?php if (!isset($_SESSION['user'])) { ?>

    <h2>Restricted Access</h2>
    <p>Login to manage secure documents.</p>

    <form method="post">
        <button name="login">Login as Admin</button>
    </form>

<?php } else { ?>

    <div class="top">
        <h2>Document Manager</h2>
        <a href="?logout">Logout</a>
    </div>

    <form method="post" enctype="multipart/form-data">

        <label>Choose Document</label>
        <input type="file" name="document" required>

        <button name="upload">Upload Securely</button>

    </form>

    <p class="message"><?php echo $message; ?></p>

    <h3>Stored Documents</h3>

    <?php
    $files = scandir($folder);

    foreach ($files as $file) {
        if ($file != "." && $file != "..") {

            echo "<div class='file'>";
            echo "🔒 <span>$file</span>";
            echo "<a href='download.php?file=" .
                 urlencode($file) . "'>Access</a>";
            echo "</div>";
        }
    }
    ?>

<?php } ?>

</div>

</body>
</html>