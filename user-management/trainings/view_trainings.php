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

if (!$training) {
    echo "Training not found.";
    exit();
}

$user = getUserById($_SESSION['user_id']);

if ($user['role'] == 'student' && $training['user_id'] != $user['id']) {
    echo "You are not allowed to view this training.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Training</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($training['name']); ?></h1>
    <p><?php echo htmlspecialchars($training['description']); ?></p>
    <a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>
