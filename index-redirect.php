<?php
/**
 * TodoList PowerPuff - Welcome Page
 * Redirect users to appropriate page based on session
 */
session_start();

if (isset($_SESSION['user_id'])) {
    // Redirect logged-in users to dashboard
    header('Location: index.php');
    exit();
} else {
    // Redirect new users to login
    header('Location: login.php');
    exit();
}
?>
