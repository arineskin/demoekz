<?php
session_start();
require 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $pass = $_POST['password'];
    $fullname = trim($_POST['fullname']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    if (!preg_match('/^[a-zA-Z0-9]{6,}$/', $login)) {
        $error = 'Логин должен содержать латиницу и цифры, не менее 6 символов';
    } elseif (strlen($pass) < 8) {
        $error = 'Пароль должен быть не менее 8 символов';
    } elseif (!preg_match('/^[а-яА-ЯёЁ\s]+$/u', $fullname)) {
        $error = 'ФИО должно содержать только кириллицу и пробелы';
    } elseif (!preg_match('/^8\(\d{3}\)\d{3}-\d{2}-\d{2}$/', $phone)) {
        $error = 'Телефон должен быть в формате 8(XXX)XXX-XX-XX';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Неверный формат email';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
        $stmt->execute([$login]);
        if ($stmt->fetch()) {
            $error = 'Логин уже занят';
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (login, password, fullname, phone, email, 
            role) VALUES (?, ?, ?, ?, ?, 'user')");
            $stmt->execute([$login, $hash, $fullname, $phone, $email]);
            $success = "Регистрация успешна! <a href='login.php'>Войти</a>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Корочки.есть</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="logo.png" class="logo" alt="Логотип">
        <h1>Корочки.есть</h1>
    </header>

    <main>
        <div class="form">
            <?php if ($error): ?>
                <div><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div><?= $success ?></div>
            <?php endif; ?>
            <form method="post">
                <input type="text" name="login" placeholder="Логин" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <input type="text" name="fullname" placeholder="ФИО" required>
                <input type="tel" name="phone" placeholder="Телефон 8(XXX)XXX-XX-XX" required>
                <input type="email" name="email" placeholder="Почта" required>
                <button type="submit" class="bt">Зарегистрироваться</button>
            </form>
            <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
        </div>
    </main>

    <footer>
        <img src="logo.png" class="logo" alt="Логотип">
        <h1>Корочки.есть</h1>
    </footer>
</body>
</html>