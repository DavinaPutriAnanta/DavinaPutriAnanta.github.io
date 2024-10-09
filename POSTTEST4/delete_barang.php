<?php
include 'koneksi.php';

$id = $_GET['id'];
$sql = "DELETE FROM barang WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
  header('Location: kelola_barang.php');
} else {
  echo "Gagal menghapus barang.";
}
