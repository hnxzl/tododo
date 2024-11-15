<?php
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=tododo",
        "root",
        ""
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            error_log("Input password: " . $password);
            error_log("Stored hash: " . $user['password']);
            
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                
                echo "<script>alert('Login successful!'); window.location.href = '../public/dashboard.php'; </script>";
            } else {
                echo "<script>alert('Invalid password!'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Email not found!'); window.history.back();</script>";
        }
    } catch (PDOException $e) {
        
        error_log("Database error: " . $e->getMessage());
        echo "<script>alert('An error occurred. Please try again later.'); window.history.back();</script>";
    }
}
?>