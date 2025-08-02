<?php
session_start();
$order = $_SESSION['last_order'] ?? null;

if (!$order) {
  echo "<p style='text-align:center;padding:50px;'>Tidak ada pesanan yang dikonfirmasi.</p>";
  exit;
}

include('inc/header.php');
?>

<section class="checkout">
  <div class="checkout-title">
    <h2>✅ Pesanan Berhasil!</h2>
  </div>
  <div class="checkout-container">
    <div class="checkout-summary">
      <p><strong>ID Pesanan:</strong> <?= $order['id'] ?></p>
      <p><strong>Total:</strong> Rp<?= number_format($order['total'], 0, ',', '.') ?></p>
      <p><strong>Metode Pembayaran:</strong> <?= $order['payment'] ?></p>

      <?php if ($order['va']): ?>
        <p><strong>Virtual Account:</strong> <span class="va"><?= $order['va'] ?></span></p>
        <p>Silakan transfer ke nomor VA di atas.</p>
      <?php else: ?>
        <p>Silakan siapkan pembayaran saat barang diterima (COD).</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php include('inc/footer.php'); ?>
