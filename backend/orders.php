<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    die(json_encode(["status" => "error", "message" => "Вы не авторизованы."]));
}

$user_id = $_SESSION["user_id"];

$stmt = $pdo->prepare("SELECT id, total_price, status, created_at FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(["status" => "success", "orders" => $orders]);
?>