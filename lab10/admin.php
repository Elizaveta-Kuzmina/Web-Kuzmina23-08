<?php
session_start();
include 'db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}


$stmt = $pdo->query("SELECT id, username, email, role, created_at FROM users");
$users = $stmt->fetchAll();


if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $deleteId]);
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление пользователями</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Админ-панель: управление пользователями</h1>
    </header>
    
       
     <center>   <h2 style= "text-indent: 20px">Список пользователей</h2></center>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя пользователя</th>
                    <th>Email</th>
                    <th>Роль</th>
                    <th>Дата регистрации</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']); ?></td>
                        <td><?= htmlspecialchars($user['username']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td><?= htmlspecialchars($user['role']); ?></td>
                        <td><?= htmlspecialchars($user['created_at']); ?></td>
                        <td>
                            <a href="admin_edit_user.php?id=<?= $user['id']; ?>">Редактировать</a>
                            <a href="admin.php?delete_id=<?= $user['id']; ?>" onclick="return confirm('Вы уверены, что хотите удалить этого пользователя?');">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table> 
 <a href="admin_add_user.php" class="add-link" style="text-indent: 20px">Добавить пользователя</a>
        <a href="main.php" style= "text-indent: 20px">На главную</a>
    
</body>
</html>
