<?php
session_start();

// Check if user is logged in
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
    <title>TodoList PowerPuff - My Tasks</title>
    <link rel="stylesheet" href="style.css">
    <style>
        :root {
            --primary: #667eea;
            --primary-dark: #764ba2;
            --text-dark: #2c3e50;
            --border-light: #ecf0f1;
            --bg-light: #f8f9fa;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', 'Segoe UI', 'Roboto', sans-serif;
        }

        .navbar {
            background: white;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            padding: 16px 20px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-content {
            max-width: 720px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            margin: 0;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .user-name {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 13px;
            margin: 0;
        }

        .user-email {
            font-size: 12px;
            color: #95a5a6;
            margin: 0;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 16px;
        }

        .btn-logout {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-logout:hover {
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        main.container {
            max-width: 720px;
            margin: 28px auto;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        h1 {
            color: var(--text-dark);
            margin: 0 0 8px;
            font-weight: 700;
            font-size: 24px;
        }

        .greeting {
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 24px;
        }

        form#addForm {
            margin-bottom: 24px;
        }

        form#addForm .row {
            display: flex;
            gap: 8px;
        }

        form#addForm input {
            flex: 1;
            padding: 12px 14px;
            border: 2px solid var(--border-light);
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: var(--bg-light);
        }

        form#addForm input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        form#addForm button {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        form#addForm button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        form#addForm button:active {
            transform: translateY(0);
        }

        #tasks {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .task {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px;
            border-radius: 8px;
            background: var(--bg-light);
            margin-bottom: 10px;
            border: 1px solid var(--border-light);
            transition: all 0.3s ease;
            animation: slideInLeft 0.3s ease-out;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .task:hover {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
        }

        .task.done .text {
            text-decoration: line-through;
            color: #bdc3c7;
        }

        .task .text {
            flex: 1;
            color: var(--text-dark);
            word-break: break-word;
        }

        .check, .delete {
            background: transparent;
            border: none;
            font-size: 16px;
            cursor: pointer;
            padding: 6px;
            color: #7f8c8d;
            transition: all 0.3s ease;
            border-radius: 4px;
        }

        .check:hover {
            color: #27ae60;
            background: rgba(39, 174, 96, 0.1);
        }

        .delete:hover {
            color: #e74c3c;
            background: rgba(231, 76, 60, 0.1);
        }

        .empty {
            color: #bdc3c7;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }

        .help {
            color: #95a5a6;
            font-size: 12px;
            margin-top: 20px;
            text-align: center;
        }

        @media (max-width: 480px) {
            main.container {
                margin: 12px;
                padding: 16px;
                border-radius: 8px;
            }

            form#addForm .row {
                flex-direction: column;
            }

            .navbar-user {
                flex-direction: column;
                gap: 8px;
            }

            .navbar-content {
                flex-direction: column;
                gap: 12px;
            }

            h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="navbar-content">
        <h2 class="navbar-brand">📝 TodoList PowerPuff</h2>
        <div class="navbar-user">
            <div class="user-info">
                <p class="user-name"><?= htmlspecialchars($_SESSION['user_name']) ?></p>
                <p class="user-email"><?= htmlspecialchars($_SESSION['user_email']) ?></p>
            </div>
            <div class="user-avatar"><?= strtoupper(substr($_SESSION['user_name'], 0, 1)) ?></div>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </div>
</nav>

<main class="container">
    <h1>My Tasks</h1>
    <p class="greeting">Halo, <?= htmlspecialchars(explode(' ', $_SESSION['user_name'])[0]) ?>! Kelola tugas-tugasmu di bawah ini.</p>

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

    <footer class="help">© 2026 TodoList PowerPuff - Manage your tasks efficiently</footer>
</main>
<script src="app.js"></script>
</body>
</html>
