<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = getUserById($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?></h1>
    <a href="logout.php">Logout</a>
    
    <?php if ($user['role'] == 'teacher'): ?>
        <a href="trainings/create_training.php">Create New Training</a>
    <?php endif; ?>

    <h2>Your Trainings</h2>
    <ul>
        <?php
        $trainings = getTrainingsByUserId($user['id']);
        foreach ($trainings as $training) {
            echo "<li>" . htmlspecialchars($training['name']) . " - " . htmlspecialchars($training['description']);
            echo " <a href='trainings/view_training.php?id=" . $training['id'] . "'>View</a>";
            if ($user['role'] == 'teacher') {
                echo " <a href='trainings/edit_training.php?id=" . $training['id'] . "'>Edit</a>";
                echo " <a href='trainings/delete_training.php?id=" . $training['id'] . "'>Delete</a>";
            }
            echo "</li>";
        }
        ?>
    </ul>
</body>
</html>
