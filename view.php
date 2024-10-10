<?php
include 'db.php'; // Meng-include file db.php yang berisi koneksi ke database

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Melakukan query ke database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Data Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        nav {
            background-color: #5cb85c;
            padding: 10px 20px;
            border-radius: 5px;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-around;
        }
        nav li {
            display: inline;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        nav a:hover {
            background-color: #4cae4c;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        @media (max-width: 600px) {
            table {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="store.php">Simpan Data</a></li>
        <li><a href="view.php">Lihat Data</a></li> <!-- Ganti dengan halaman lain sesuai kebutuhan -->
    </ul>
</nav>

<h2>Data Pengguna</h2>

<?php
// Koneksi ulang untuk menampilkan data
include 'db.php';

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr><th>ID</th><th>Username</th><th>Email</th></tr>'; // Header tabel
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row["id"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["username"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["email"]) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo "Tidak ada data pengguna yang ditemukan.";
}

$conn->close();
?>

</body>
</html>
