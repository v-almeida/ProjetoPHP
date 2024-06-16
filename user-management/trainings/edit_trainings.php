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
    echo "You are not allowed to edit this training.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    updateTraining($trainingId, $name, $description);
    header("Location: ../dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Training</title>
</head>
<body>
    <h1>Edit Training</h1>
    <form action="edit_training.php?id=<?php echo $trainingId; ?>" method="POST">
        <input type="text" name="name" required placeholder="Training Name" value="<?php echo htmlspecialchars($training['name']); ?>">
        <textarea name="description" required placeholder="Training Description"><?php echo htmlspecialchars($training['description']); ?></textarea>
        <button type="submit">Update</button>
    </form>
    <a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>
