<?php include('inc/header.php'); ?>

<section class="contact-section">
  <div class="contact-container">
    <h2>📍 Hubungi Kami</h2>
    <p class="contact-subtext">Silakan hubungi kami atau kunjungi kantor kami untuk informasi lebih lanjut.</p>

    <div class="contact-grid">
      <div class="contact-info">
        <h3>🏢 Lokasi Office</h3>
        <p>WibuStore Headquarters</p>
        <p>Jl. Anime Lovers No. 404</p>
        <p>Cisoka, Kabupaten Tangerang</p>
        <p>Banten, Indonesia</p>
      </div>

      <div class="contact-links">
        <h3>📲 Kontak & Sosial Media</h3>
        <ul>
          <li><a href="https://wa.me/6281234567890" target="_blank">💬 WhatsApp: +62 812-3456-7890</a></li>
          <li><a href="https://instagram.com/wibustore.id" target="_blank">📸 Instagram: @wibustore.id</a></li>
          <li><a href="https://facebook.com/wibustore.id" target="_blank">📘 Facebook: WibuStore ID</a></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<style>
.contact-section {
  padding: 60px 20px;
  background: var(--color-bg);
}
.contact-container {
  max-width: 1000px;
  margin: auto;
  background: #fff;
  border-radius: 12px;
  padding: 40px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
body.dark .contact-container {
  background: #1c1c1c;
  color: #fff;
}
.contact-container h2 {
  text-align: center;
  margin-bottom: 10px;
  font-size: 2em;
}
.contact-subtext {
  text-align: center;
  margin-bottom: 40px;
  font-size: 1.1em;
  color: #666;
}
body.dark .contact-subtext {
  color: #ccc;
}
.contact-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 40px;
  justify-content: space-between;
}
.contact-info, .contact-links {
  flex: 1 1 45%;
}
.contact-info h3, .contact-links h3 {
  margin-bottom: 10px;
  font-size: 1.4em;
  color: var(--color-red);
}
.contact-links ul {
  list-style: none;
  padding: 0;
}
.contact-links li {
  margin-bottom: 10px;
}
.contact-links a {
  color: var(--color-black);
  text-decoration: none;
  font-weight: bold;
  transition: color 0.2s;
}
.contact-links a:hover {
  color: var(--color-red);
}
body.dark .contact-links a {
  color: #ddd;
}
body.dark .contact-links a:hover {
  color: var(--color-red);
}

/* Responsive */
@media (max-width: 768px) {
  .contact-grid {
    flex-direction: column;
  }
}
</style>

<?php include('inc/footer.php'); ?>
