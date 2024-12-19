<?php
include 'db.php';
session_start();

if (!isset($_GET['id']) || !isset($_SESSION['user_id'])) {
    header("Location: main.php");
    exit;
}

$articleId = $_GET['id'];


$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = :id AND author_id = :author_id");
$stmt->execute(['id' => $articleId, 'author_id' => $_SESSION['user_id']]);
$article = $stmt->fetch();

if (!$article) {
    header("Location: main.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $newImage = $_FILES['image'];

    if (!empty($title) && !empty($content)) {
        $imagePath = $article['image'];

        
        if (!empty($newImage['name'])) {
            $uploadDir = 'uploads/';
            $imageName = time() . '_' . basename($newImage['name']);
            $uploadFile = $uploadDir . $imageName;

          
            if (move_uploaded_file($newImage['tmp_name'], $uploadFile)) {
                $imagePath = $uploadFile;
            }
        }

       
        $stmt = $pdo->prepare("UPDATE articles SET title = :title, content = :content, image = :image WHERE id = :id AND author_id = :author_id");
        $stmt->execute([
            'title' => $title,
            'content' => $content,
            'image' => $imagePath,
            'id' => $articleId,
            'author_id' => $_SESSION['user_id']
        ]);

        header("Location: personal_articles.php?success=Статья обновлена");
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
    <title>Редактировать статью</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Редактировать статью</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form action="edit_article.php?id=<?= $articleId ?>" method="POST" enctype="multipart/form-data">
            <label for="title">Заголовок:</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($article['title']) ?>" required>
            
            <label for="content">Содержимое:</label>
            <textarea id="content" name="content" required><?= htmlspecialchars($article['content']) ?></textarea>
            
            <label for="image">Текущее изображение:</label>
            <?php if (!empty($article['image'])): ?>
                <img src="<?= htmlspecialchars($article['image']) ?>" alt="Изображение статьи" style="max-width: 300px; display: block; margin-bottom: 10px;">
            <?php endif; ?>
            <label for="image">Загрузить новое изображение:</label>
            <input type="file" id="image" name="image" accept="image/*">
            
            <button type="submit">Сохранить изменения</button>
        </form>
        <p><a href="personal_articles.php">Назад</a></p>
    </div>
</body>
</html>
