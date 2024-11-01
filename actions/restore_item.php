<?php
session_start();
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $_POST['id'];

    $stmt = $pdo->prepare("UPDATE items SET deleted = 0, updated_at = NOW() WHERE id = :id AND user_id = :user_id");
    $stmt->execute([
        'id' => $item_id,
        'user_id' => $_SESSION['user_id'],
    ]);

    header("Location: ../public/dashboard.php");
    exit;
}
?>
