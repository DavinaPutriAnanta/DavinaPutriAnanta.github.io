<?php
session_start();

include 'koneksi.php';

if (isset($_POST['submit'])) {
    $user = $_POST['Username'];
    $pass = $_POST['Password'];
    $mail = $_POST['Email'];

    // Menggunakan prepared statement untuk mencegah SQL injection
    $sql = "SELECT * FROM akun WHERE username = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $mail);
    $stmt->execute();
    $result = $stmt->get_result();
    $akun = $result->fetch_assoc();

    // Verifikasi password menggunakan password_verify
    if ($akun && password_verify($pass, $akun['password'])) {
        // Jika berhasil login, buat sesi
        $_SESSION['username'] = $akun['username'];
        header("Location: index.php");
        exit();
    } else {
        // Pesan error jika login gagal
        $error_message = "Login failed: Username, password, atau email salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
    <div class="container">
        <div class="login">
            <h2>Login</h2>
            <?php if (isset($error_message)): ?>
                <div class="error"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form action="" method="post">
                <input type="text" placeholder="Username" name="Username" required>
                <input type="password" placeholder="Password" name="Password" required>
                <input type="email" placeholder="Email" name="Email" required>
                <button type="submit" name="submit">SUBMIT</button>
            </form>
            <div class="lupa">
                <a href="register.php"><span>Belum punya akun?</span></a>
            </div>
        </div>
    </div>
</body>
</html>
