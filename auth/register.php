<?php
require '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        die(json_encode(["status" => "error", "message" => "Этот email уже зарегистрирован."]));
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $email, $hashed_password])) {
        echo json_encode(["status" => "success", "message" => "Регистрация успешна!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Ошибка регистрации."]);
    }
}
?>