<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isset($_SESSION['user_id']) || getUserById($_SESSION['user_id'])['role'] != 'teacher') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $userId = $_SESSION['user_id'];

    createTraining($name, $description, $userId);
    header("Location: ../dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Criar treino!</title>
</head>
<body>
    <h1>Criar novo Treino!</h1>
    <form action="create_trainings.php" method="POST">
        <input type="text" name="name" required placeholder="Training Name">
        <textarea name="description" required placeholder="Training Description"></textarea>
        <button type="submit">Criar</button>
    </form>
</body>
</html>
