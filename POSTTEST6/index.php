<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$brandTitle = "My Brand";
$aboutMe = "Davina Putri Ananta";
$studentID = "2309106002";
$assignment = "POSTTEST 3";
$course = "Pemrograman Web";

$heroImage = "cewe2.jpg";
$productImage = "lame.jpg";
$productTitle = "La Mer's";
$productDescription = "Experience La Mer's best skincare. Discover skincare-infused face makeup, our best moisturizers and unique treatments to unlock skin's radiant rejuvenation.";

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Skincare and Cosmetics</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display+SC:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap');

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: white;
            color: black;
            transition: background-color 0.3s, color 0.3s;
        }

        .dark-mode {
            background-color: black;
            color: white;
        }

        #navbar {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 15px 0;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        #navbar a {
            text-decoration: none;
            color: #333;
            margin: 0 15px;
        }

        .hero {
            background-image: url('<?php echo $heroImage; ?>');
            height: 100vh;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }

        .hero h1 {
            font-size: 3em;
        }

        section {
            padding: 70px 20px;
            text-align: center;
        }

        .font {
            color: #333;
            font-family: "Playfair Display SC", serif;
            font-size: 25px;
        }
    </style>
</head>

<body>
    <header>
        <nav id="navbar">
            <div class="font" id="brand-title"><b><?php echo $brandTitle; ?></b></div>
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

    <div class="hero">
        <h1>Selamat Datang di <?php echo $brandTitle; ?></h1>
    </div>

    <section id="about">
        <h2>Tentang Saya</h2>
        <p><b><?php echo $aboutMe; ?></b></p>
        <p><?php echo $studentID; ?></p>
        <p><?php echo $assignment; ?></p>
        <p><?php echo $course; ?></p>
        <p>Selamat datang, <b><?php echo htmlspecialchars($username); ?></b>!</p>
    </section>

    <section>
        <h2>Produk Unggulan</h2>
        <p>Temukan produk kami di bawah ini:</p>
        <div>
            <img src="<?php echo $productImage; ?>" alt="Produk Unggulan" style="width: 300px; height: auto;">
            <h3><?php echo $productTitle; ?></h3>
            <p><?php echo $productDescription; ?></p>
            <p>Temukan Produk skincare Luxury lainnya di website kami!</p>
            <a href="products.html">Lihat Semua Produk</a>
        </div>
    </section>

    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }
    </script>
</body>

</html>