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

// Verifikasi token
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = :token AND reset_token_expiry > NOW()");
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Invalid or expired reset token");
    }
}

// Proses form reset password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    $token = $_POST['token'];

    try {
        $stmt = $pdo->prepare("UPDATE users SET password = :password, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = :token");
        $stmt->execute([
            'password' => $new_password,
            'token' => $token
        ]);

        echo "<script>alert('Password has been reset successfully!'); window.location.href = '../public/index.html';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('An error occurred. Please try again later.'); window.history.back();</script>";
    }
}
?>

<!-- Form HTML untuk reset password -->
<form method="POST">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
    <input type="password" name="new_password" required placeholder="Enter new password">
    <button type="submit">Reset Password</button>
</form>