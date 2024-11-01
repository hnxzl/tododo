<div class="col-md-3 bg-light" style="min-height: 100vh;">
    <div class="text-center p-4">
        <img src="../public/assets/images/<?php echo $_SESSION['profile_picture'] ?? 'null_profile.jpg'; ?>" class="rounded-circle" width="80" height="80" alt="Profile Picture">
        <h5><?php echo htmlspecialchars($_SESSION['username']); ?></h5>
        <p><?php echo htmlspecialchars($_SESSION['email']); ?></p>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                Beranda
            </a>
        </li>
        <li class="nav-item">
            <a href="tasks.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'tasks.php' ? 'active' : ''; ?>">
                Tugas
            </a>
        </li>
        <li class="nav-item">
            <a href="events.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'events.php' ? 'active' : ''; ?>">
                Acara
            </a>
        </li>
        <li class="nav-item">
            <a href="notes.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'notes.php' ? 'active' : ''; ?>">
                Catatan
            </a>
        </li>
        <li class="nav-item">
            <a href="calendar.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'calendar.php' ? 'active' : ''; ?>">
                Kalender
            </a>
        </li>
        <li class="nav-item">
            <a href="settings.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">
                Pengaturan
            </a>
        </li>
    </ul>
</div>