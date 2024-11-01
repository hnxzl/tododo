<?php
require_once '../config/config.php';

$stmt = $pdo->prepare("DELETE FROM items WHERE deleted = 1 AND updated_at < NOW() - INTERVAL 30 DAY");
$stmt->execute();
?>
