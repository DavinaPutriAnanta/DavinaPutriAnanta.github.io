<?php
session_start();
include 'koneksi.php';

$sql = "SELECT * FROM barang";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Skincare and Cosmetics</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display+SC:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap');

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #ffe6f2; /* Light pink background */
            color: black;
            transition: background-color 0.3s, color 0.3s;
        }

        .dark-mode {
            background-color: #330033; /* Dark pink background */
            color: #ff99cc; /* Light pink text */
        }

        #navbar {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 15px 0;
            background-color: #ffb3d9; /* Light pink navbar */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: background-color 0.3s, color 0.3s;
        }

        body.dark-mode #navbar {
            background-color: #660066; /* Dark pink navbar */
        }

        #navbar a {
            text-decoration: none;
            color: #333;
            margin: 0 15px;
            transition: color 0.3s;
        }

        body.dark-mode #navbar a {
            color: #ffccff; /* Light pink links in dark mode */
        }

        section {
            padding: 70px 20px;
            text-align: center;
        }

        .product-card {
            background-color: #fff; /* White background for product cards */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px;
            width: 300px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        body.dark-mode .product-card {
            background-color: #4d004d; /* Dark pink for product cards */
            color: #ff99cc; /* Light pink text */
        }

        .product-card:hover {
            transform: translateY(-10px);
        }

        .product-card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .add-to-cart {
            background-color: #ff3366;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .font {
            color: #ff3399; /* Pink brand title */
            font-family: "Playfair Display SC", serif;
            font-size: 25px;
        }

        /* Button styles */
        .dark-mode .add-to-cart {
            background-color: #cc0099; /* Darker pink button in dark mode */
        }

        /* Hover effect for buttons */
        .add-to-cart:hover {
            background-color: #ff3399;
        }

        body.dark-mode .add-to-cart:hover {
            background-color: #ff4da6; /* Dark mode hover effect */
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

    <section>
        <h2>Our Products</h2>
        <div style="display: flex; flex-wrap: wrap; justify-content: center;">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="product-card">
                    <img src="storage/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nama_barang']); ?>">
                    <h3><?php echo htmlspecialchars($row['nama_barang']); ?></h3>
                    <p><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                    <p>Harga: Rp<?php echo number_format($row['harga'], 2, ',', '.'); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <script>
        // Function to toggle dark mode
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
