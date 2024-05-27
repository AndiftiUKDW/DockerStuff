<?php
session_start();
$base_url = ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? 'http') . '://' . ($_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST']);
if (!isset($_SESSION['email']) && !isset($_COOKIE['email'])) {
    header("Location: $base_url/index.php");
    exit();
}


unset($_SESSION['email']);
setcookie('email', '', time() - 3600, "/");

header("Location: $base_url/index.php");
exit();
?>
