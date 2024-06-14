<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$trainingId = $_GET['id'];
$training = getTrainingById($trainingId);
$user = getUserById($_SESSION['user_id']);

if (!$training || $user['role'] != 'teacher' || $training['user_id'] != $user['id']) {
    echo "You are not allowed to delete this training.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    deleteTraining($trainingId);
    header("Location: ../dashboard.php");
    exit();
}

function deleteTraining($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM trainings WHERE id = ?");
    $stmt->execute([$id]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Training</title>
</head>
<body>
    <h1>Are you sure you want to delete this training?</h1>
    <form action="delete_training.php?id=<?php echo $trainingId; ?>" method="POST">
        <button type="submit">Yes, Delete</button>
    </form>
    <a href="../dashboard.php
