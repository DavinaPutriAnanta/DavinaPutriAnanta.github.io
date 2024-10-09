<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $user = $_POST['Username'];
    $pass = $_POST['Password'];
    $mail = $_POST['Email'];

    if (empty($user) || empty($pass) || empty($mail)) {
        $error_message = "Semua field harus diisi.";
    } else {
        $sql_check = "SELECT * FROM akun WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $mail);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $error_message = "Email sudah terdaftar. Silakan gunakan email lain.";
        } else {
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

            $sql = "INSERT INTO akun (username, password, email) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $user, $hashed_password, $mail);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Terjadi kesalahan. Coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
    <div class="container">
        <div class="login">
            <h2>Register</h2>
            <?php if (isset($error_message)): ?>
                <div class="error"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form action="" method="post">
                <input type="text" placeholder="Username" name="Username" required><br>
                <input type="password" placeholder="Password" name="Password" required><br>
                <input type="email" placeholder="Email" name="Email" required><br>
                <button type="submit" name="submit">SUBMIT</button>
            </form>
            <div class="lupa">
                <a href="login.php"><span>Sudah punya akun?</span></a>
            </div>
        </div>
    </div>
</body>
</html>
