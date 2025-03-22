<?php
session_start();
session_destroy(); // Удаляем все данные сессии
echo json_encode(["status" => "success", "message" => "Вы вышли из аккаунта."]);
?>