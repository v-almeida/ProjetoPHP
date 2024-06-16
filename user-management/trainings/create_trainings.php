<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isset($_SESSION['user_id']) || getUserById($_SESSION['user_id'])['role'] != 'teacher') {
    header("Location: ../login.php");
    exit();
}

$success_message = '';
$error_message = '';

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
    <title>Criar Treino!</title>
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
        h1, h2 {
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2.5em;
            color: #333;
        }

        h2 {
            font-size: 1.5em;
            color: #555;
        }

        /* Formulários e listas */
        form, ul {
            margin-bottom: 20px;
            text-align: left;
        }

        input, textarea, button, select {
            width: 100%;
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            transition: all 0.3s ease-in-out;
        }

        /* Foco nos inputs */
        input:focus, textarea:focus, select:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.25);
            outline: none;
        }

        /* Botões */
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

        /* Mensagens de sucesso e erro */
        .success-message {
            color: green;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        .error-message {
            color: red;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Estilização adicional para elementos específicos */
        textarea {
            resize: vertical;
        }

        form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form button {
            width: auto;
            margin: 0 auto;
            display: block;
        }

        ul {
            list-style-type: none;
        }

        ul li {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 5px;
        }

        ul li a {
            margin-left: 10px;
            font-size: 0.9em;
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease-in-out;
        }

        ul li a:hover {
            background-color: #0056b3;
        }

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
        <h1>Criar novo Treino!</h1>
        <?php if ($success_message): ?>
            <p class="success-message"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="create_trainings.php" method="POST">
            <input type="text" name="name" required placeholder="Nome do treino">
            <textarea name="description" required placeholder="Descrição do treino"></textarea>
            <button type="submit">Criar</button>
        </form>
        <a href="../dashboard.php" class="back-link">Voltar ao Dashboard</a>
    </div>
</body>
</html>
