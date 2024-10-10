<?php
$host = "localhost";
$user = "root";
$password = ""; // Sesuaikan jika ada password
$dbname = "userdb";

// Membuat koneksi ke database dengan menggunakan variabel $password, bukan $pass
$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
