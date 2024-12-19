<?php
include 'db.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


$stmt = $pdo->prepare("SELECT id, title, content, created_at, image FROM articles WHERE author_id = :author_id ORDER BY created_at DESC");
$stmt->execute(['author_id' => $_SESSION['user_id']]);
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Мои статьи</title>
</head>
<body>
<header><h1>Мои статьи</h1></header>
<div class="container">
<?php if (count($articles) > 0): ?>
    <?php foreach ($articles as $article): ?>
    <div class="article">
        <h2><?= htmlspecialchars($article['title']) ?></h2>
         <?php if (!empty($article['image'])): ?>
        <img src="<?= htmlspecialchars($article['image']) ?>" alt="Изображение статьи" style="width: 300px; height: 200px; margin-bottom: 15px; float: right; margin: 15px;">

        <?php endif; ?>
        <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
        <p style="font-size: 0.8rem; color: #888;">Опубликовано: <?= $article['created_at'] ?></p>
<hr>

  <form method="GET" action="edit_article.php" style="display:inline;">
            <input type="hidden" name="id" value="<?= $article['id'] ?>">
            <button type="submit">
                Редактировать
            </button>
        </form>

           
            <form method="POST" action="delete_article.php" style="display:inline;">
                <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                <button type="submit" onclick="return confirm('Вы уверены, что хотите удалить эту статью?');">Удалить</button>
            </form>
        </div>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>У вас пока нет статей.</p>
<?php endif; ?>

<p><a href="create_article.php">Добавить статью</a></p>
<p><a href="main.php">На главную</a></p></div>
</body>
</html>
