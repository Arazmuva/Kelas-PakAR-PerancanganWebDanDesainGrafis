<?php
session_start();

if (isset($_POST['id']) && isset($_POST['qty'])) {
  $id = (int)$_POST['id'];
  $qty = max(1, (int)$_POST['qty']); // Minimal 1

  if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['qty'] = $qty;
    echo "Jumlah diperbarui.";
  } else {
    echo "Produk tidak ditemukan.";
  }
} else {
  echo "Data tidak valid.";
}
