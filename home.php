<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #e9ecef;
        }
        nav {
            background-color: #007bff;
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
            background-color: #0056b3;
        }
        h1 {
            text-align: center;
            color: #343a40;
            margin-top: 20px;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }
        .image-upload {
            margin-top: 20px;
            text-align: center;
        }
        input[type="file"] {
            margin-top: 10px;
        }
        img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
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
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="store.php">Simpan Data</a></li>
        <li><a href="view.php">Lihat Data</a></li>
        <li><a href="upload.php">Upload Gambar</a></li>
    </ul>
</nav>

<h1>Selamat Datang di Halaman Pengguna</h1>

<div class="container">
    <h2>Informasi Aplikasi</h2>
    <p>Ini adalah aplikasi sederhana untuk mengelola data pengguna. Anda dapat memasukkan data pengguna, melihat data pengguna yang telah disimpan, dan meng-upload gambar untuk keperluan lebih lanjut.</p>
    
    <div class="image-upload">
        <h3>Upload Gambar</h3>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="image" accept="image/*" required>
            <input type="submit" value="Upload Gambar">
        </form>
    </div>

    <h3>Gambar yang telah di-upload:</h3>
    <div class="uploaded-images">
        <?php
        // Tampilkan gambar yang telah di-upload
        $dir = "uploads/";
        if (is_dir($dir)) {
            $images = glob($dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
            foreach ($images as $image) {
                echo '<img src="' . $image . '" alt="Uploaded Image">';
            }
        }
        ?>
    </div>
</div>

</body>
</html>
