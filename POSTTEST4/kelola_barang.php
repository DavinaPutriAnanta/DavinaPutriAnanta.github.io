<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

$sql = "SELECT * FROM barang";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Barang</title>
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
      text-align: center;
      margin-top: 20px;
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

    .product-table {
      width: 90%;
      margin: 20px auto;
      border-collapse: collapse;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      background-color: white;
    }

    .product-table th,
    .product-table td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: center;
      /* Rata tengah */
    }

    .product-table th {
      background-color: #f2f2f2;
    }

    .action-buttons a {
      margin: 5px;
      padding: 5px 10px;
      background-color: #007bff;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    .action-buttons a:hover {
      background-color: #0056b3;
      /* Warna saat hover */
    }

    .action-buttons a.delete {
      background-color: #dc3545;
    }

    .action-buttons a.delete:hover {
      background-color: #c82333;
      /* Warna saat hover untuk delete */
    }

    .product-image {
      width: 100px;
      height: auto;
    }

    /* Styling untuk tombol tambah barang */
    .add-button {
      display: block;
      width: 150px;
      margin: 20px auto;
      padding: 10px;
      text-align: center;
      background-color: #28a745;
      color: white;
      border-radius: 5px;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .add-button:hover {
      background-color: #218838;
    }
  </style>
</head>

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

<h2>Kelola Barang</h2>
<a href="tambah_barang.php" class="add-button">Tambah Barang</a>
<table class="product-table">
  <tr>
    <th>Nama Barang</th>
    <th>Deskripsi</th>
    <th>Harga</th>
    <th>Gambar</th>
    <th>Aksi</th>
  </tr>
  <?php while ($row = mysqli_fetch_assoc($result)) : ?>
    <tr>
      <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
      <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
      <td><?php echo htmlspecialchars($row['harga']); ?></td>
      <td><img src="storage/<?php echo htmlspecialchars($row['gambar']); ?>" class="product-image" alt="Gambar <?php echo htmlspecialchars($row['nama_barang']); ?>"></td>
      <td class="action-buttons">
        <a href="edit_barang.php?id=<?php echo $row['id']; ?>">Edit</a>
        <a href="delete_barang.php?id=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Yakin ingin menghapus barang ini?')">Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>
</body>

</html>