<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

include 'koneksi.php';

$username = $_SESSION['username'];
$sql = "SELECT * FROM akun WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$akun = $result->fetch_assoc();

$success_message = '';
$error_message = '';

if (isset($_POST['update'])) {
  $newUsername = $_POST['Username'];
  $newEmail = $_POST['Email'];
  $newPassword = $_POST['Password'];

  if (!empty($newPassword)) {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql_update = "UPDATE akun SET username = ?, email = ?, password = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssi", $newUsername, $newEmail, $hashedPassword, $akun['id']);
  } else {
    $sql_update = "UPDATE akun SET username = ?, email = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssi", $newUsername, $newEmail, $akun['id']);
  }

  if ($stmt_update->execute()) {
    $_SESSION['username'] = $newUsername;
    $success_message = "Akun berhasil diperbarui.";
  } else {
    $error_message = "Gagal memperbarui akun. Silakan coba lagi.";
  }
}

if (isset($_POST['delete'])) {
  $sql_delete = "DELETE FROM akun WHERE id = ?";
  $stmt_delete = $conn->prepare($sql_delete);
  $stmt_delete->bind_param("i", $akun['id']);

  if ($stmt_delete->execute()) {
    session_destroy();
    header('Location: login.php');
    exit();
  } else {
    $error_message = "Gagal menghapus akun. Silakan coba lagi.";
  }
}

$brandTitle = "My Brand";
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Akun</title>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display+SC:wght@400;700;900&family=Roboto:wght@400;700&display=swap');

    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
      background-color: white;
      color: black;
      transition: background-color 0.3s, color 0.3s;
    }

    .dark-mode {
      background-color: #121212;
      color: white;
    }

    #navbar {
      display: flex;
      justify-content: space-around;
      align-items: center;
      padding: 15px 0;
      background-color: white;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: auto;
      z-index: 1000;
      transition: background-color 0.3s;
    }

    #navbar a {
      text-decoration: none;
      color: #333;
      margin: 0 15px;
      transition: color 0.3s;
    }

    #navbar a:hover {
      color: #007BFF;
    }

    .dark-mode #navbar {
      background-color: #333;
    }

    .dark-mode #navbar a {
      color: white;
    }

    .font {
      font-family: "Playfair Display SC", serif;
      font-size: 30px;
    }

    .form-container {
      max-width: 400px;
      margin: 100px auto;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 10px;
      background-color: #f9f9f9;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s;
    }

    .form-container input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ddd;
      border-radius: 5px;
      transition: border-color 0.3s;
      box-sizing: border-box;
    }

    .form-container input:focus {
      border-color: #007BFF;
      outline: none;
    }

    .form-container button {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .form-container button:hover {
      background-color: #218838;
    }

    .form-container .delete-button {
      background-color: #dc3545;
      margin-top: 5px;
    }

    .form-container .delete-button:hover {
      background-color: #c82333;
    }

    .dark-mode .form-container {
      background-color: #333;
    }

    .error {
      color: red;
      margin-top: 10px;
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
    <h2>Kelola Akun</h2>

    <form action="" method="post">
      <label for="Username">Username:</label>
      <input type="text" name="Username" id="Username" value="<?php echo htmlspecialchars($akun['username']); ?>" required>

      <label for="Email">Email:</label>
      <input type="email" name="Email" id="Email" value="<?php echo htmlspecialchars($akun['email']); ?>" required>

      <label for="Password">Password (Kosongkan jika tidak ingin mengubah):</label>
      <input type="password" name="Password" id="Password" placeholder="New Password">

      <button type="submit" name="update">Update Akun</button>
    </form>

    <form action="" method="post">
      <button class="delete-button" type="submit" name="delete" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">Hapus Akun</button>
    </form>
  </div>

  <script>
    function toggleDarkMode() {
      document.body.classList.toggle('dark-mode');
    }

    <?php if ($success_message): ?>
      alert('<?php echo $success_message; ?>');
    <?php elseif ($error_message): ?>
      alert('<?php echo $error_message; ?>');
    <?php endif; ?>
  </script>

</body>

</html>