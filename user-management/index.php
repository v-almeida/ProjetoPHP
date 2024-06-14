<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
} else {
    header("Location: register.php"); // Redireciona para a página de registro
    exit();
}
?>
