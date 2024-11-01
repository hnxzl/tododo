<?php
session_start();

try {
    $pdo = new PDO('mysql:host=localhost;dbname=tododo', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $pdo->prepare("INSERT INTO notes (title, content, priority) VALUES (?, ?, ?)");
        $stmt->execute([
            $_POST['note_title'],
            $_POST['note_content'],
            $_POST['note_priority']
        ]);

        header("Location: dashboard.php");
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tambah Catatan | Tododo</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h4>Tambah Catatan</h4>
    <form action="../actions/add_note.php" method="POST">
        <div class="form-group">
            <label for="note_title">Judul Catatan:</label>
            <input type="text" class="form-control" name="note_title" required>
        </div>
        <div class="form-group">
            <label for="content">Isi Catatan:</label>
            <textarea class="form-control" name="content" required></textarea>
        </div>
        <div class="form-group">
            <label for="priority">Prioritas:</label>
            <select class="form-control" name="priority">
                <option value="rendah">Rendah</option>
                <option value="sedang">Sedang</option>
                <option value="tinggi">Tinggi</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Catatan</button>
    </form>
</div>
</body>
</html>
