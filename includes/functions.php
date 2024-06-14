<?php
function registerUser($username, $password, $role) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt->execute([$username, $hashedPassword, $role]);
}

function loginUser($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        return true;
    }
    return false;
}

function getUserById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getTrainingsByUserId($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM trainings WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

// Outras funções...

function getTrainingById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM trainings WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function updateTraining($id, $name, $description) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE trainings SET name = ?, description = ? WHERE id = ?");
    $stmt->execute([$name, $description, $id]);
}

function deleteTraining($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM trainings WHERE id = ?");
    $stmt->execute([$id]);
}
?>

?>
