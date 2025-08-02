<?php
session_start();
include('inc/header.php');
include('inc/koneksi.php'); // gunakan koneksi global

if (!isset($_SESSION['user_id'])) {
  $_SESSION['redirect_after_login'] = 'checkout.php';
  header("Location: login.php");
  exit();
}

$cart = $_SESSION['cart'] ?? [];
$checkout_items = $_SESSION['checkout_items'] ?? [];
$updated_qty = $_SESSION['updated_qty'] ?? [];

$items = [];
$total = 0;

foreach ($checkout_items as $id) {
  if (isset($cart[$id])) {
    $item = $cart[$id];
    $item['qty'] = $updated_qty[$id] ?? $item['qty'];
    $item['total'] = $item['qty'] * $item['price'];
    $items[] = $item;
    $total += $item['total'];
  }
}

$order_id = 'ORD' . rand(10000, 99999);
$metode = $_POST['metode'] ?? '';
$virtual = ($metode && $metode !== 'cod') ? strtoupper($metode) . rand(1000000000, 9999999999) : '';
$order_saved = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $metode) {
  $user_id = $_SESSION['user_id'];
  $va = ($metode !== 'cod') ? $virtual : null;

  // Simpan order
  $query1 = "INSERT INTO orders (user_id, order_id, total, metode, va) VALUES ('$user_id', '$order_id', '$total', '$metode', '$va')";
  mysqli_query($conn, $query1);
  $order_primary_id = mysqli_insert_id($conn);

  // Simpan item
  foreach ($items as $item) {
    $name  = mysqli_real_escape_string($conn, $item['name']);
    $qty   = (int)$item['qty'];
    $harga = (int)$item['price'];
    $warna = mysqli_real_escape_string($conn, $item['color']);
    $ukuran = mysqli_real_escape_string($conn, $item['size']);

    $query2 = "INSERT INTO order_items (order_id, product_name, qty, harga, warna, ukuran)
               VALUES ('$order_primary_id', '$name', '$qty', '$harga', '$warna', '$ukuran')";
    mysqli_query($conn, $query2);
  }

  foreach ($checkout_items as $id) {
    unset($_SESSION['cart'][$id]);
  }
  unset($_SESSION['checkout_items'], $_SESSION['updated_qty']);

  $order_saved = true;
}
?>

<section class="checkout">
  <h2 class="checkout-title">Checkout</h2>

  <?php if (empty($items)): ?>
    <p style="text-align:center;">Tidak ada produk yang dipilih.</p>
  <?php else: ?>
    <div class="checkout-container">
      <div class="checkout-summary">
        <h3>🧾 Ringkasan Pesanan</h3>
        <ul style="list-style:none; padding:0;">
          <?php foreach ($items as $item): ?>
            <li>
              <strong><?= $item['name'] ?></strong><br>
              <?= $item['qty'] ?> x Rp<?= number_format($item['price'], 0, ',', '.') ?> = 
              <strong>Rp<?= number_format($item['total'], 0, ',', '.') ?></strong>
            </li>
            <hr>
          <?php endforeach; ?>
        </ul>
        <h3>Total: Rp<?= number_format($total, 0, ',', '.') ?></h3>
      </div>

      <div class="checkout-form">
        <h3>Pilih Metode Pembayaran</h3>
        <form method="POST">
          <div class="payment-options">
            <label class="payment-card">
              <input type="radio" name="metode" value="bca" onclick="showVA('BCA')">
              <img src="assets/img/bca.png" alt="BCA">
              <span>Transfer BCA</span>
            </label>
            <label class="payment-card">
              <input type="radio" name="metode" value="bni" onclick="showVA('BNI')">
              <img src="assets/img/bni.png" alt="BNI">
              <span>Transfer BNI</span>
            </label>
            <label class="payment-card">
              <input type="radio" name="metode" value="bri" onclick="showVA('BRI')">
              <img src="assets/img/bri.png" alt="BRI">
              <span>Transfer BRI</span>
            </label>
            <label class="payment-card">
              <input type="radio" name="metode" value="cod" onclick="hideVA()">
              <img src="assets/img/cod.png" alt="COD">
              <span>Bayar di Tempat</span>
            </label>
          </div>

          <div id="vaCard" class="va-card" style="display:none;">
            <h4>Virtual Account</h4>
            <p id="vaBank"></p>
            <div class="va-number" id="vaNumber"></div>
          </div>

          <button type="submit" class="btn-checkout">Konfirmasi Pesanan</button>
        </form>
      </div>
    </div>
  <?php endif; ?>
</section>

<?php if ($order_saved): ?>
<div id="popupSuccess" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.4);display:flex;justify-content:center;align-items:center;z-index:9999;">
  <div style="background:#fff;padding:30px 40px;border-radius:12px;text-align:center;animation:fadeInUp 0.5s ease;">
    <svg width="64" height="64" fill="green" viewBox="0 0 24 24"><path d="M9 16.2l-3.5-3.6L4 14l5 5 11-11-1.4-1.4z"/></svg>
    <h2>Pesanan Berhasil!</h2>
    <p>Order ID: <strong><?= $order_id ?></strong></p>
    <p>Anda akan diarahkan ke beranda dalam 5 detik...</p>
  </div>
</div>
<style>
@keyframes fadeInUp {
  from { transform: translateY(20px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}
</style>
<script>
setTimeout(() => {
  document.getElementById("popupSuccess").style.display = "none";
  window.location.href = 'index.php';
}, 5000);
</script>
<?php endif; ?>

<script>
function showVA(bank) {
  const va = Math.floor(1000000000 + Math.random() * 9000000000);
  document.getElementById("vaCard").style.display = "block";
  document.getElementById("vaBank").innerText = "Bank " + bank;
  document.getElementById("vaNumber").innerText = bank + " " + va;
}
function hideVA() {
  document.getElementById("vaCard").style.display = "none";
  document.getElementById("vaBank").innerText = "";
  document.getElementById("vaNumber").innerText = "";
}
</script>

<?php include('inc/footer.php'); ?>
