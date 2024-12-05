<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);

   
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
    $stmt->execute(['username' => $username,  'email' => $email, 'password' => $password,]);

    
    $userId = $pdo->lastInsertId();

   
    $_SESSION['user_id'] = $userId;
    $_SESSION['username'] = $username;
    $_SESSION['role'] = 'user';

   
    header("Location: main.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
 <link rel="stylesheet" href="style.css">
</head>
<body>
    <header><h1>Регистрация</h1></header>
<div class="container">
    <form method="POST">
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Зарегистрироваться</button>
    </form>
<div>
    <p><a href="login.php">Войти</a></p>
 <p><a href="main.php">Назад</a></p>
</body>
</html>
