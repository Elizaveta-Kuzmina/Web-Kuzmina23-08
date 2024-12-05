?php
include 'db.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
    die("Доступ запрещен");
}

$stmt = $pdo->query("SELECT id, username, email, role FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
</head>
<body>
    <h1>Админ-панель</h1>
    <a href="logout.php">Выход</a>
    <h2>Список пользователей</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Email</th>
            <th>Роль</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
