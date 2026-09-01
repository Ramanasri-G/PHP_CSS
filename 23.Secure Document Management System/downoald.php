<?php
session_start();

if (!isset($_SESSION['user'])) {
    die("Unauthorized access!");
}

$file = basename($_GET['file']);
$path = "secure_docs/" . $file;

if (file_exists($path)) {
    header("Content-Disposition: attachment; filename=\"$file\"");
    header("Content-Type: application/octet-stream");
    readfile($path);
    exit();
}

echo "Document not found.";
?>