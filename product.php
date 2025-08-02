<?php include('inc/header.php'); ?>

<?php
// Fitur pencarian
$q = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : '';
$filtered = [];
$products = [];
$counter = 1;

// Struktur produk dengan karakter
$produk_by_anime = [
  'naruto' => ['naruto-sasuke', 'kakashi', 'itachi', 'madara', 'pain'],
  'onepiece' => ['logo', 'luffy','sanji','team','zoro'],
  'jujutsukaisen' => ['gojo', 'sukuna', 'itadori', 'megumi', 'nobara'],
  'dragonball' => ['goku', 'vegeta', 'piccolo', 'trunks', 'gohan'],
  'sololeveling' => ['sungjinwoo', 'beru', 'igris', 'shadow', 'cha']
];

foreach ($produk_by_anime as $anime => $characters) {
  foreach ($characters as $slug) {
    $name = "Kaos " . ucfirst(str_replace('-', ' ', $slug));
    $products[] = [
      'id' => $counter++,
      'name' => $name,
      'anime' => $anime,
      'img' => "$anime/$slug-hitam.jpg", // default gambar hitam
      'price' => 75000
    ];
  }
}

// Filter pencarian
if ($q !== '') {
  foreach ($products as $p) {
    if (strpos(strtolower($p['name']), $q) !== false || strpos(strtolower($p['anime']), $q) !== false) {
      $filtered[] = $p;
    }
  }
} else {
  $filtered = $products;
}
?>

<section class="produk">
  <h2 class="produk-title">
    <?= $q ? 'Hasil pencarian: "' . htmlspecialchars($q) . '"' : 'Temukan anime favoritmu !' ?>
  </h2>

  <?php if ($q && empty($filtered)): ?>
    <p style="text-align:center; font-size: 1.2em; padding: 40px;">❌ Produk tidak tersedia.</p>
  <?php else: ?>

  <!-- Tombol filter -->
  <?php if (!$q): ?>
  <div class="filter-bar">
    <button class="filter-btn active" data-filter="all">Semua Anime</button>
    <?php foreach (array_keys($produk_by_anime) as $anime): ?>
      <button class="filter-btn" data-filter="<?= $anime ?>"><?= ucfirst($anime) ?></button>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <!-- Produk -->
  <div class="product-grid">
    <?php foreach ($filtered as $p): ?>
      <div class="product-card" data-anime="<?= $p['anime'] ?>">
        <img src="assets/img/anime/<?= $p['img'] ?>" alt="<?= $p['name'] ?>">
        <div class="info">
          <h3><?= $p['name'] ?></h3>
          <span class="badge"><?= ucfirst($p['anime']) ?></span>
          <p class="price">Rp<?= number_format($p['price'], 0, ',', '.') ?></p>
          <a href="detail.php?id=<?= $p['id'] ?>" class="btn">Lihat Detail</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>

<?php include('inc/footer.php'); ?>

<script>
  const filterButtons = document.querySelectorAll('.filter-btn');
  const productCards = document.querySelectorAll('.product-card');

  filterButtons.forEach(button => {
    button.addEventListener('click', () => {
      const filter = button.dataset.filter;
      productCards.forEach(card => {
        const anime = card.dataset.anime;
        card.style.display = (filter === 'all' || anime === filter) ? 'block' : 'none';
      });

      filterButtons.forEach(btn => btn.classList.remove('active'));
      button.classList.add('active');
    });
  });
</script>
