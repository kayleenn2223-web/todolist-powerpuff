<?php
$dataDir = __DIR__ . '/data';
$dataFile = $dataDir . '/tasks.json';

// Buat folder data kalau belum ada
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0755, true);
}

// Buat file JSON kalau belum ada
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode([]));
}

// Fungsi ambil data
function load_tasks($file)
{
    $json = @file_get_contents($file);
    $tasks = json_decode($json, true);
    if (!is_array($tasks)) $tasks = [];
    return $tasks;
}

// Fungsi simpan data dengan pengaman (lock)
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

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
$tasks = load_tasks($dataFile);

$method = $_SERVER['REQUEST_METHOD'];
$action = ($method === 'POST') ? ($_POST['action'] ?? '') : ($_GET['action'] ?? '');

// LOGIKA PROSES (Add, Toggle, Delete)
if ($method === 'POST' && $action === 'add') {
    $text = trim((string)($_POST['text'] ?? ''));
    if ($text !== '') {
        $task = [
            'id' => uniqid('', true),
            'text' => $text, // Simpan asli, htmlspecialchars saat render
            'completed' => false,
            'created_at' => time(),
        ];
        array_unshift($tasks, $task);
        save_tasks($dataFile, $tasks);
    }
    if ($isAjax) { header('Content-Type: application/json'); echo json_encode($tasks); exit; }
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
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
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

if ($action === 'delete' && ($id = $_POST['id'] ?? $_GET['id'] ?? '')) {
    $tasks = array_values(array_filter($tasks, function ($t) use ($id) { return $t['id'] !== $id; }));
    save_tasks($dataFile, $tasks);
    if ($isAjax) { header('Content-Type: application/json'); echo json_encode($tasks); exit; }
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

// FUNGSI RENDER HTML
function render_tasks_html($tasks)
{
    ob_start();
    if (empty($tasks)) : ?>
        <li class="empty">Belum ada tugas. Semangat ya, Baby Zey!</li>
    <?php else: foreach ($tasks as $t): ?>
        <li data-id="<?= $t['id'] ?>" 
            class="task <?= $t['completed'] ? 'done' : '' ?>" 
            data-status="<?= $t['completed'] ? 'done' : 'pending' ?>">
            
            <form class="inline action-toggle" method="post" action="">
                <input type="hidden" name="action" value="toggle">
                <input type="hidden" name="id" value="<?= $t['id'] ?>">
                <button type="submit" class="check"><?= $t['completed'] ? '↺' : '✓' ?></button>
            </form>

            <div class="task-content" style="flex:1; margin-left:10px;">
                <span class="text"><?= htmlspecialchars($t['text'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></span>
                <small style="display:block; font-size:10px; color:#94a3b8">
                    Dibuat: <?= date('H:i', $t['created_at']) ?>
                </small>
            </div>

            <form class="inline action-delete" method="post" action="">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $t['id'] ?>">
                <button type="submit" class="delete">✕</button>
            </form>
        </li>
    <?php endforeach; endif;
    return ob_get_clean();
}

$tasksHtml = render_tasks_html($tasks);
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>To-Do List Baby Zey</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<main class="container">
    <h1>To‑Do List</h1>

    <form id="addForm" method="post" action="">
        <input type="hidden" name="action" value="add">
        <div class="row">
            <input id="text" name="text" placeholder="Tambah tugas baru..." autocomplete="off" required>
            <button type="submit">Tambah</button>
        </div>
    </form>

    <nav class="filters">
        <button class="filter-btn active" data-filter="all">Semua</button>
        <button class="filter-btn" data-filter="pending">Belum</button>
        <button class="filter-btn" data-filter="done">Selesai</button>
    </nav>

    <section id="tasks">
        <ul class="tasks">
            <?= $tasksHtml ?>
        </ul>
    </section>

    <footer class="help">Buka di XAMPP: http://localhost/to-do-list/</footer>
</main>

<script src="app.js"></script>
</body>
</html>