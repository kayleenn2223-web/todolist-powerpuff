<?php
$dataDir = __DIR__ . '/data';
$dataFile = $dataDir . '/tasks.json';

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

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

$tasks = load_tasks($dataFile);

$method = $_SERVER['REQUEST_METHOD'];
$action = '';
if ($method === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
} elseif ($method === 'GET') {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
}

if ($method === 'POST' && $action === 'add') {
    $text = trim((string)($_POST['text'] ?? ''));
    if ($text !== '') {
        $task = [
            'id' => uniqid('', true),
            'text' => htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            'completed' => false,
            'created_at' => time(),
        ];
        array_unshift($tasks, $task);
        save_tasks($dataFile, $tasks);
    }
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode($tasks);
        exit;
    }
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
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

if ($action === 'delete' && ($id = $_POST['id'] ?? $_GET['id'] ?? '')) {
    $tasks = array_values(array_filter($tasks, function ($t) use ($id) { return $t['id'] !== $id; }));
    save_tasks($dataFile, $tasks);
    if ($isAjax) { header('Content-Type: application/json'); echo json_encode($tasks); exit; }
    header('Location: ' . $_SERVER['PHP_SELF']); exit;
}

function render_tasks_html($tasks)
{
    ob_start();
    ?>
    <ul class="tasks">
        <?php if (empty($tasks)) : ?>
            <li class="empty">Belum ada tugas. Tambah tugas di form di atas.</li>
        <?php else: foreach ($tasks as $t): ?>
            <li data-id="<?= $t['id'] ?>" class="task <?= $t['completed'] ? 'done' : '' ?>">
                <form class="inline action-toggle" method="post" action="">
                    <input type="hidden" name="action" value="toggle">
                    <input type="hidden" name="id" value="<?= $t['id'] ?>">
                    <button type="submit" class="check"><?= $t['completed'] ? '↺' : '✓' ?></button>
                </form>
                <span class="text"><?= $t['text'] ?></span>
                <form class="inline action-delete" method="post" action="">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $t['id'] ?>">
                    <button type="submit" class="delete">✕</button>
                </form>
            </li>
        <?php endforeach; endif; ?>
    </ul>
    <?php
    return ob_get_clean();
}

$tasksHtml = render_tasks_html($tasks);

if ($isAjax && $action === '') {
    header('Content-Type: application/json');
    echo json_encode($tasks);
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>To-Do List Sederhana</title>
    <link rel="stylesheet" href="style.css">
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

    <section id="tasks">
        <?= $tasksHtml ?>
    </section>

    <footer class="help">Buka di XAMPP: http://localhost/to-do-list/</footer>
</main>
<script src="app.js"></script>
</body>
</html>
