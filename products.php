<?php
require 'config.php';

$stmt = $pdo->query("SELECT id, name, description, price, image FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($products);
?>