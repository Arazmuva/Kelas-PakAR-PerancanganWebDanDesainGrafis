<?php
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

// Ambil data dari POST
$metode = $_POST['metode'] ?? '';
$total = $_POST['total'] ?? 0;
$produk_ids = $_POST['produk_id'] ?? [];
$qty_data = $_POST['qty'] ?? [];

if (!$metode || empty($produk_ids) || empty($qty_data)) {
  echo "<p style='text-align:center; padding: 40px;'>Data tidak lengkap. <a href='cart.php'>Kembali ke Keranjang</a></p>";
  exit();
}

// Simulasi Order ID
$order_id = 'ORD' . strtoupper(substr(uniqid(), -6));

// Simulasi Virtual Account
$va_bank = '';
if (in_array($metode, ['BCA', 'BNI', 'BRI'])) {
  $va_bank = '88' . rand(1000000000, 9999999999);
}

// Simpan order ke session (dummy)
$_SESSION['last_order'] = [
  'order_id' => $order_id,
  'metode' => $metode,
  'total' => $total,
  'produk' => $produk_ids,
  'qty' => $qty_data,
  'va' => $va_bank
];

?>

<?php include('inc/header.php'); ?>

<section class="checkout-container">
  <h2>Rincian Pembayaran</h2>

  <div class="checkout-summary">
    <p><strong>ID Pesanan:</strong> <?= $order_id ?></p>
    <p><strong>Metode Pembayaran:</strong> <?= htmlspecialchars($metode) ?></p>
    <p><strong>Total Pembayaran:</strong> Rp<?= number_format($total, 0, ',', '.') ?></p>

    <?php if ($va_bank): ?>
      <p><strong>Virtual Account:</strong></p>
      <div class="va"><?= $va_bank ?></div>
      <p>Silakan transfer ke VA di atas melalui bank <?= $metode ?>.</p>
    <?php else: ?>
      <p><strong>Metode COD:</strong></p>
      <p>Silakan siapkan uang pas saat barang sampai.</p>
    <?php endif; ?>

    <a href="index.php" class="btn-checkout" style="margin-top: 20px; display:inline-block;">Kembali ke Beranda</a>
  </div>
</section>
// Simpan riwayat order dummy ke session
$order_data = [
  'order_id' => $order_id,
  'username' => $_SESSION['user']['username'],
  'produk' => $produk_ids,
  'qty' => $qty_data,
  'metode' => $metode,
  'total' => $total,
  'va' => $va_bank ?? '-',
  'waktu' => date('Y-m-d H:i:s')
];

$_SESSION['orders'][] = $order_data;

// Juga simpan untuk last_order (jika ingin ditampilkan langsung)
$_SESSION['last_order'] = $order_data;


<?php include('inc/footer.php'); ?>
