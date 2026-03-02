<?php
session_start();

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Redirect ke login
header('Location: login.php');
exit();
?>
