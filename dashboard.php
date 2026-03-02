<?php
// Redirect ke halaman login jika session tidak ada
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Jika sudah login, redirect ke dashboard
header('Location: index.php');
exit();
?>
