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

$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(["status" => "success", "orders" => $orders]);
?>
