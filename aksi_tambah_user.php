<?php
require_once 'koneksi.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  echo "<script>alert('Akses tidak diizinkan');window.location='formall.php';</script>";
  exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$role     = $_POST['role'] ?? '';

if (!in_array($role, ['guru', 'siswa', 'admin'], true)) {
  echo "<script>alert('Role tidak valid');window.location='formall.php';</script>";
  exit;
}

$tujuan = [
  'guru'  => 'daftar_guru.php',
  'siswa' => 'daftar_siswa.php',
  'admin' => 'daftar_user.php',
];

try {
  mysqli_begin_transaction($koneksi);

  // 1. simpan akun ke tabel users
  $stmt = mysqli_prepare($koneksi, "INSERT INTO users (username, password, role, created_at) VALUES (?, ?, ?, NOW())");
  mysqli_stmt_bind_param($stmt, 'sss', $username, $password, $role);
  mysqli_stmt_execute($stmt);
  $user_id = mysqli_insert_id($koneksi);

  // 2. simpan data profil sesuai role
  if ($role == 'guru') {
    $nip  = $_POST['nip'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $jk   = $_POST['jenis_kelamin'] ?? '';
    $stmt = mysqli_prepare($koneksi, "INSERT INTO guru (nip, nama, jenis_kelamin, user_id) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sssi', $nip, $nama, $jk, $user_id);
    mysqli_stmt_execute($stmt);

  } elseif ($role == 'siswa') {
    $nis   = $_POST['nis'] ?? '';
    $nama  = $_POST['nama'] ?? '';
    $kelas = $_POST['kelas'] ?? '';
    $jk    = $_POST['jenis_kelamin'] ?? '';
    $stmt = mysqli_prepare($koneksi, "INSERT INTO siswa (nis, nama, kelas, jenis_kelamin, user_id) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssssi', $nis, $nama, $kelas, $jk, $user_id);
    mysqli_stmt_execute($stmt);
  }

  mysqli_commit($koneksi);
  echo "<script>alert('Berhasil');window.location='" . $tujuan[$role] . "';</script>";

} catch (Throwable $e) {
  mysqli_rollback($koneksi);
  $pesan = addslashes($e->getMessage());
  echo "<script>alert('Gagal menyimpan: " . $pesan . "');window.location='formall.php?jenis=" . $role . "';</script>";
}