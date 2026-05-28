<?php
session_start();
require 'config.php';

$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course = $_POST['course'];
    $date = $_POST['date'];
    $payment = $_POST['payment'];
    
    $stmt = $pdo->prepare("INSERT INTO applications (user_id, course_name, start_date, payment_method) 
    VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $course, $date, $payment]);
    $success = 'Заявка создана';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новая заявка - Корочки.есть</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="logo.png" class="logo">
        <h1>Корочки.есть</h1>
    </header>
    <main>
        <div class="form">
            <?php if ($success): ?>
                <div><?= $success ?> <a href="dashboard.php">Мои заявки</a></div>
            <?php endif; ?>
            <form method="post">
                <select name="course" required>
                    <option value="">Выберите курс</option>
                    <option>Основы алгоритмизации и программирования</option>
                    <option>Основы веб-дизайна</option>
                    <option>Основы проектирования баз данных</option>
                </select>
                <input type="date" name="date" required>
                <label><input type="radio" name="payment" value="cash" required> Наличными</label>
                <label><input type="radio" name="payment" value="transfer"> Перевод по номеру телефона</label>
                <button type="submit">Отправить заявку</button>
            </form>
            <a href="dashboard.php">Назад</a>
        </div>
    </main>
    <footer>
        <img src="logo.png" class="logo" alt="Логотип">
        <h1>Корочки.есть</h1>
    </footer>
</body>
</html>