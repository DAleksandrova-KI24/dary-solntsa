<?php
session_start(); // Запускаем сессию
require '../config.php'; // Подключаем базу данных

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        // Сохраняем данные пользователя в сессии
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        
        echo json_encode(["status" => "success", "message" => "Вход выполнен!", "username" => $user["username"]]);
    } else {
        echo json_encode(["status" => "error", "message" => "Неверный email или пароль"]);
    }
}
?>