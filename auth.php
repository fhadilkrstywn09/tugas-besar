<?php
// Sistem login sederhana berbasis session.
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Role yang boleh login
if (!defined('ROLE_BOLEH')) {
  define('ROLE_BOLEH', ['admin', 'guru', 'siswa']);
}

function sudah_login() {
  return !empty($_SESSION['user_id']) && in_array($_SESSION['role'] ?? '', ROLE_BOLEH, true);
}

// Panggil di bagian paling atas halaman yang harus login
function wajib_login() {
  if (!sudah_login()) {
    header('Location: login.php');
    exit;
  }
}

// Halaman pertama setelah login, sesuai role
function halaman_awal($role) {
  if ($role === 'admin') { return 'daftar_user.php'; }
  if ($role === 'guru')  { return 'daftar_kelas_guru.php'; }
  return 'beranda.php';
}

// Untuk halaman khusus admin (pengelolaan data). Guru/siswa dialihkan ke beranda.
function wajib_admin() {
  wajib_login();
  if (($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: beranda.php');
    exit;
  }
}
