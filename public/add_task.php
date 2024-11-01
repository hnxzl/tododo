<?php
session_start();

try {
    $pdo = new PDO('mysql:host=localhost;dbname=tododo', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $pdo->prepare("INSERT INTO tasks (title, due_date, assigned_by, priority) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $_POST['task_title'],
            $_POST['due_date'],
            $_POST['assigned_by'],
            $_POST['priority']
        ]);

        header("Location: dashboard.php");
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>