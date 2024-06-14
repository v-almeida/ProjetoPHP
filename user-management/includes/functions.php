<?php
function registerUser($username, $password, $role) {
    global $mysqli;
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $mysqli->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashedPassword, $role);
    $stmt->execute();
    $stmt->close();
}

function loginUser($username, $password) {
    global $mysqli;
    session_start();
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        return true;
    }
    return false;
}

function getUserById($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT * ```php
FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    return $user;
}

function getTrainingsByUserId($userId) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT * FROM trainings WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $trainings = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $trainings;
}

function getTrainingById($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT * FROM trainings WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $training = $result->fetch_assoc();
    $stmt->close();
    return $training;
}

function createTraining($name, $description, $userId) {
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO trainings (name, description, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $name, $description, $userId);
    $stmt->execute();
    $stmt->close();
}

function updateTraining($id, $name, $description) {
    global $mysqli;
    $stmt = $mysqli->prepare("UPDATE trainings SET name = ?, description = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $description, $id);
    $stmt->execute();
    $stmt->close();
}

function deleteTraining($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("DELETE FROM trainings WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
?>

