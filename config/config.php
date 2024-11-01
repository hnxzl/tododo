<?php
try {
    $host = "localhost";
    $dbname = "tododo";
    $username = "root";
    $password = "";

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Test koneksi
    $test = $conn->query("SELECT 1");
    echo "Koneksi database berhasil!";
    
} catch(PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
    die();
}
?>