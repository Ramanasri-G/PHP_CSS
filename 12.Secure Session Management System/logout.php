<?php

session_start();

// Remove all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Delete remember-me cookie
setcookie(
    "remember_user",
    "",
    time() - 3600,
    "/"
);

// Return to login page
header("Location: index.php");
exit();

?>
