<?php
require 'config.php';

try {
    $stmt = $pdo->query("SELECT 'Подключение успешно!' AS message");
    $row = $stmt->fetch();
    echo $row['message'];
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>