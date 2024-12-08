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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        <form method="GET" action="profile_edit.php" style="display:inline;">
                       <button type="submit" style="background-color: #770000; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer;">
                Редактировать профиль
            </button>

 <p><a class="edit-link" href="logout.php">Выйти из профиля</a></P>
        <p><a href="main.php">На главную</a></p>
    </div>
    
</body>
</html>
