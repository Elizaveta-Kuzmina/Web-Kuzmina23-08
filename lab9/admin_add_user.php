<?php
session_start();
include 'db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
    $stmt->execute([
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'role' => $role
    ]);

    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить пользователя</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Добавить пользователя</h1>
    </header>
    <div class="container">
        <form action="admin_add_user.php" method="post">
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Роль:</label>
            <select id="role" name="role" required>
                <option value="user">Пользователь</option>
                <option value="admin">Администратор</option>
            </select>
<br>
            <button type="submit">Добавить</button>
        </form>
        <a href="admin.php">Назад</a>
    </div>
    <footer>
        &copy; 2024 Спортивный сайт. Все права защищены.
    </footer>
</body>
</html>
