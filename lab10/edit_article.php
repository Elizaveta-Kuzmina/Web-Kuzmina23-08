<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$articleId = $_GET['id'] ?? null;

if (!$articleId) {
    header("Location: personal_articles.php?error=Некорректный запрос.");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = :id AND author_id = :author_id");
$stmt->execute([
    'id' => $articleId,
    'author_id' => $_SESSION['user_id']
]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    header("Location: personal_articles.php?error=Статья не найдена или доступ запрещен.");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $updateStmt = $pdo->prepare("UPDATE articles SET title = :title, content = :content WHERE id = :id AND author_id = :author_id");
        $updateStmt->execute([
            'title' => $title,
            'content' => $content,
            'id' => $articleId,
            'author_id' => $_SESSION['user_id']
        ]);

        header("Location: personal_articles.php?success=Статья успешно обновлена.");
        exit;
    } else {
        $error = "Пожалуйста, заполните все поля.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Редактировать статью</title>
</head>
<body>
<header><h1>Редактировать статью</h1></header>
<div class="container">
<?php if (!empty($error)): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="title" value="<?= htmlspecialchars($article['title']) ?>" required>
    <textarea name="content" required><?= htmlspecialchars($article['content']) ?></textarea><br>
    <button type="submit">Сохранить изменения</button>
</form>

<p><a href="personal_articles.php">К своим статьям</a></p></div>
</body>
</html>
