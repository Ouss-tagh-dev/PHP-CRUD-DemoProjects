<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
session_destroy();
if (isset($_COOKIE['_ua_'])) {
    setcookie('_ua_', '', time() - 3600, '');  // Supprime le cookie
}
header("Location: index.php");
exit();
