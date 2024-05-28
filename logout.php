<?php
session_start();
if (!isset($_SESSION['email']) && !isset($_COOKIE['email'])) {
    header("Location: $base_url/index.php");
    exit();
}


unset($_SESSION['email']);
setcookie('email', '', time() - 3600, "/");

header("Location: $base_url/index.php");
exit();
?>
