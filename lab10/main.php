<?php
include 'db.php';
session_start();

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = $isLoggedIn && $_SESSION['role'] === 'admin';

$stmt = $pdo->query("SELECT id, title, content, created_at, image FROM articles ORDER BY created_at DESC");
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


  <ul class="menu">

    <div class="menu-left">
 <?php if ($isLoggedIn): ?>
        <li><a href="profile.php">Просмотр профиля</a></li>
        <li><a href="personal_articles.php">Мои статьи</a></li>
<?php else: ?>
            <li><a href="login.php">Войти</a></li>
            <li><a href="register.php">Регистрация</a></li>
        <?php endif; ?>
 
        <?php if ($isAdmin): ?>
            <li><a href="admin.php">Админ-панель</a></li>
        <?php endif; ?>
    </div>

   
    <div class="menu-right">
        <li><a href="https://vk.com/kuzelvl"><img src="вк.png" alt="Контакты" style="width: 32px; height: 32px"></a></li>
        <?php if (isset($isLoggedIn) && $isLoggedIn): ?>
            <li><a href="logout.php">Выход</a></li></div>

      
        <?php endif; ?>
    
</ul>

  <hr><hr><hr> <br>

<?php foreach ($articles as $article): ?>
    <div class="article">
        <h2><?= htmlspecialchars($article['title']) ?></h2>
        <?php if (!empty($article['image'])): ?>
        <img src="<?= htmlspecialchars($article['image']) ?>" alt="Изображение статьи" style="width: 300px; height: 200px; margin-bottom: 15px; float: right; margin: 15px;">
    <?php endif; ?>

        <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>

        <p style="font-size: 0.8rem; color: #888;">Опубликовано: <?= $article['created_at'] ?></p>
        <a href="art.php?id=<?= $article['id']?>">Перейти к статье</a>
       <div class="comments">
                        <?php
                      
                        $stmt = $pdo->prepare("SELECT c.comment, c.created_at, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE c.article_id = :article_id ORDER BY c.created_at DESC");
                        $stmt->execute(['article_id' => $article['id']]);
                        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php if ($comments): ?>
                            <h4>Комментарии:</h4>
                            <ul>
                                <?php foreach ($comments as $comment): ?>
                                    <li>
                                        <strong><?= htmlspecialchars($comment['username']) ?>:</strong> <?= nl2br(htmlspecialchars($comment['comment'])) ?>
                                        <br>
                                        <small>Опубликовано: <?= $comment['created_at'] ?></small>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
<?php else: ?>
                            <p style='font-size: 12px;'>Комментариев пока нет.</p>
                        <?php endif; ?>
                    </div>

                </div>
                <hr>
            <?php endforeach; ?>
  
    </div>


<p style="text-indent: 70px"><a href="https://www.sports.ru/betting/ratings/">Рейтинг официальных букмекеров</a></p>

 <footer>
        &copy; 2024 Спортивный сайт. 
    </footer>
</body>
</html>
