<?php
// Mulai session
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: index.html");
    exit;
}

// Ambil data pengguna dari session
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$profile_picture = $_SESSION['profile_picture'] ?? 'null_profile.jpg'; // Gunakan gambar default jika belum ada foto profil

// Tampilkan notifikasi sukses jika ada
$status_message = '';
if (isset($_GET['status']) && $_GET['status'] == 'success') {
    $status_message = '<div class="alert alert-success">Profil berhasil diperbarui.</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Settings - Tododo</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h4>Pengaturan Profil</h4>
    <?php echo $status_message; ?>
    <form action="../actions/update_profile.php" method="POST" enctype="multipart/form-data">
        <!-- Ubah Foto Profil -->
        <div class="form-group">
            <label for="profile_picture">Foto Profil:</label>
            <input type="file" class="form-control" name="profile_picture">
        </div>

        <!-- Ubah Email -->
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>

        <!-- Ubah Password -->
        <div class="form-group">
            <label for="password">Password Baru:</label>
            <input type="password" class="form-control" name="password">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
</body>
</html>
