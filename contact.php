<?php
require 'config.php';

$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$message = trim($_POST["message"]);

if (!$name || !$email || !$message) {
    die(json_encode(["status" => "error", "message" => "Заполните все поля."]));
}

$stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
$stmt->execute([$name, $email, $message]);

echo json_encode(["status" => "success", "message" => "Ваше сообщение отправлено!"]);
?>
