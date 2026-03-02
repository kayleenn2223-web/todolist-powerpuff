<?php
/**
 * TodoList PowerPuff - Configuration File
 * 
 * File konfigurasi utama untuk aplikasi
 */

// Application Settings
define('APP_NAME', 'TodoList PowerPuff');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost/todolist-powerpuff/');

// Data Directory
define('DATA_DIR', __DIR__ . '/data');
define('USERS_FILE', DATA_DIR . '/users.json');

// Security Settings
define('PASSWORD_MIN_LENGTH', 6);
define('PASSWORD_PEPPER', 'todolist-powerpuff-secret-key-2026');

// Session Configuration
ini_set('session.gc_maxlifetime', 86400); // 24 hours
ini_set('session.cookie_lifetime', 86400);
ini_set('session.cookie_secure', false); // Set to true in production with HTTPS
ini_set('session.cookie_httponly', true);
ini_set('session.cookie_samesite', 'Lax');

// Error Handling (development)
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/error.log');

// Timezone
date_default_timezone_set('Asia/Jakarta');

/**
 * Initialize Application
 */
function init_app() {
    // Check if data directory exists
    if (!is_dir(DATA_DIR)) {
        @mkdir(DATA_DIR, 0755, true);
    }
    
    // Check if logs directory exists
    if (!is_dir(__DIR__ . '/logs')) {
        @mkdir(__DIR__ . '/logs', 0755, true);
    }
    
    // Create users.json if it doesn't exist
    if (!file_exists(USERS_FILE)) {
        file_put_contents(USERS_FILE, json_encode([], JSON_PRETTY_PRINT));
    }
}

/**
 * Secure Hash Password
 */
function hash_password($password) {
    return password_hash($password, PASSWORD_ARGON2ID, [
        'memory_cost' => 2048,
        'time_cost' => 4,
        'threads' => 3
    ]);
}

/**
 * Verify Password
 */
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Get User Tasks File Path
 */
function get_user_tasks_file($user_id) {
    return DATA_DIR . '/tasks_' . preg_replace('/[^a-z0-9_]/i', '', $user_id) . '.json';
}

/**
 * Load JSON File Safely
 */
function load_json_file($file) {
    if (!file_exists($file)) {
        return [];
    }
    $content = file_get_contents($file);
    return json_decode($content, true) ?? [];
}

/**
 * Save JSON File Safely
 */
function save_json_file($file, $data) {
    $dir = dirname($file);
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
    return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}

/**
 * Sanitize Input
 */
function sanitize_input($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect
 */
function redirect($url, $code = 302) {
    http_response_code($code);
    header('Location: ' . $url);
    exit();
}

// Initialize application
init_app();
