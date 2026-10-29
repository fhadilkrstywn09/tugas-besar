<?php
require_once 'auth.php';
if (sudah_login()) { header('Location: ' . halaman_awal($_SESSION['role'])); exit; }

$error = $_SESSION['login_error'] ?? '';
$username_lama = $_SESSION['login_username'] ?? '';
unset($_SESSION['login_error'], $_SESSION['login_username']);
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body class="bg-body-tertiary">
  <div class="container min-vh-100 d-flex align-items-center justify-content-center px-3">
    <div class="card shadow border-0 w-100" style="max-width: 440px;">
      <div class="card-body p-4">
        <h3 class="text-center mb-4">Login</h3>

        <?php if ($error !== '') { ?>
          <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
        <?php } ?>

        <form method="POST" action="aksi_login.php">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" value="<?= htmlspecialchars($username_lama) ?>" autocomplete="username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <p class="text-center mt-3 mb-0">Belum memiliki akun? <a href="register.php" class="text-decoration-none">Register</a></p>
      </div>
    </div>
  </div>
</body>
</html>
