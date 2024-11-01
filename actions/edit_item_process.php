<?php
session_start();
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $flag = $_POST['flag'];

    $stmt = $pdo->prepare("UPDATE items SET title = :title, content = :content, flag = :flag, updated_at = NOW() WHERE id = :id AND user_id = :user_id");
    $stmt->execute([
        'id' => $item_id,
        'title' => $title,
        'content' => $content,
        'flag' => $flag,
        'user_id' => $_SESSION['user_id'],
    ]);

    header("Location: ../public/dashboard.php");
    exit;
}
?>
