<?php
session_start();

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $product_id = $_POST["id"];
    $quantity = $_POST["quantity"] ?? 1;

    if (isset($_SESSION["cart"][$product_id])) {
        $_SESSION["cart"][$product_id] += $quantity;
    } else {
        $_SESSION["cart"][$product_id] = $quantity;
    }

    echo json_encode(["status" => "success", "message" => "Товар добавлен в корзину"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo json_encode($_SESSION["cart"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);
    $product_id = $data["id"] ?? null;

    if ($product_id && isset($_SESSION["cart"][$product_id])) {
        unset($_SESSION["cart"][$product_id]);
        echo json_encode(["status" => "success", "message" => "Товар удален"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Товар не найден"]);
    }
    exit;
}
?>
