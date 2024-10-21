<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$searchQuery = "";
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search_query'];
    $searchQuery = mysqli_real_escape_string($conn, $searchQuery); 
    $sql = "SELECT * FROM barang WHERE nama_barang LIKE '%$searchQuery%'";
} else {
    $sql = "SELECT * FROM barang";
}

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
            background-color: #ffe6f2; 
            margin: 0;
            display: flex;
            flex-direction: column;
            transition: background-color 0.3s, color 0.3s;
        }

        .dark-mode {
            background-color: #330033; 
            color: #ff99cc; 
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
            background-color: #ffb3d9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            top: 0;
            z-index: 1000;
            transition: background-color 0.3s;
        }

        body.dark-mode #navbar {
            background-color: #660066; 
        }

        #navbar a {
            text-decoration: none;
            color: #333;
            margin: 0 15px;
            transition: color 0.3s;
        }

        body.dark-mode #navbar a {
            color: #ffccff; 
        }

        #navbar a:hover {
            color: #ff3366;
        }

        .search-form {
            text-align: center;
            margin: 20px;
        }

        .search-form input[type="text"] {
            padding: 10px;
            width: 300px;
        }

        .product-table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
            transition: background-color 0.3s, color 0.3s;
        }

        body.dark-mode .product-table {
            background-color: #4d004d; 
            color: #ff99cc; 
        }

        .product-table th,
        .product-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        .product-table th {
            background-color: #f2f2f2;
        }

        body.dark-mode .product-table th {
            background-color: #663399; 
        }

        .action-buttons a {
            margin: 5px;
            padding: 5px 10px;
            background-color: #ff3366; 
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        body.dark-mode .action-buttons a {
            background-color: #dc3545; 
        }

        .action-buttons a:hover {
            background-color: #e63946;
        }

        body.dark-mode .action-buttons a:hover {
            background-color: #c82333; 
        }

        .product-image {
            width: 100px;
            height: auto;
        }
        .add-button {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #ff3366; 
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .add-button:hover {
            background-color: #e63946;
        }

        body.dark-mode .add-button {
            background-color: #cc0099; 
        }

        body.dark-mode .add-button:hover {
            background-color: #ff4da6;
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

<h2>Kelola Barang</h2>
<div class="search-form">
    <form method="post" action="">
        <input type="text" name="search_query" placeholder="Cari barang..." value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit" name="search">Cari</button>
    </form>
</div>

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
                <a href="delete_barang.php?id=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Yakin ingin menghapus barang ini?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<script>
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        var navbarLinks = document.querySelectorAll('#navbar a');
        navbarLinks.forEach(link => {
            link.classList.toggle('dark-mode');
        });
    }
</script>

</body>

</html>
