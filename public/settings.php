<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: index.html");
    exit;
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$profile_picture = $_SESSION['profile_picture'] ?? 'null_profile.jpg'; // Gunakan gambar default jika belum ada foto profil

$status_message = '';
if (isset($_GET['status']) && $_GET['status'] == 'success') {
    $status_message = '<div class="alert alert-success">Profil berhasil diperbarui.</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Settings | Tododo</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h4>Pengaturan Profil</h4>
    <?php echo $status_message; ?>
    <form action="../actions/update_profile.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="profile_picture">Foto Profil:</label>
            <input type="file" class="form-control" name="profile_picture">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Password Baru:</label>
            <input type="password" class="form-control" name="password">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
</body>
</html>
