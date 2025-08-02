<?php
session_start();
require 'inc/db.php';

if (isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows === 1) {
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
      $_SESSION['user_id'] = $user_id;
      $_SESSION['username'] = $username;
      header("Location: checkout.php");
      exit();
    } else {
      $error = "❌ Password salah!";
    }
  } else {
    $error = "⚠️ Akun tidak ditemukan. Silakan melakukan pendaftaran terlebih dahulu.";
  }

  $stmt->close();
}
?>

<?php include('inc/header.php'); ?>

<div class="login-container">
  <h2>Masuk ke WibuStore</h2>
  <?php if (isset($error)) echo '<div class="alert-error">'.$error.'</div>'; ?>
  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  <form action="" method="POST" class="login-form">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Masuk</button>
    <p style="text-align:center; margin-top: 10px;">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
  </form>
</div>

<style>
.login-container {
  max-width: 400px;
  margin: 60px auto;
  padding: 30px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.login-form input {
  width: 100%;
  padding: 12px;
  margin-bottom: 15px;
  border-radius: 6px;
  border: 1px solid #ccc;
}
.login-form button {
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
.alert-success {
  background: #e0ffe8;
  color: #006633;
  padding: 12px;
  margin-bottom: 20px;
  border-radius: 6px;
}
</style>

<?php include('inc/footer.php'); ?>
