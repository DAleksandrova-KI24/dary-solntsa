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

if (!isset($_FILES["image"]) || $_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
    die(json_encode(["status" => "error", "message" => "Ошибка загрузки файла."]));
}

$product_id = $_POST["product_id"] ?? null;
if (!$product_id) {
    die(json_encode(["status" => "error", "message" => "Не указан ID товара."]));
}

$ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
$filename = "product_" . $product_id . "." . $ext;
$filepath = "../uploads/" . $filename;

if (!move_uploaded_file($_FILES["image"]["tmp_name"], $filepath)) {
    die(json_encode(["status" => "error", "message" => "Ошибка сохранения файла."]));
}

$stmt = $pdo->prepare("UPDATE products SET image = ? WHERE id = ?");
$stmt->execute([$filename, $product_id]);

echo json_encode(["status" => "success", "message" => "Изображение загружено!", "filename" => $filename]);
?>
