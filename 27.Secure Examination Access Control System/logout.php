<?php
session_start();

session_destroy();

setcookie("student", "", time() - 3600);

header("Location: index.php");
exit();
?>