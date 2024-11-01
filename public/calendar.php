<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: index.html");
    exit;
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=tododo', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $tasks = $pdo->query("SELECT id, title as 'name', due_date as 'date', 'task' as 'type' FROM tasks")->fetchAll(PDO::FETCH_ASSOC);
    $events = $pdo->query("SELECT id, title as 'name', start_date as 'date', 'event' as 'type' FROM events")->fetchAll(PDO::FETCH_ASSOC);
    
    $calendar_items = array_merge($tasks, $events);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kalender | Tododo</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css' rel='stylesheet' />
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include('sidebar.php'); ?>
        <div class="col-md-9">
            <div class="container p-4">
                <h4>Kalender</h4>
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: <?php echo json_encode($calendar_items); ?>,
        eventClick: function(info) {
            alert('Event: ' + info.event.title);
        },
        eventClassNames: function(arg) {
            return arg.event.extendedProps.type === 'task' ? 'bg-primary' : 'bg-success';
        }
    });
    calendar.render();
});
</script>

</body>
</html>