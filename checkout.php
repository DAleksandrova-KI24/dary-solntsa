<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    die(json_encode(["status" => "error", "message" => "Вы не авторизованы."]));
}

if (empty($_SESSION["cart"])) {
    die(json_encode(["status" => "error", "message" => "Корзина пуста."]));
}

$name = trim($_POST["name"]);
$address = trim($_POST["address"]);
$phone = trim($_POST["phone"]);

if (!$name || !$address || !$phone) {
    die(json_encode(["status" => "error", "message" => "Заполните все поля."]));
}

$user_id = $_SESSION["user_id"];
$total_price = 0;

foreach ($_SESSION["cart"] as $product_id => $quantity) {
    $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if ($product) {
        $total_price += $product["price"] * $quantity;
    }
}

$stmt = $pdo->prepare("INSERT INTO orders (user_id, name, address, phone, total_price, status) VALUES (?, ?, ?, ?, ?, 'pending')");
$stmt->execute([$user_id, $name, $address, $phone, $total_price]);

$order_id = $pdo->lastInsertId();

$_SESSION["cart"] = [];

echo json_encode(["status" => "success", "message" => "Заказ №$order_id успешно оформлен!"]);
?>
