<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$pass = ''; // Jika tidak ada password, gunakan string kosong
$dbname = 'userdb';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tangani POST untuk menambah pengguna
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $stmt = $conn->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->close();
}

// Tangani POST untuk meng-upload gambar
if (isset($_POST['upload_image'])) {
    $image_name = basename($_FILES["image"]["name"]);
    $target_dir = "uploads/";
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO images (image_name) VALUES (?)");
        $stmt->bind_param("s", $image_name);
        $stmt->execute();
        $stmt->close();
    }
}

// Tangani DELETE pengguna
if (isset($_GET['delete_user'])) {
    $id = $_GET['delete_user'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Tangani DELETE gambar
if (isset($_GET['delete_image'])) {
    $id = $_GET['delete_image'];
    $stmt = $conn->prepare("DELETE FROM images WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Tangani GET untuk meng-update pengguna
$userToEdit = null;
if (isset($_GET['edit_user'])) {
    $id = $_GET['edit_user'];
    $userToEdit = $conn->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();
}

// Tangani POST untuk meng-update pengguna
if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $email, $id);
    $stmt->execute();
    $stmt->close();
}

// Ambil data pengguna
$result_users = $conn->query("SELECT * FROM users");
// Ambil data gambar
$result_images = $conn->query("SELECT * FROM images");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Pengguna dan Gambar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #343a40;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        input[type="text"],
        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
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
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            color: white;
            margin: 0 5px;
        }
        .btn-edit {
            background-color: #28a745; /* Green */
        }
        .btn-edit:hover {
            background-color: #218838; /* Darker Green */
        }
        .btn-delete {
            background-color: #dc3545; /* Red */
        }
        .btn-delete:hover {
            background-color: #c82333; /* Darker Red */
        }
    </style>
</head>
<body>

<h2>Form Input Data Pengguna</h2>
<form action="" method="POST">
    <input type="hidden" name="id" value="<?php echo $userToEdit['id'] ?? ''; ?>">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required value="<?php echo $userToEdit['username'] ?? ''; ?>">
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required value="<?php echo $userToEdit['email'] ?? ''; ?>">

    <?php if ($userToEdit): ?>
        <input type="submit" name="update_user" value="Update Data Pengguna">
    <?php else: ?>
        <input type="submit" name="add_user" value="Simpan Data Pengguna">
    <?php endif; ?>
</form>

<h2>Data Pengguna</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result_users->fetch_assoc()) : ?>
        <tr>
            <td><?php echo htmlspecialchars($row["id"]); ?></td>
            <td><?php echo htmlspecialchars($row["username"]); ?></td>
            <td><?php echo htmlspecialchars($row["email"]); ?></td>
            <td>
                <a href="?edit_user=<?php echo $row["id"]; ?>" class="btn btn-edit">Edit</a> 
                <a href="?delete_user=<?php echo $row["id"]; ?>" class="btn btn-delete" onclick="return confirm('Anda yakin ingin menghapus pengguna ini?');">Hapus</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<h2>Upload Gambar</h2>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="image" required>
    <input type="submit" name="upload_image" value="Upload Gambar">
</form>

<h2>Gambar Tersimpan</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nama Gambar</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result_images->fetch_assoc()) : ?>
        <tr>
            <td><?php echo htmlspecialchars($row["id"]); ?></td>
            <td><?php echo htmlspecialchars($row["image_name"]); ?></td>
            <td>
                <a href="?delete_image=<?php echo $row["id"]; ?>" class="btn btn-delete" onclick="return confirm('Anda yakin ingin menghapus gambar ini?');">Hapus</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<?php
$conn->close();
?>

</body>
</html>
