
# 👕 WibuStore — Kaos Anime Premium Native PHP

WibuStore adalah website e-commerce berbasis **native PHP (tanpa framework/WordPress)** yang dibuat untuk menjual **kaos anime premium** seperti Naruto, One Piece, Jujutsu Kaisen, Dragon Ball, dan Solo Leveling. Situs ini dibangun dengan struktur **modular, dinamis, dan modern**, lengkap dengan fitur pencarian, keranjang, checkout, dan pelacakan pengiriman.

---

## 🚀 Fitur Utama

### ✅ Tampilan Modern & Responsif
- Desain kekinian dengan gaya minimalis dan **mode gelap**
- Responsif di **mobile & desktop**
- Efek animasi Naruto bergerak 🌀

### 🛍️ Produk & Kategori
- Produk ditampilkan berdasarkan **kategori anime** (Naruto, One Piece, dll.)
- Gambar produk tersedia dalam **2 warna (Hitam & Putih)**
- Halaman detail produk dengan opsi warna, ukuran, dan jumlah

### 🔎 Fitur Pencarian
- Pencarian realtime berdasarkan nama produk atau nama anime
- Jika tidak ditemukan, tampilkan notifikasi: ❌ "Produk tidak tersedia"

### 🧺 Keranjang Belanja
- Sistem keranjang (session-based)
- Fitur tambah jumlah, hapus produk, checkbox untuk memilih saat checkout
- Perhitungan otomatis total harga (dengan live update saat ubah qty)

### 🔐 Sistem Login & Register
- Registrasi & login menggunakan database `users` (phpMyAdmin)
- Setelah login:
  - Tombol masuk/daftar disembunyikan
  - Checkout hanya bisa dilakukan jika sudah login

### 💳 Checkout & Pembayaran
- Pilihan metode:
  - Transfer Bank (BCA, BNI, BRI)
  - COD (Bayar di Tempat)
- Virtual Account dummy muncul sesuai bank yang dipilih
- Konfirmasi pesanan akan:
  - Menampilkan **Order ID**
  - Menyimpan pesanan ke `$_SESSION['orders']`
  - Memunculkan notifikasi ✅ dan redirect ke beranda otomatis

### 👤 Halaman Profil
- Tab "Perbarui Data" → untuk update nomor HP dan password
- Tab "Pesanan Saya" → menampilkan riwayat order:
  - Status pesanan: 📦 Dikemas → 🚚 Dikirim → 📬 Diterima
  - Status berubah saat klik ➡️
- Tab "Lacak Pengiriman" → terhubung ke **LionParcel**

---

## 🧾 Struktur Folder

```
/assets/
  └── img/         → gambar produk, logo bank, ikon naruto
/inc/
  └── header.php   → komponen navigasi + pencarian
index.php          → halaman beranda (hero + stok terbatas)
product.php        → daftar produk berdasarkan kategori
detail.php         → halaman detail produk
cart.php           → keranjang belanja
checkout.php       → konfirmasi pesanan
login.php          → login pengguna
register.php       → registrasi akun
profil.php         → profil user (riwayat, edit data, lacak)
style.css          → seluruh styling modern + responsive
```

---

## 🛠️ Teknologi yang Digunakan

- PHP Native (tanpa framework)
- HTML5, CSS3, JavaScript
- Session & $_POST untuk manajemen data user
- PHPMyAdmin (database `users` untuk login/register)
- Dummy data produk (tanpa DB)
- Animasi CSS & keyframe

---

## 📦 Catatan Developer

✔️ Project ini menggunakan **struktur session-based**  
✔️ Checkout akan otomatis menghapus item dari keranjang  
✔️ Semua produk dan gambar sudah dikelompokkan berdasarkan anime  
✔️ Tidak menggunakan JavaScript library eksternal

---

## ✨ Demo Animasi

- Efek **Naruto bergerak menyilang**
- Teks **"STOK TERBATAS !!!"** zoom in-out berulang
- Tombol checkout dinamis & elegan

---

## 🧑‍💻 Developer

Website ini dikembangkan dan dikustomisasi penuh bersama **user** sesuai arahan secara iteratif:  
✅ UI/UX modern  
✅ Tanpa merusak struktur  
✅ Perubahan hanya dilakukan bila diminta

---

## 📌 TODO (Opsional untuk Pengembangan Lanjut)

- Integrasi database untuk semua produk dan pesanan
- Panel admin (tambah/edit produk)
- Konfirmasi email
- Integrasi WhatsApp checkout otomatis

---

> Dibuat sepenuh hati 💖 untuk Wibu sejati yang ingin tampil stylish 😎
