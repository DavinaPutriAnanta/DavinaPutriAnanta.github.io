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
  $imageFileType = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

  // Batas ukuran file (2MB)
  $maxFileSize = 2 * 1024 * 1024; // 2MB in bytes
  $fileSize = $_FILES['gambar']['size'];

  // Format penamaan file baru dengan timestamp
  $newFileName = date('Y-m-d H.i.s') . '.' . $imageFileType;
  $target_dir = "storage/";
  $target_file = $target_dir . $newFileName;
  $uploadOk = 1;

  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

  // Cek ukuran file
  if ($fileSize > $maxFileSize) {
    echo "Sorry, your file is too large. Maximum size is 2MB.";
    $uploadOk = 0;
  }

  if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
      $sql = "INSERT INTO barang (nama_barang, deskripsi, harga, gambar) VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssds", $nama_barang, $deskripsi, $harga, $newFileName);
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
    body {
      font-family: Arial, sans-serif;
      background-color: #ffe6f2; /* Light pink background */
      margin: 0;
      display: flex;
      flex-direction: column;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    body.dark-mode {
      background-color: #330033; /* Dark pink background */
      color: #ff99cc; /* Light pink text in dark mode */
    }

    h2 {
      color: #ff3399;
      margin-bottom: 20px;
      text-align: center;
    }

    .form-container {
      background-color: #fff0f5;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(255, 102, 153, 0.2);
      width: 100%;
      max-width: 500px;
      margin: 0 auto;
      margin-top: 40px;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    body.dark-mode .form-container {
      background-color: #4d004d; /* Dark pink form background */
      color: #ff99cc; /* Light pink text in dark mode */
      box-shadow: 0 4px 10px rgba(255, 255, 255, 0.2);
    }

    .form-container label {
      display: block;
      margin: 15px 0 5px;
      color: #ff0066;
      font-weight: bold;
      transition: color 0.3s ease;
    }

    body.dark-mode .form-container label {
      color: #ffccff; /* Lighter text for dark mode */
    }

    .form-container input[type="text"],
    .form-container input[type="number"],
    .form-container textarea,
    .form-container input[type="file"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ff99cc;
      border-radius: 5px;
      font-size: 14px;
      box-sizing: border-box;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    body.dark-mode .form-container input[type="text"],
    body.dark-mode .form-container input[type="number"],
    body.dark-mode .form-container textarea,
    body.dark-mode .form-container input[type="file"] {
      background-color: #660066; /* Dark pink form fields */
      color: #ff99cc; /* Light pink text */
      border: 1px solid #ffccff; /* Light pink border */
    }

    .form-container button {
      background-color: #ff66b2;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 10px;
      transition: background-color 0.3s ease;
      width: 100%;
    }

    body.dark-mode .form-container button {
      background-color: #cc0099; /* Darker pink button in dark mode */
    }

    .form-container button:hover {
      background-color: #ff3399;
    }

    body.dark-mode .form-container button:hover {
      background-color: #ff4da6; /* Hover effect for dark mode */
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
      background-color: #ffb3d9; /* Light pink navbar */
      box-shadow: 0 4px 8px rgba(255, 102, 153, 0.2);
      top: 0;
      z-index: 1000;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    body.dark-mode #navbar {
      background-color: #660066; /* Dark pink navbar */
      box-shadow: 0 4px 8px rgba(255, 255, 255, 0.2);
    }

    #navbar a {
      text-decoration: none;
      color: #ff0066;
      margin: 0 15px;
      transition: color 0.3s ease;
    }

    body.dark-mode #navbar a {
      color: #ffccff; /* Light pink links in dark mode */
    }

    #navbar a:hover {
      color: #ff3399;
    }

    body.dark-mode #navbar a:hover {
      color: #ff66cc;
    }

    #brand-title {
      font-family: "Playfair Display SC", serif;
      font-size: 25px;
      color: #ff3399;
      transition: color 0.3s ease;
    }

    body.dark-mode #brand-title {
      color: #ffccff; /* Brand title in light pink for dark mode */
    }
  </style>
</head>

<body>
  <header>
    <nav id="navbar">
      <div class="font" id="brand-title"><b>My Brand</b></div>
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

      <label for="gambar">Upload Gambar (max 2MB):</label>
      <input type="file" name="gambar" id="gambar" accept="image/*" required>

      <button type="submit">Tambah Barang</button>
    </form>
  </div>

  <script>
    // Function to toggle dark mode
    function toggleDarkMode() {
      document.body.classList.toggle('dark-mode');
    }
  </script>
</body>

</html>
