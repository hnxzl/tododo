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
    // Ambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    // Hash password sebelum disimpan
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $password,
        ]);

        echo "<script>alert('Sign up successful!'); window.location.href = '../public/index.html';</script>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<script>alert('Email is already registered. Please try another one.'); window.history.back();</script>";
        } else {
            echo "<script>alert('An error occurred. Please try again later.'); window.history.back();</script>";
        }
    }
}
?>