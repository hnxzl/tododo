<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: index.html");
    exit;
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=tododo', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $notes = $pdo->query("SELECT * FROM notes ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Catatan - Tododo</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="container p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Daftar Catatan</h4>
                    <button class="btn btn-success" data-toggle="modal" data-target="#addNoteModal">Tambah Catatan</button>
                </div>

                <div class="row" id="notesList">
                    <?php foreach ($notes as $note) { ?>
                        <div class="col-md-4 note-card">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($note['title']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($note['content']); ?></p>
                                    <span class="badge badge-secondary"><?php echo htmlspecialchars($note['priority']); ?></span>
                                    <!-- Tombol aksi -->
                                    <div class="mt-2">
                                        <button class="btn btn-sm btn-primary" onclick="editNote(<?php echo $note['id']; ?>)">Edit</button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteNote(<?php echo $note['id']; ?>)">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tambah Catatan -->
<?php include('modals/note_modal.php'); ?>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
// Delete note function
function deleteNote(noteId) {
    if(confirm('Apakah Anda yakin ingin menghapus catatan ini?')) {
        fetch('delete_note.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                note_id: noteId
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('Gagal menghapus catatan');
            }
        });
    }
}

// Edit note function
function editNote(noteId) {
    // Implement edit functionality
}
</script>

</body>
</html>
