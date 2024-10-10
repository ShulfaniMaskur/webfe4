<?php
include 'db.php'; // Meng-include file db.php yang berisi koneksi ke database

// Cek jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $email);

    if ($stmt->execute() === TRUE) {
        $message = "Data berhasil disimpan.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna - Berhasil</title>
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
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 20px auto;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        @media (max-width: 600px) {
            .container {
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

<div class="container">
    <h2>Hasil Penyimpanan Data</h2>
    <p><?php echo isset($message) ? $message : ''; ?></p>
    <a href="index.php">Kembali ke Form Input Data</a>
</div>

</body>
</html>
