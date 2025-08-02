<?php
session_start();
include('inc/header.php');

// Struktur produk
$produk_by_anime = [
  'naruto' => ['naruto-sasuke', 'kakashi', 'itachi', 'madara', 'pain'],
  'onepiece' => ['logo', 'luffy','sanji','team','zoro'],
  'jujutsukaisen' => ['gojo', 'sukuna', 'itadori', 'megumi', 'nobara'],
  'dragonball' => ['goku', 'vegeta', 'piccolo', 'trunks', 'gohan'],
  'sololeveling' => ['sungjinwoo', 'beru', 'igris', 'shadow', 'cha']
];

// Bangun data produk
$products = [];
$counter = 1;
foreach ($produk_by_anime as $anime => $characters) {
  foreach ($characters as $slug) {
    $products[$counter] = [
      'id' => $counter,
      'name' => 'Kaos ' . ucfirst(str_replace('-', ' ', $slug)),
      'img_slug' => $slug,
      'anime' => $anime,
      'price' => 75000,
      'desc' => "Kaos premium bergambar karakter dari anime " . ucfirst($anime)
    ];
    $counter++;
  }
}

$id = $_GET['id'] ?? 0;
if (!isset($products[$id])) {
  echo "<p style='text-align:center; padding: 50px;'>Produk tidak ditemukan.</p>";
  include('inc/footer.php');
  exit;
}
$product = $products[$id];
?>

<section class="detail-section">
  <div class="detail-container">
    <div class="detail-left">
      <img id="productImg" src="assets/img/anime/<?= $product['anime'] ?>/<?= $product['img_slug'] ?>-hitam.jpg" alt="<?= $product['name'] ?>">
      <h2><?= $product['name'] ?></h2>
      <p class="badge"><?= ucfirst($product['anime']) ?></p>
      <p class="price">Rp<?= number_format($product['price'], 0, ',', '.') ?></p>
      <p class="desc"><?= $product['desc']; ?></p>
    </div>
    <div class="detail-right">
      <form action="cart.php" method="POST" class="form-detail">
        <input type="hidden" name="add" value="<?= $product['id'] ?>">
        <input type="hidden" name="img_slug" value="<?= $product['img_slug'] ?>">
        <input type="hidden" name="anime" value="<?= $product['anime'] ?>">
        <input type="hidden" name="name" value="<?= $product['name'] ?>">
        <input type="hidden" name="price" value="<?= $product['price'] ?>">

        <label>Warna:</label>
        <div class="radio-group">
          <label><input type="radio" name="color" value="hitam" checked onchange="changeImage(this)"> Hitam</label>
          <label><input type="radio" name="color" value="putih" onchange="changeImage(this)"> Putih</label>
        </div>

        <label>Ukuran:</label>
        <div class="radio-group">
          <label><input type="radio" name="size" value="S" required> S</label>
          <label><input type="radio" name="size" value="M"> M</label>
          <label><input type="radio" name="size" value="L"> L</label>
          <label><input type="radio" name="size" value="XL"> XL</label>
        </div>

        <label>Jumlah:</label>
        <input type="number" name="qty" value="1" min="1" required>

        <button type="submit" class="btn-checkout">Masukkan ke Keranjang</button>
      </form>
    </div>
  </div>
</section>

<script>
function changeImage(radio) {
  const slug = "<?= $product['img_slug'] ?>";
  const anime = "<?= $product['anime'] ?>";
  const color = radio.value;
  const imgPath = `assets/img/anime/${anime}/${slug}-${color}.jpg`;
  document.getElementById('productImg').src = imgPath;
}
</script>

<?php include('inc/footer.php'); ?>
