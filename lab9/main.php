<?php
include 'db.php';
session_start();

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = $isLoggedIn && $_SESSION['role'] === 'admin';

$stmt = $pdo->query("SELECT title, content, created_at FROM articles ORDER BY created_at DESC");
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
   <link rel="stylesheet" href="style.css">
    <title>Спортивный сайт</title>
<style>
p{text-indent:15px}
h2 {text-indent:15px}
small{text-indent:15px}
</style>
</head>
<body>

  <header>  <h1>Добро пожаловать :)</h1></header>
<p style="text-indent: 50px;">
  <?php if ($isLoggedIn): ?>
    <p align=left>Вы вошли как: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></p>
 <p align=left><a href="profile_edit.php">Посмотреть данные</a></p>
    <p align=left><a href="profile.php">Изменить данные</a></p>

    <?php if ($isAdmin): ?>
        <p><a href="admin.php">Админ-панель</a></p>
    <?php endif; ?>
    <p><a href="logout.php">Выход</a></p>
<?php else: ?>
    <p><a href="login.php">Войти</a> | <a href="register.php">Регистрация</a></p>
<?php endif; ?>

    <hr>
    <?php foreach ($articles as $article): ?>
        <div class="article">
            <h2><?= htmlspecialchars($article['title']) ?></h2>
            <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
            <p style="font-size:12px;">Опубликовано: <?= $article['created_at'] ?></p>
        </div>
        <hr>
    <?php endforeach; ?>
 <footer>
        &copy; 2024 Спортивный сайт. 
    </footer>
</body>
</html>
