<?php
session_start();

try {
    $pdo = new PDO('mysql:host=localhost;dbname=tododo', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $pdo->prepare("INSERT INTO events (title, start_date, end_date, event_time) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $_POST['event_title'],
            $_POST['start_date'],
            $_POST['end_date'],
        ]);

        header("Location: dashboard.php");
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>