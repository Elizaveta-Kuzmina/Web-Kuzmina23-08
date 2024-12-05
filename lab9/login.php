<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

   
    $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        
        header("Location: main.php");
        exit;
    } else {
        $error = "Неверное имя пользователя или пароль.";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
 <link rel="stylesheet" href="style.css">
    <title>Авторизация</title>
</head>
<body>
    <h1>Авторизация</h1>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
    <p><a href="register.php">Регистрация</a></p>
</body>
</html>
