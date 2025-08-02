<?php
session_start();
include('inc/header.php');
include('inc/koneksi.php'); // <-- gunakan koneksi yang aman dari file ini

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$username = $_SESSION['username'] ?? '';
$user_id = $_SESSION['user_id'];
$nama = $_SESSION['user_nama'] ?? 'Jalal';
$telp = $_SESSION['user_telp'] ?? '08123456789';

// Ambil pesanan dari database
$query = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY id DESC";
$order_result = mysqli_query($conn, $query);
$orders = [];

while ($order = mysqli_fetch_assoc($order_result)) {
  $order_id = $order['id'];
  $item_query = "SELECT * FROM order_items WHERE order_id = '$order_id'";
  $item_result = mysqli_query($conn, $item_query);
  $items = [];
  while ($item = mysqli_fetch_assoc($item_result)) {
    $items[] = $item;
  }
  $order['items'] = $items;
  $orders[] = $order;
}
?>

<section class="profil-section">
  <div class="profil-container">
    <h2 class="profil-title">👤 Profil Saya</h2>

    <!-- Tabs -->
    <div class="profil-tabs">
      <button onclick="toggleTab('updateForm')" class="tab-btn active-tab">✏️ Perbarui Data</button>
      <button onclick="toggleTab('pesananSaya')" class="tab-btn">📦 Pesanan Saya</button>
      <button onclick="toggleTab('lacakForm')" class="tab-btn">📍 Lacak Pengiriman</button>
    </div>

    <!-- Tab: Perbarui Data -->
    <div id="updateForm" class="tab-content active">
      <h3>Perbarui Informasi</h3>
      <form method="POST" action="">
        <p>Nama Pengguna (<?= htmlspecialchars($username ?: '-') ?>)</p>
        <div class="update-form-group" style="flex-direction: column;">
          <input type="text" name="telp_baru" placeholder="Nomor Telepon Baru" required>
          <input type="password" name="pass_baru" placeholder="Password Baru">
          <input type="password" name="konfirmasi" placeholder="Konfirmasi Password">
        </div>
        <button type="submit" class="btn-checkout" style="width: 100%;">Simpan Perubahan</button>
      </form>
    </div>

    <!-- Tab: Pesanan Saya -->
    <div id="pesananSaya" class="tab-content">
      <h3>📦 Pesanan Saya</h3>
      <?php if (empty($orders)): ?>
        <p>Belum ada pesanan.</p>
      <?php else: ?>
        <?php foreach ($orders as $order): ?>
          <div class="order-card">
            <h4>Order ID: <?= htmlspecialchars($order['order_id']) ?></h4>
            <ul>
              <?php foreach ($order['items'] as $item): ?>
                <li><?= $item['qty'] ?>x <?= htmlspecialchars($item['product_name']) ?> (<?= $item['warna'] ?>, <?= $item['ukuran'] ?>)</li>
              <?php endforeach; ?>
            </ul>
            <p>Total: Rp<?= number_format($order['total'], 0, ',', '.') ?></p>
            <p>Metode: <?= strtoupper($order['metode']) ?></p>
            <?php if (!empty($order['va'])): ?>
              <p>VA: <?= $order['va'] ?></p>
            <?php endif; ?>
            <p><strong>Status:</strong> <span class="badge">📦 Dikemas</span></p>

            <!-- Tombol Hapus -->
            <form action="hapus.php" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
              <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
              <button type="submit" class="btn-checkout" style="background:#ccc; color:#000; margin-top:10px;">🗑️ Hapus Pesanan</button>
            </form>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- Tab: Lacak Pengiriman -->
    <div id="lacakForm" class="tab-content">
      <h3>📍 Lacak Pengiriman</h3>
      <form method="GET" action="https://lionparcel.com/#lacak" target="_blank">
        <input type="text" name="order" placeholder="Masukkan Order ID" required style="padding: 12px; width: 100%; border-radius: 8px; margin-bottom: 12px;">
        <button type="submit" class="btn-checkout" style="width: 100%;">Lacak Sekarang</button>
      </form>
    </div>
  </div>
</section>

<script>
function toggleTab(id) {
  const tabs = ['updateForm', 'pesananSaya', 'lacakForm'];
  tabs.forEach(tab => {
    document.getElementById(tab).classList.remove('active');
  });

  const buttons = document.querySelectorAll('.tab-btn');
  buttons.forEach(btn => btn.classList.remove('active-tab'));

  document.getElementById(id).classList.add('active');
  event.target.classList.add('active-tab');
}
</script>

<?php include('inc/footer.php'); ?>
