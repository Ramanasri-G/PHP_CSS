<?php
session_start();

if (!isset($_SESSION['user'])) {
    die("Unauthorized access!");
}

$file = basename($_GET['file']);
$path = "medical_records/" . $file;

if (file_exists($path)) {

    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$file\"");

    readfile($path);
    exit();

} else {
    echo "Medical record not found.";
}
?>