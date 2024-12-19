<?php
include 'db.php'; 
session_start();


if (isset($_GET['id'])) {
    $articleId = $_GET['id'];

   
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
    $stmt->execute(['id' => $articleId]);
    $article = $stmt->fetch();

  
    if (!$article) {
        header("Location: main.php");
        exit;
    }

  
    $stmt = $pdo->prepare("
        SELECT comments.*, users.username 
        FROM comments 
        LEFT JOIN users ON comments.user_id = users.id 
        WHERE article_id = :article_id 
        ORDER BY created_at DESC
    ");
    $stmt->execute(['article_id' => $articleId]);
    $comments = $stmt->fetchAll();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $comment = trim($_POST['comment']);
    $userId = $_SESSION['user_id'];

    if (!empty($comment)) {
        $stmt = $pdo->prepare("INSERT INTO comments (article_id, user_id, comment, created_at) VALUES (:article_id, :user_id, :comment, NOW())");
        $stmt->execute([
            'article_id' => $articleId,
            'user_id' => $userId,
            'comment' => $comment
        ]);
        header("Location:main.php");
        exit;
    } else {
        $error = "Пожалуйста, напишите комментарий.";
    }
}


if (isset($_GET['delete_comment_id']) && isset($_SESSION['user_id'])) {
    $commentId = $_GET['delete_comment_id'];
    $userId = $_SESSION['user_id'];

   
    $stmt = $pdo->prepare("SELECT user_id FROM comments WHERE id = :id");
    $stmt->execute(['id' => $commentId]);
    $comment = $stmt->fetch();

    if ($comment && $comment['user_id'] == $userId) {
       
        $stmt = $pdo->prepare("DELETE FROM comments WHERE id = :id");
        $stmt->execute(['id' => $commentId]);

        header("Location: main.php");
        exit;
    } else {
        $error = "Вы не можете удалить этот комментарий.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статья: <?= htmlspecialchars($article['title']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><?= htmlspecialchars($article['title']) ?></h1>
        </header>
<div class="article">
    <h1><?= htmlspecialchars($article['title']) ?></h1>
    <?php if (!empty($article['image'])): ?>
        <img src="<?= htmlspecialchars($article['image']) ?>" alt="Изображение статьи" style="width: 300px; height: 200px; margin: 15px; float: right;">
    <?php endif; ?>
    <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
    <p style="font-size: 0.8rem; color: #888;">Опубликовано: <?= $article['created_at'] ?></p>
</div><br>
       
        <?php if (isset($_SESSION['user_id'])): ?>
            <form method="POST" action="art.php?id=<?= $articleId ?>">
                <textarea name="comment" placeholder="Ваш комментарий" required></textarea>
                <button type="submit">Добавить комментарий</button>
            </form>
        <?php else: ?>
            <p>Для добавления комментария нужно <a href="login.php">войти</a>.</p>
        <?php endif; ?>

       
        <div class="comments">
            <?php if ($comments): ?>
                <h3>Комментарии:</h3>
                <ul>
                    <?php foreach ($comments as $comment): ?>
                        <li>
                            <strong><?= htmlspecialchars($comment['username']) ?>:</strong> <?= nl2br(htmlspecialchars($comment['comment'])) ?>
                            <br>
<small>Опубликовано: <?= $comment['created_at'] ?></small>
                            <?php if ($comment['user_id'] == $_SESSION['user_id']): ?>
                                <a href="art.php?id=<?= $articleId ?>&delete_comment_id=<?= $comment['id'] ?>" onclick="return confirm('Вы уверены, что хотите удалить комментарий?')">Удалить</a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Комментариев пока нет.</p>
            <?php endif; ?>
        </div>

        <p><a href="main.php">Назад к статьям</a></p>
    </div>
</body>
</html>
