<?php
session_start();
require 'inc/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nama = $_POST['nama'] ?? '';
  $telp = $_POST['telp'] ?? '';
  $alamat = $_POST['alamat'] ?? '';
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';
  $konfirmasi = $_POST['konfirmasi'] ?? '';

  if ($password !== $konfirmasi) {
    $error = "⚠️ Konfirmasi password tidak sesuai.";
  } elseif (strlen($alamat) < 10) {
    $error = "⚠️ Alamat terlalu singkat.";
  } else {
    // Cek apakah username sudah terpakai
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $error = "⚠️ Username sudah digunakan.";
    } else {
      // Simpan user ke database
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $insert = $conn->prepare("INSERT INTO users (nama, telp, alamat, username, password) VALUES (?, ?, ?, ?, ?)");
      $insert->bind_param("sssss", $nama, $telp, $alamat, $username, $hash);

      if ($insert->execute()) {
        $_SESSION['success'] = "✅ Berhasil daftar. Silakan login.";
        header("Location: login.php");
        exit();
      } else {
        $error = "❌ Gagal menyimpan data.";
      }
    }
    $stmt->close();
  }
}
?>

<?php include('inc/header.php'); ?>

<div class="register-container">
  <h2>Daftar Akun Baru</h2>
  <?php if (isset($error)) echo '<div class="alert-error">'.$error.'</div>'; ?>
  <form action="" method="POST" class="register-form">
    <input type="text" name="nama" placeholder="Nama Lengkap" required>
    <input type="text" name="telp" placeholder="Nomor Telepon" required>
    <input type="text" name="alamat" placeholder="Alamat Lengkap" required>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="konfirmasi" placeholder="Konfirmasi Password" required>
    <button type="submit">Daftar</button>
    <p style="text-align:center; margin-top: 10px;">Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
  </form>
</div>

<style>
.register-container {
  max-width: 450px;
  margin: 60px auto;
  padding: 30px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.register-form input {
  width: 100%;
  padding: 12px;
  margin-bottom: 15px;
  border-radius: 6px;
  border: 1px solid #ccc;
}
.register-form button {
  width: 100%;
  padding: 12px;
  background: var(--color-red);
  color: white;
  font-weight: bold;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}
.alert-error {
  background: #ffe0e0;
  color: #b30000;
  padding: 12px;
  margin-bottom: 20px;
  border-radius: 6px;
}
</style>

<?php include('inc/footer.php'); ?>
