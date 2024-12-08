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


</head>
<body>
<div class="wrapper">
  <header>  <h1>Добро пожаловать! </h1><h3> Платформа для просмотра и создания спортивного контента</h3> </header>


<?php if ($isLoggedIn): ?>
<div style="text-align: right;margin-right: 70px;">
    <p>Вы вошли как: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></p>
    
    
        <form method="GET" action="profile.php" style="display:inline;">
            <button type="submit" style="background-color: #770000; color: #f6f6f6; padding: 15px; border-radius: 0px; cursor: pointer;margin-right: 10px;border-radius: 5px;">
                Профиль
            </button>
        </form>
        
        <p>
            <a href="personal_articles.php">Мои статьи</a>
            <?php if ($isAdmin): ?>
                | <a href="admin.php">Админ-панель</a>
            <?php endif; ?>
        </p>
   
    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif; ?>
</div>
<?php else: ?>
  <div style="text-align: right;margin-right: 70px;">
  <p> <a href="login.php">Войти</a> | <a href="register.php">Регистрация</a></p>
<?php endif; ?>   </div>
  <hr>

  <?php foreach ($articles as $article): ?>
    <div class="article">
        <h2><?= htmlspecialchars($article['title']) ?></h2>
        <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
        <p style="font-size: 12px;">Опубликовано: <?= $article['created_at'] ?></p>
    </div>
    <hr>
 
<?php endforeach; ?>
<p style="text-indent: 70px"><a href="https://www.sports.ru/betting/ratings/">Рейтинг официальных букмекеров</a></p>

 <footer>
        &copy; 2024 Спортивный сайт. 
    </footer></div>
</body>
</html>
