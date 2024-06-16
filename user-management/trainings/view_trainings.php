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
    <title>Ver Treino</title>
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

        /* Links */
        a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        a:hover {
            color: #0056b3;
        }

        /* Estilização adicional para elementos específicos */
        .container a.button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s ease-in-out;
        }

        .container a.button:hover {
            background-color: #0056b3;
        }

        .container .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        .container .back-link:hover {
            color: #0056b3;
        }

        /* Adicionando a barra de navegação */
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
        <h1><?php echo htmlspecialchars($training['name']); ?></h1>
        <p><?php echo htmlspecialchars($training['description']); ?></p>
        <a href="../dashboard.php" class="back-link">Voltar para o Dashboard</a>
    </div>
</body>
</html>
