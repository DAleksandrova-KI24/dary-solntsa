<?php
session_start(); // Запускаем сессию
if (!isset($_SESSION["user_id"])) {
    die(json_encode(["status" => "error", "message" => "Вы не авторизованы."]));
}

echo json_encode([
    "status" => "success",
    "username" => $_SESSION["username"]
]);
?>