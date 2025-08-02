<?php
session_start();
include('inc/koneksi.php'); // Gunakan koneksi dari file terpusat

// Validasi login dan input
if (!isset($_SESSION['user_id']) || !isset($_POST['order_id'])) {
  header("Location: profil.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$order_id = intval($_POST['order_id']); // Pastikan angka untuk keamanan

// Periksa apakah order milik user yang login
$cek = mysqli_prepare($conn, "SELECT id FROM orders WHERE id = ? AND user_id = ?");
mysqli_stmt_bind_param($cek, 'ii', $order_id, $user_id);
mysqli_stmt_execute($cek);
mysqli_stmt_store_result($cek);

if (mysqli_stmt_num_rows($cek) > 0) {
  // Hapus item pesanan dulu (hindari error foreign key jika ada)
  $hapus_items = mysqli_prepare($conn, "DELETE FROM order_items WHERE order_id = ?");
  mysqli_stmt_bind_param($hapus_items, 'i', $order_id);
  mysqli_stmt_execute($hapus_items);

  // Hapus order
  $hapus_order = mysqli_prepare($conn, "DELETE FROM orders WHERE id = ?");
  mysqli_stmt_bind_param($hapus_order, 'i', $order_id);
  mysqli_stmt_execute($hapus_order);

  // Kembali ke profil dengan notifikasi
  header("Location: profil.php?hapus=berhasil");
  exit();
} else {
  // Jika pesanan tidak ditemukan atau bukan milik user
  header("Location: profil.php?hapus=gagal");
  exit();
}
?>
