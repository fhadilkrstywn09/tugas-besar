<?php
require_once 'auth.php';
require_once 'koneksi.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function gagal($pesan, $username = '') {
  $_SESSION['login_error'] = $pesan;
  $_SESSION['login_username'] = $username;
  header('Location: login.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  header('Location: login.php');
  exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Batasi percobaan: 5x salah -> tunggu 60 detik
if (($_SESSION['gagal_login'] ?? 0) >= 5) {
  $sisa = 60 - (time() - ($_SESSION['gagal_waktu'] ?? 0));
  if ($sisa > 0) {
    gagal("Terlalu banyak percobaan. Coba lagi dalam $sisa detik.", $username);
  }
  $_SESSION['gagal_login'] = 0;
}

try {
  $stmt = mysqli_prepare($koneksi, "SELECT id, username, password, role FROM users WHERE username = ? LIMIT 1");
  mysqli_stmt_bind_param($stmt, 's', $username);
  mysqli_stmt_execute($stmt);
  $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
} catch (Throwable $e) {
  gagal('Terjadi kesalahan pada server. Coba lagi.', $username);
}

// Cek password: mendukung hash (password_hash) dan password lama yang masih teks biasa
$cocok = false;
if ($user) {
  $tersimpan = (string) $user['password'];
  if (password_get_info($tersimpan)['algo']) {
    $cocok = password_verify($password, $tersimpan);
  } else {
    $cocok = hash_equals($tersimpan, $password);
  }
} else {
  password_verify($password, '$2y$10$usesomesillystringforsaleuseaaaaaaaaaaaaaaaaaaaaaaaaaa'); // samakan waktu proses
}

if (!$cocok) {
  $_SESSION['gagal_login'] = ($_SESSION['gagal_login'] ?? 0) + 1;
  $_SESSION['gagal_waktu'] = time();
  gagal('Username atau password salah.', $username);
}

if (!in_array($user['role'], ROLE_BOLEH, true)) {
  gagal('Akun ini tidak memiliki akses ke sistem.', $username);
}

// Upgrade otomatis: password lama (teks biasa) diubah jadi hash
if (!password_get_info((string) $user['password'])['algo'] || password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
  try {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $up = mysqli_prepare($koneksi, "UPDATE users SET password = ? WHERE id = ?");
    mysqli_stmt_bind_param($up, 'si', $hash, $user['id']);
    mysqli_stmt_execute($up);
  } catch (Throwable $e) { /* login tetap lanjut */ }
}

// Ambil nama untuk ditampilkan di navbar
$nama = $user['role'] == 'admin' ? 'Admin' : $user['username'];
foreach (['guru', 'siswa'] as $tabel) {
  if ($user['role'] == $tabel) {
    $s = mysqli_prepare($koneksi, "SELECT nama FROM $tabel WHERE user_id = ? LIMIT 1");
    mysqli_stmt_bind_param($s, 'i', $user['id']);
    mysqli_stmt_execute($s);
    $baris = mysqli_fetch_assoc(mysqli_stmt_get_result($s));
    if ($baris && $baris['nama'] !== '') { $nama = $baris['nama']; }
  }
}

session_regenerate_id(true);
$_SESSION['user_id']  = (int) $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role']     = $user['role'];
$_SESSION['nama']     = $nama;
unset($_SESSION['gagal_login'], $_SESSION['gagal_waktu']);

header('Location: ' . halaman_awal($user['role']));
exit;
