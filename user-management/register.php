<?php
include 'includes/db.php';
include 'includes/functions.php';

$success_message = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // "student" ou "teacher"

    // Verificar se o usuário já existe
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $error_message = "Usuário já existe.";
    } else {
        registerUser($username, $password, $role);
        header("Location: login.php");
        exit();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="stylesheet" href="../css/styles.css">
    <meta charset="UTF-8">
    <title>Cadastro</title>
</head>
<body>
<div class="container"> 
    <h1>Cadastro de Usuário</h1>
    <?php if ($success_message): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>
    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form action="register.php" method="POST">
        <input type="text" name="username" required placeholder="Username">
        <input type="password" name="password" required placeholder="Password">
        <select name="role">
            <option value="student">Aluno</option>
            <option value="teacher">Professor</option>
        </select>
        <button type="submit">Registrar</button>
    </form>
    <a href="login.php">Já tem uma conta? Faça login aqui</a>
</div>   
</body>
</html>
