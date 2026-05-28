<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $stmt = $pdo->prepare("UPDATE applications SET status = ? WHERE id = ?");
    $stmt->execute([$_POST['status'], $_POST['app_id']]);
}

$stmt = $pdo->query("SELECT a.*, u.login, u.fullname 
FROM applications a 
JOIN users u ON a.user_id = u.id");
$applications = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ панель - Корочки.есть</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="logo.png" class="logo" alt="Логотип">
        <h1>Корочки.есть - Админ панель</h1>
    </header>
    <main>
        <div class="cards">
            <?php foreach ($applications as $app): ?>
                <div class="card">
                    <p><strong>Заявка№</strong><?= $app['id'] ?></p>
                    <p><strong>Пользователь:</strong> <?= $app['fullname'] ?></p>
                    <p><strong>Курс:</strong> <?= $app['course_name'] ?></p>
                    <p><strong>Дата:</strong> <?= $app['start_date'] ?></p>
                    <p><strong>Статус:</strong> <?= $app['status'] ?></p>
                    <form method="post">
                        <input type="hidden" name="app_id" value="<?= $app['id'] ?>">
                        <select name="status">
                            <option value="Новая" <?= $app['status'] == 'Новая' ? 'selected' : '' ?>>Новая</option>
                            <option value="Идет обучение" <?= $app['status'] == 'Идет обучение' ? 'selected' : '' ?>>Идет обучение</option>
                            <option value="Обучение завершено" <?= $app['status'] == 'Обучение завершено' ? 'selected' : '' ?>>Обучение завершено</option>
                        </select>
                        <button type="submit">Изменить статус</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <img src="logo.png" class="logo" alt="Логотип">
        <h1>Корочки.есть</h1>
    </footer>
</body>
</html>