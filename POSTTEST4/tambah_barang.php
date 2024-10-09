<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama_barang = $_POST['nama_barang'];
  $deskripsi = $_POST['deskripsi'];
  $harga = $_POST['harga'];

  $gambar = $_FILES['gambar']['name'];
  $target_dir = "storage/";
  $target_file = $target_dir . basename($gambar);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

  if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
      $sql = "INSERT INTO barang (nama_barang, deskripsi, harga, gambar) VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssds", $nama_barang, $deskripsi, $harga, $gambar);
      if ($stmt->execute()) {
        header('Location: kelola_barang.php');
        exit();
      } else {
        $error_message = "Gagal menambah barang.";
      }
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Barang</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display+SC:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap');

    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      display: flex;
      flex-direction: column;
    }

    h2 {
      color: #333;
      margin-bottom: 20px;
      text-align: center;
    }

    .form-container {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 500px;
      margin: 0 auto;
      margin-top: 40px;
    }

    .form-container label {
      display: block;
      margin: 15px 0 5px;
      color: #333;
      font-weight: bold;
    }

    .form-container input[type="text"],
    .form-container input[type="number"],
    .form-container textarea,
    .form-container input[type="file"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 14px;
      box-sizing: border-box;
    }

    .form-container textarea {
      height: 100px;
      resize: none;
    }

    .form-container button {
      background-color: #28a745;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 10px;
      transition: background-color 0.3s;
      width: 100%;
    }

    .form-container button:hover {
      background-color: #218838;
    }

    .error {
      color: red;
      margin-bottom: 15px;
      text-align: center;
    }

    #navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 20px;
      background-color: white;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      top: 0;
      z-index: 1000;
    }

    #navbar a {
      text-decoration: none;
      color: #333;
      margin: 0 15px;
      transition: color 0.3s;
    }

    #navbar a:hover {
      color: #ff3366;
    }

    #brand-title {
      font-family: "Playfair Display SC", serif;
      font-size: 25px;
      color: #050505;
    }
  </style>
</head>

<body>
  <header>
    <nav id="navbar">
      <div class="font" id="brand-title"><b>My Brand</div>
      <ul id="navbar-links" style="display: flex; list-style-type: none; margin: 0; padding: 0;">
        <li><a href="index.php">Home</a></li>
        <li><a href="index.php#about">About Me</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="javascript:void(0);" onclick="toggleDarkMode()"> ◑ </a></li>
        <li><a href="kelola_barang.php">Kelola Barang</a></li>
        <li><a href="kelola_akun.php">Kelola Akun</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <div class="form-container">
    <h2>Tambah Barang Baru</h2>

    <?php if (isset($error_message)): ?>
      <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
      <label for="nama_barang">Nama Barang:</label>
      <input type="text" name="nama_barang" id="nama_barang" required>

      <label for="deskripsi">Deskripsi:</label>
      <textarea name="deskripsi" id="deskripsi" required></textarea>

      <label for="harga">Harga:</label>
      <input type="number" name="harga" id="harga" step="0.01" required>

      <label for="gambar">Upload Gambar:</label>
      <input type="file" name="gambar" id="gambar" accept="image/*" required>

      <button type="submit">Tambah Barang</button>
    </form>
  </div>
</body>

</html>