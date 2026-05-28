<?php
session_start();
require 'config.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE applications SET review = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$_POST['review'], $_POST['app_id'], $user_id]);
}

$stmt = $pdo->prepare("SELECT * FROM applications WHERE user_id = ?");
$stmt->execute([$user_id]);
$applications = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заявки - Корочки.есть</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="logo.png" class="logo" alt="Логотип">
        <h1>Корочки.есть</h1>
    </header>

    <main>
        <?php foreach ($applications as $app): ?>
            <div class="card">
                <p><strong>Курс:</strong> <?= $app['course_name'] ?></p>
                <p><strong>Дата:</strong> <?= $app['start_date'] ?></p>
                <p><strong>Статус:</strong> <?= $app['status'] ?></p>

                <?php if ($app['status'] == 'Обучение завершено' && !$app['review']): ?>
                    <form method="post">
                        <input type="hidden" name="app_id" value="<?= $app['id'] ?>">
                        <textarea name="review" placeholder="Оставьте отзыв"></textarea>
                        <button type="submit">Отправить</button>
                    </form>
                <?php elseif ($app['review']): ?>
                    <p><strong>Отзыв:</strong> <?= $app['review'] ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </main>

    <footer>
        <img src="logo.png" class="logo" alt="Логотип">
        <h1>Корочки.есть</h1>
    </footer>
</body>
</html>