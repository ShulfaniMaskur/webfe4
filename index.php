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
    <title>Form Input Data</title>
    <style>
                body {
            font-family: Arial, sans-serif;
            background-color: #e8f5e9; /* Mengganti warna latar belakang */
            margin: 0;
            padding: 20px;
        }
        nav {
            background-color: #4caf50; /* Mengganti warna navbar */
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
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
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
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
            form {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<nav>
    <a href="index.php">Home</a>
    <a href="store.php">Simpan Data</a>
    <a href="view.php">Lihat Data</a>
    <a href="upload.php">Upload Gambar</a>
</nav>

<h2>Form Input Data Pengguna</h2>

<form action="api.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <input type="submit" value="Simpan">
</form>

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
