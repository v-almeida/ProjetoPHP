<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = getUserById($_SESSION['user_id']);
if (!$user) {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bem-vindo, <?php echo htmlspecialchars($user['username']); ?></h1>
    <a href="logout.php">Logout</a>
    
    <?php if ($user['role'] == 'teacher'): ?>
        <a href="trainings/create_trainings.php">Criar novo Treino</a>
    <?php endif; ?>

    <h2>Seus Treinos</h2>
    <ul>
        <?php
        $trainings = getTrainingsByUserId($user['id']);
        if (empty($trainings)) {
            echo "<li>No trainings found.</li>";
        } else {
            foreach ($trainings as $training) {
                echo "<li>" . htmlspecialchars($training['name']) . " - " . htmlspecialchars($training['description']);
                echo " <a href='trainings/view_trainings.php?id=" . $training['id'] . "'>Ver</a>";
                if ($user['role'] == 'teacher') {
                    echo " <a href='trainings/edit_trainings.php?id=" . $training['id'] . "'>Editar</a>";
                    echo " <a href='trainings/delete_trainings.php?id=" . $training['id'] . "'>Deletar</a>";
                }
                echo "</li>";
            }
        }
        ?>
    </ul>
</body>
</html>
