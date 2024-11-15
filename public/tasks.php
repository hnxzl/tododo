<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=tododo', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $tasks = $pdo->query("SELECT * FROM tasks ORDER BY FIELD(priority, 'tinggi', 'sedang', 'rendah')")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tugas | Tododo</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include('sidebar.php'); ?>

        <div class="col-md-9">
            <div class="container p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Daftar Tugas</h4>
                    <button class="btn btn-success" data-toggle="modal" data-target="#addTaskModal">Tambah Tugas</button>
                </div>

                <div class="mb-3">
                    <select class="form-control w-auto" id="priorityFilter">
                        <option value="all">Semua Prioritas</option>
                        <option value="tinggi">Tinggi</option>
                        <option value="sedang">Sedang</option>
                        <option value="rendah">Rendah</option>
                    </select>
                </div>

                <div class="row" id="tasksList">
                    <?php foreach ($tasks as $task) { ?>
                        <div class="col-md-4 task-card" data-priority="<?php echo $task['priority']; ?>">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($task['title']); ?></h5>
                                    <p class="card-text">Jatuh Tempo: <?php echo htmlspecialchars($task['due_date']); ?></p>
                                    <p class="card-text">Ditugaskan oleh: <?php echo htmlspecialchars($task['assigned_by']); ?></p>
                                    <span class="badge badge-<?php echo ($task['priority'] == 'tinggi') ? 'danger' : (($task['priority'] == 'sedang') ? 'warning' : 'success'); ?>">
                                        <?php echo htmlspecialchars($task['priority']); ?>
                                    </span>
                                    <div class="mt-2">
                                        <button class="btn btn-sm btn-primary" onclick="editTask(<?php echo $task['id']; ?>)">Edit</button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteTask(<?php echo $task['id']; ?>)">Hapus</button>
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

<?php include('modals/task_modal.php'); ?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$('#priorityFilter').change(function() {
    const priority = $(this).val();
    if(priority === 'all') {
        $('.task-card').show();
    } else {
        $('.task-card').hide();
        $(`.task-card[data-priority="${priority}"]`).show();
    }
});

function deleteTask(taskId) {
    if(confirm('Apakah Anda yakin ingin menghapus tugas ini?')) {
        fetch('delete_task.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                task_id: taskId
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('Gagal menghapus tugas');
            }
        });
    }
}

function editTask(taskId) {
}
</script>

</body>
</html>