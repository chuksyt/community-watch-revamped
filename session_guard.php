<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Force browser to never cache protected pages
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');

const SESSION_TIMEOUT = 600; // 10 minutes in seconds

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > SESSION_TIMEOUT) {
    session_unset();
    session_destroy();
    header('Location: login.php?reason=timeout');
    exit();
}

$_SESSION['last_activity'] = time();
?>
