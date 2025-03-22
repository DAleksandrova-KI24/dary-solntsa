<?php
session_start();
require '../config.php';

if (!isset($_SESSION["user_id"])) {
    die(json_encode(["status" => "error", "message" => "Вы не авторизованы."]));
}

$stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
$stmt->execute([$_SESSION["user_id"]]);
$user = $stmt->fetch();

if (!$user || $user["role"] !== "admin") {
    die(json_encode(["status" => "error", "message" => "Доступ запрещен."]));
}

$data = json_decode(file_get_contents("php://input"), true);
$order_id = $data["order_id"] ?? null;
$new_status = $data["status"] ?? null;

if (!$order_id || !$new_status) {
    die(json_encode(["status" => "error", "message" => "Некорректные данные."]));
}

$stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
$stmt->execute([$new_status, $order_id]);

echo json_encode(["status" => "success", "message" => "Статус заказа обновлен"]);
?>
