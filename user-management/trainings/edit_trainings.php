<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$success_message = '';
$error_message = '';

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
    <title>Editar Treino</title>
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            width: 100%;
            margin: 20px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Animação */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Títulos */
        h1 {
            margin-bottom: 20px;
            font-size: 2.5em;
            color: #333;
        }

        /* Formulários */
        form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: left;
        }

        input, textarea, button {
            width: 100%;
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            transition: all 0.3s ease-in-out;
        }

        input:focus, textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.25);
            outline: none;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 14px 20px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Links */
        a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        a:hover {
            color: #0056b3;
        }

        /* Barra de navegação */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .navbar .title {
            color: white;
            font-size: 1.5em;
            text-decoration: none;
        }

        .navbar .actions {
            display: flex;
            gap: 10px;
        }

        .navbar .actions button {
            color: white;
            background-color: #0056b3;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease-in-out;
            border: none;
            cursor: pointer;
        }

        .navbar .actions button:hover {
            background-color: #003d80;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <a href="../dashboard.php" class="title">Dashboard</a>
            <div class="actions">
                <form action="../logout.php" method="POST" style="display: inline;">
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
        <h1>Editar Treino</h1>
        <form action="edit_trainings.php?id=<?php echo $trainingId; ?>" method="POST">
            <input type="text" name="name" required placeholder="Training Name" value="<?php echo htmlspecialchars($training['name']); ?>">
            <textarea name="description" required placeholder="Training Description"><?php echo htmlspecialchars($training['description']); ?></textarea>
            <button type="submit">Update</button>
        </form>
        <a href="../dashboard.php" class="back-link">Voltar ao Dashboard</a>
    </div>   
</body>
</html>