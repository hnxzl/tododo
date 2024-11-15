<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: ../public/");
    exit;
}

require_once '../config/config.php';

$email = $_POST['email'];
$password = $_POST['password'] ?? null; 
$profile_picture = $_FILES['profile_picture'] ?? null;

$update_success = true;

try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND username != ?");
    $stmt->execute([$email, $_SESSION['username']]);
    $existing_user = $stmt->fetch();

    if ($existing_user) {
        throw new Exception("Email sudah terdaftar oleh pengguna lain.");
    }

    if ($profile_picture && $profile_picture['error'] == UPLOAD_ERR_OK) {
        $target_dir = "../public/assets/images/";
        $target_file = $target_dir . basename($profile_picture["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($profile_picture["tmp_name"]);
        if ($check === false) {
            throw new Exception("File yang diunggah bukan gambar.");
        }

        if ($profile_picture["size"] > 2000000) {
            throw new Exception("Ukuran file terlalu besar.");
        }

        if (!move_uploaded_file($profile_picture["tmp_name"], $target_file)) {
            throw new Exception("Gagal mengunggah file.");
        }

        $_SESSION['profile_picture'] = basename($profile_picture["name"]);
    }

    $stmt = $conn->prepare("UPDATE users SET email = ? WHERE username = ?");
    $stmt->execute([$email, $_SESSION['username']]);

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->execute([$hashed_password, $_SESSION['username']]);
    }

    header("Location: ../public/dashboard.php?status=success");
    exit;

} catch (Exception $e) {
    header("Location: ../public/settings.php?error=" . urlencode($e->getMessage()));
exit;
}
