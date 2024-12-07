<?php
session_start();
include 'db.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];


$stmt = $pdo->prepare("SELECT username, email, role, created_at FROM users WHERE id = :id");
$stmt->execute(['id' => $userId]);
$user = $stmt->fetch();

if (!$user) {
    echo "Ошибка: данные пользователя не найдены.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Просмотр профиля</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Просмотр профиля</h1>
    </header>
    <div class="container">
        <h2>Ваши данные</h2>
        <p><strong>Имя пользователя:</strong> <?= htmlspecialchars($user['username']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
        <p><strong>Роль:</strong> <?= $user['role'] === 'admin' ? 'Администратор' : 'Пользователь'; ?></p>
        <p><strong>Дата регистрации:</strong> <?= htmlspecialchars($user['created_at']); ?></p>

        <a class="edit-link" href="profile_edit.php">Редактировать профиль</a>
        <p><a href="main.php">Назад</a></p>
    </div>
    <footer>
        &copy; 2024 Спортивный сайт. 
    </footer>
</body>
</html>
