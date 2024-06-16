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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Deletar Treino"</title>
</head>
<body>
    <h1>Tem certeza de que deseja excluir este treinamento?</h1>
    <form action="delete_trainings.php?id=<?php echo $trainingId; ?>" method="POST">
        <button type="submit">Sim, Deletar</button>
    </form>
    <a href="../dashboard.php">Não, volte</a>
</body>
</html>
