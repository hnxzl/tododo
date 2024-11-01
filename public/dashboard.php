<?php
// Mulai session
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: index.html");
    exit;
}

// Ambil data pengguna
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$profile_picture = $_SESSION['profile_picture'] ?? 'null_profile.jpg';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=tododo', 'root', ''); // Ubah sesuai kredensial Anda
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ambil data tugas, acara, dan catatan
    $tasks = $pdo->query("SELECT * FROM tasks ORDER BY FIELD(priority, 'tinggi', 'sedang', 'rendah')")->fetchAll(PDO::FETCH_ASSOC);
    $events = $pdo->query("SELECT * FROM events")->fetchAll(PDO::FETCH_ASSOC);
    $notes = $pdo->query("SELECT * FROM notes")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard | Tododo</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 bg-light" style="min-height: 100vh;">
            <div class="text-center p-4">
                <img src="../public/assets/images/<?php echo $profile_picture; ?>" class="rounded-circle" width="80" height="80" alt="Profile Picture">
                <h5><?php echo htmlspecialchars($username); ?></h5>
                <p><?php echo htmlspecialchars($email); ?></p>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="#" class="nav-link">Beranda</a></li>
                <li class="nav-item"><a href="tasks.php" class="nav-link">Tugas</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Acara</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Catatan</a></li>
                <li class="nav-item"><a href="calendar.php" class="nav-link">Kalender</a></li>
                <li class="nav-item"><a href="settings.php" class="nav-link">Pengaturan</a></li>
            </ul>
        </div>

        <div class="col-md-9">
            <div class="container p-4">
                <h4>Dashboard</h4>
                <div class="mb-4">
                    <button class="btn btn-success" data-toggle="modal" data-target="#addTaskModal">Tambah Tugas</button>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addEventModal">Tambah Acara</button>
                    <button class="btn btn-info" data-toggle="modal" data-target="#addNoteModal">Tambah Catatan</button>
                </div>
                
                <?php if (empty($tasks) && empty($events) && empty($notes)) { ?>
                    <div class="alert alert-info text-center">Belum ada item? Mulai buat sekarang!</div>
                <?php } else { ?>
                    <h5>Tugas</h5>
                    <div class="row">
                        <?php foreach ($tasks as $task) { ?>
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($task['title']); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars($task['due_date']); ?></p>
                                        <p class="card-text">Ditugaskan oleh: <?php echo htmlspecialchars($task['assigned_by']); ?></p>
                                        <span class="badge badge-<?php echo ($task['priority'] == 'tinggi') ? 'danger' : (($task['priority'] == 'sedang') ? 'warning' : 'success'); ?>">
                                            <?php echo htmlspecialchars($task['priority']); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    
                    <h5>Acara</h5>
                    <div class="row">
                        <?php foreach ($events as $event) { ?>
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                                        <p class="card-text">Mulai: <?php echo htmlspecialchars($event['start_date']); ?> Jam: <?php echo htmlspecialchars($event['event_time']); ?></p>
                                        <p class="card-text">Selesai: <?php echo htmlspecialchars($event['end_date']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <h5>Catatan</h5>
                    <div class="row">
                        <?php foreach ($notes as $note) { ?>
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($note['title']); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars($note['content']); ?></p>
                                        <span class="badge badge-<?php echo ($note['priority'] == 'tinggi') ? 'danger' : (($note['priority'] == 'sedang') ? 'warning' : 'success'); ?>">
                                            <?php echo htmlspecialchars($note['priority']); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="add_task.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="taskTitle">Judul Tugas</label>
                        <input type="text" class="form-control" name="task_title" required>
                    </div>
                    <div class="form-group">
                        <label for="dueDate">Tanggal Jatuh Tempo</label>
                        <input type="date" class="form-control" name="due_date" required>
                    </div>
                    <div class="form-group">
                        <label for="assignedBy">Ditugaskan oleh</label>
                        <input type="text" class="form-control" name="assigned_by" required>
                    </div>
                    <div class="form-group">
                        <label for="priority">Prioritas</label>
                        <select class="form-control" name="priority" required>
                            <option value="">Pilih Prioritas</option>
                            <option value="rendah">Rendah</option>
                            <option value="sedang">Sedang</option>
                            <option value="tinggi">Tinggi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Tugas</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="add_event.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Acara</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="eventTitle">Judul Acara</label>
                        <input type="text" class="form-control" name="event_title" required>
                    </div>
                    <div class="form-group">
                        <label for="startDate">Mulai Tanggal</label>
                        <input type="date" class="form-control" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="endDate">Selesai Tanggal</label>
                        <input type="date" class="form-control" name="end_date" required>
                    </div>
                    <div class="form-group">
                        <label for="eventTime">Jam Acara</label>
                        <input type="time" class="form-control" name="event_time" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Acara</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addNoteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="add_note.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Catatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="noteTitle">Judul Catatan</label>
                        <input type="text" class="form-control" name="note_title" required>
                    </div>
                    <div class="form-group">
                        <label for="noteContent">Isi Catatan</label>
                        <textarea class="form-control" name="note_content" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="notePriority">Prioritas (opsional)</label>
                        <select class="form-control" name="note_priority">
                            <option value="">Pilih Prioritas</option>
                            <option value="rendah">Rendah</option>
                            <option value="sedang">Sedang</option>
                            <option value="tinggi">Tinggi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Catatan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
