<?php
require_once('inc/config.php');
include('inc/header.php');
?>

<style>
  .stok-terbatas {
    font-size: 18px;
    font-weight: bold;
    color: red;
    display: inline-block;
    animation: zoomText 2s ease-in-out infinite alternate;
    transform-origin: center;
    z-index: 1000;
    position: relative;
  }

  @keyframes zoomText {
    0% { transform: scale(1); opacity: 1; }
    100% { transform: scale(1.5); opacity: 0.1; }
  }

  .alert-success {
    background: #d4edda;
    color: #155724;
    padding: 12px;
    margin: 20px auto;
    max-width: 600px;
    text-align: center;
    border-radius: 6px;
    font-weight: bold;
    font-size: 1em;
  }

  .hero-text h1 {
    font-size: 2.2em;
    text-align: center;
    margin-bottom: 10px;
    color: #fff;
  }

  .hero-text p.stok-terbatas {
    font-size: 1.1em;
    text-align: center;
  }

  @media (max-width: 768px) {
    .hero-text h1 { font-size: 1.4em; padding: 0 20px; }
    .hero-text p.stok-terbatas { font-size: 0.95em; }
  }
</style>

<?php
if (isset($_SESSION['checkout_success'])) {
  echo '<div class="alert-success">
          ✅ Pesanan berhasil diproses. Terima kasih telah berbelanja di WibuStore!
        </div>';
  unset($_SESSION['checkout_success']);
}
?>

<section class="hero">
  <div class="hero-overlay">
    <div class="hero-text">
      <h1>Temukan koleksi kaos anime eksklusif bergaya premium</h1>
      <p class="stok-terbatas">STOK TERBATAS !!!</p>
    </div>
  </div>
</section>

<img src="<?= BASE_URL ?>assets/img/naruto.png" alt="Naruto" class="naruto-animation">

<?php include('inc/footer.php'); ?>
