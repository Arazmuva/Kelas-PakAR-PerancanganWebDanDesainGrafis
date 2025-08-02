<?php
session_start();
include('inc/header.php');

// Tambah produk ke keranjang (dari detail.php)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
  $id = (int)$_POST['add'];
  $slug = $_POST['img_slug'] ?? 'default';
  $anime = $_POST['anime'] ?? 'unknown';
  $color = $_POST['color'] ?? 'hitam';
  $image = "$anime/$slug-$color.jpg";

  $_SESSION['cart'][$id] = [
    'id' => $id,
    'name' => $_POST['name'],
    'price' => 75000,
    'img' => $image,
    'anime' => ucfirst($anime),
    'qty' => (int)$_POST['qty'],
    'color' => $color,
    'size' => $_POST['size'] ?? ''
  ];
  header("Location: cart.php");
  exit;
}

// Hapus produk
if (isset($_GET['remove'])) {
  unset($_SESSION['cart'][$_GET['remove']]);
  header("Location: cart.php");
  exit;
}

// Update jumlah & lanjutkan ke checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qty'])) {
  foreach ($_POST['qty'] as $id => $qty) {
    if (isset($_SESSION['cart'][$id])) {
      $_SESSION['cart'][$id]['qty'] = (int)$qty;
    }
  }
  $_SESSION['checkout_items'] = $_POST['checkout_items'] ?? [];
  $_SESSION['updated_qty'] = $_POST['qty'];
  header("Location: checkout.php");
  exit;
}

// Ambil data keranjang
$cart = $_SESSION['cart'] ?? [];
$is_logged_in = isset($_SESSION['user_id']);
?>

<section class="cart-container">
  <h2>🛒 Keranjang Belanja</h2>

  <?php if (empty($cart)): ?>
    <p class="empty-cart">Keranjang kamu masih kosong.</p>
  <?php else: ?>
  <form method="POST">
    <table class="cart-table">
      <thead>
        <tr>
          <th>Pilih</th>
          <th>Produk</th>
          <th>Warna</th>
          <th>Ukuran</th>
          <th>Jumlah</th>
          <th>Harga</th>
          <th>Total</th>
          <th>Hapus</th>
        </tr>
      </thead>
      <tbody>
        <?php $grandTotal = 0; ?>
        <?php foreach ($cart as $id => $item): ?>
        <?php $total = $item['qty'] * $item['price']; $grandTotal += $total; ?>
        <tr>
          <td><input type="checkbox" name="checkout_items[]" value="<?= $id ?>" checked class="cart-checkbox"></td>
          <td>
            <img src="assets/img/anime/<?= $item['img'] ?>" alt="<?= $item['name'] ?>" style="height: 70px;"><br>
            <?= $item['name'] ?><br><span class="badge"><?= $item['anime'] ?></span>
          </td>
          <td><?= ucfirst($item['color']) ?></td>
          <td><?= $item['size'] ?></td>
          <td><input type="number" name="qty[<?= $id ?>]" value="<?= $item['qty'] ?>" min="1" class="cart-qty" onchange="updateTotal()"></td>
          <td>Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
          <td class="item-total">Rp<?= number_format($total, 0, ',', '.') ?></td>
          <td><a href="cart.php?remove=<?= $id ?>" class="btn-remove">🗑️</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="cart-footer">
      <div class="total">Total: <strong>Rp<span id="grandTotal"><?= number_format($grandTotal, 0, ',', '.') ?></span></strong></div>
      <?php if (!$is_logged_in): ?>
        <div class="warning">⚠️ Anda belum login. <a href="login.php">Silakan masuk</a> untuk melanjutkan transaksi.</div>
      <?php endif; ?>
      <button type="submit" class="btn-checkout" <?= $is_logged_in ? '' : 'disabled' ?>>Lanjutkan Checkout</button>
    </div>
  </form>
  <?php endif; ?>
</section>

<script>
function updateTotal() {
  let total = 0;
  document.querySelectorAll('.cart-table tbody tr').forEach(row => {
    const price = parseInt(row.cells[5].innerText.replace(/\D/g, ''));
    const qtyInput = row.querySelector('input[type="number"]');
    const qty = parseInt(qtyInput.value);
    const itemTotal = price * qty;
    row.querySelector('.item-total').innerText = 'Rp' + itemTotal.toLocaleString('id-ID');
    total += itemTotal;
  });
  document.getElementById('grandTotal').innerText = total.toLocaleString('id-ID');
}
</script>

<?php include('inc/footer.php'); ?>
