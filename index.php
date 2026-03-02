<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$dataDir = __DIR__ . '/data';
$dataFile = $dataDir . '/tasks_' . preg_replace('/[^a-z0-9_]/i', '', $_SESSION['user_id']) . '.json';

if (!is_dir($dataDir)) {
    mkdir($dataDir, 0755, true);
}

if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode([]));
}

function load_tasks($file)
{
    $json = @file_get_contents($file);
    $tasks = json_decode($json, true);
    if (!is_array($tasks)) $tasks = [];
    return $tasks;
}

function save_tasks($file, $tasks)
{
    $fp = fopen($file, 'c');
    if (!$fp) return false;
    flock($fp, LOCK_EX);
    ftruncate($fp, 0);
    fwrite($fp, json_encode(array_values($tasks), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    return true;
}

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

$tasks = load_tasks($dataFile);
$method = $_SERVER['REQUEST_METHOD'];
$action = ($method === 'POST') ? ($_POST['action'] ?? '') : ($_GET['action'] ?? '');

if ($method === 'POST' && $action === 'add') {
    $text = trim((string)($_POST['text'] ?? ''));

    if ($text === '' || strlen($text) < 3 || strlen($text) > 50) {
        if ($isAjax) { echo json_encode($tasks); exit; }
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    $task = [
        'id' => uniqid('', true),
        'text' => $text,
        'completed' => false,
        'created_at' => time(),
    ];

    array_unshift($tasks, $task);
    save_tasks($dataFile, $tasks);

    if ($isAjax) { header('Content-Type: application/json'); echo json_encode($tasks); exit; }
    header('Location: ' . $_SERVER['PHP_SELF']); 
    exit;
}

if ($action === 'toggle' && ($id = $_POST['id'] ?? $_GET['id'] ?? '')) {
    foreach ($tasks as &$t) {
        if ($t['id'] === $id) {
            $t['completed'] = !$t['completed'];
            break;
        }
    }
    save_tasks($dataFile, $tasks);

    if ($isAjax) { header('Content-Type: application/json'); echo json_encode($tasks); exit; }
    header('Location: ' . $_SERVER['PHP_SELF']); 
    exit;
}

if ($action === 'delete' && ($id = $_POST['id'] ?? $_GET['id'] ?? '')) {
    $tasks = array_values(array_filter($tasks, function ($t) use ($id) {
        return $t['id'] !== $id;
    }));

    save_tasks($dataFile, $tasks);

    if ($isAjax) { header('Content-Type: application/json'); echo json_encode($tasks); exit; }
    header('Location: ' . $_SERVER['PHP_SELF']); 
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>TodoList PowerPuff - My Tasks</title>
<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>

<main class="container">
    <h1>My Tasks</h1>

    <form id="addForm" method="post">
        <input type="hidden" name="action" value="add">

        <nav class="filters">
            <button class="filter-btn active" data-filter="all">Semua</button>
            <button class="filter-btn" data-filter="pending">Belum</button>
            <button class="filter-btn" data-filter="done">Selesai</button>
        </nav>

        <div class="row">
            <input name="text" placeholder="Tambah tugas baru..." required>
            <button type="submit">Tambah</button>
        </div>
    </form>

    <section id="tasks"></section>

    <footer class="help">
        © 2026 TodoList PowerPuff
    </footer>
</main>

<script src="app.js"></script>
</body>
</html>