<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Gambar</title>
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
        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
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
            margin: 20px auto;
        }
        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 10px auto;
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

<h2>Upload Gambar</h2>

<form action="upload.php" method="post" enctype="multipart/form-data">
    <label for="image">Pilih Gambar:</label>
    <input type="file" id="image" name="image" accept="image/*" required>
    <input type="submit" value="Upload">
</form>

<?php
// Koneksi ke database
$servername = "localhost"; // Ubah jika diperlukan
$username = "root"; // Ubah jika diperlukan
$password = ""; // Ubah jika diperlukan
$dbname = "userdb"; // Nama database yang telah dibuat

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses upload gambar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $target_dir = "uploads/"; // Folder untuk menyimpan gambar
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file gambar sebenarnya
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        echo "File adalah gambar - " . htmlspecialchars($check["mime"]) . ".";
        $uploadOk = 1;
    } else {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }

    // Cek jika file sudah ada
    if (file_exists($target_file)) {
        echo "Maaf, file sudah ada.";
        $uploadOk = 0;
    }

    // Cek ukuran file
    if ($_FILES["image"]["size"] > 500000) {
        echo "Maaf, ukuran file terlalu besar.";
        $uploadOk = 0;
    }

    // Hanya izinkan format gambar tertentu
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Maaf, hanya format JPG, JPEG, PNG & GIF yang diizinkan.";
        $uploadOk = 0;
    }

    // Cek apakah $uploadOk bernilai 0 karena ada kesalahan
    if ($uploadOk == 0) {
        echo "Maaf, file tidak dapat diupload.";
    } else {
        // Jika semua cek lolos, coba untuk meng-upload file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "File " . htmlspecialchars(basename($_FILES["image"]["name"])) . " telah diupload.";

            // Simpan informasi gambar ke database
            $stmt = $conn->prepare("INSERT INTO images (image_name) VALUES (?)");
            $image_name = basename($_FILES["image"]["name"]);

            if ($stmt->execute()) {
                echo "<br>Data gambar berhasil disimpan.";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Maaf, terjadi kesalahan saat meng-upload file.";
        }
    }
}

// Menampilkan gambar yang di-upload
$sql = "SELECT * FROM images ORDER BY uploaded_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h3>Gambar yang Di-upload:</h3>";
    while ($row = $result->fetch_assoc()) {
        echo '<img src="uploads/' . htmlspecialchars($row['image_name']) . '" alt="Uploaded Image">';
    }
} else {
    echo "Belum ada gambar yang di-upload.";
}

// Menutup koneksi
$conn->close();
?>

</body>
</html>
