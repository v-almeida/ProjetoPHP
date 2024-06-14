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

function createTraining($name, $description, $userId) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO trainings (name, description, user_id) VALUES (?, ?, ?)");
    $stmt->execute([$name, $description, $userId]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Training</title>
</head>
<body>
    <h1>Create New Training</h1>
    <form action="create_training.php" method="POST">
        <input type="text" name="name" required placeholder="Training Name">
        <textarea name="description" required placeholder="Training Description"></textarea>
        <button type="submit">Create</button>
    </form>
</body>
</html>