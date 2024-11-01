<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: index.html");
    exit;
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=tododo', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $events = $pdo->query("SELECT * FROM events ORDER BY start_date")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Acara - Tododo</title>
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
                    <h4>Daftar Acara</h4>
                    <button class="btn btn-success" data-toggle="modal" data-target="#addEventModal">Tambah Acara</button>
                </div>

                <div class="row" id="eventsList">
                    <?php foreach ($events as $event) { ?>
                        <div class="col-md-4 event-card">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                                    <p class="card-text">Mulai: <?php echo htmlspecialchars($event['start_date']); ?></p>
                                    <p class="card-text">Selesai: <?php echo htmlspecialchars($event['end_date']); ?></p>
                                    <p class="card-text"><?php echo htmlspecialchars($event['description']); ?></p>
                                    <!-- Tombol aksi -->
                                    <div class="mt-2">
                                        <button class="btn btn-sm btn-primary" onclick="editEvent(<?php echo $event['id']; ?>)">Edit</button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteEvent(<?php echo $event['id']; ?>)">Hapus</button>
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

<!-- Modal untuk Tambah Acara -->
<?php include('modals/event_modal.php'); ?>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
// Delete event function
function deleteEvent(eventId) {
    if(confirm('Apakah Anda yakin ingin menghapus acara ini?')) {
        fetch('delete_event.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                event_id: eventId
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('Gagal menghapus acara');
            }
        });
    }
}

// Edit event function
function editEvent(eventId) {
    // Implement edit functionality
}
</script>

</body>
</html>
