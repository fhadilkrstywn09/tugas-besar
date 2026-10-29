<?php
require_once 'koneksi.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function e($v) { return htmlspecialchars((string) $v); }

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);

// ambil data user
$stmt = mysqli_prepare($koneksi, "SELECT * FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$user) {
  echo "<script>alert('User tidak ditemukan');window.location='daftar_user.php';</script>";
  exit;
}

$role = $user['role'];
$halaman = ['siswa' => 'daftar_siswa.php', 'guru' => 'daftar_guru.php'];
$kembali = $halaman[$role] ?? 'daftar_user.php';

// ambil data siswa / guru
$profil = [];
if ($role == 'siswa' || $role == 'guru') {
  $stmt = mysqli_prepare($koneksi, "SELECT * FROM $role WHERE user_id = ?");
  mysqli_stmt_bind_param($stmt, 'i', $id);
  mysqli_stmt_execute($stmt);
  $profil = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt)) ?: [];
}

// proses simpan
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    mysqli_begin_transaction($koneksi);

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($password !== '') {
      $stmt = mysqli_prepare($koneksi, "UPDATE users SET username = ?, password = ? WHERE id = ?");
      mysqli_stmt_bind_param($stmt, 'ssi', $username, $password, $id);
    } else {
      $stmt = mysqli_prepare($koneksi, "UPDATE users SET username = ? WHERE id = ?");
      mysqli_stmt_bind_param($stmt, 'si', $username, $id);
    }
    mysqli_stmt_execute($stmt);

    if ($role == 'guru') {
      $stmt = mysqli_prepare($koneksi, "UPDATE guru SET nip = ?, nama = ?, jenis_kelamin = ? WHERE user_id = ?");
      mysqli_stmt_bind_param($stmt, 'sssi', $_POST['nip'], $_POST['nama'], $_POST['jenis_kelamin'], $id);
      mysqli_stmt_execute($stmt);
    } elseif ($role == 'siswa') {
      $stmt = mysqli_prepare($koneksi, "UPDATE siswa SET nis = ?, nama = ?, kelas = ?, jenis_kelamin = ? WHERE user_id = ?");
      mysqli_stmt_bind_param($stmt, 'ssssi', $_POST['nis'], $_POST['nama'], $_POST['kelas'], $_POST['jenis_kelamin'], $id);
      mysqli_stmt_execute($stmt);
    }

    mysqli_commit($koneksi);
    echo "<script>alert('Data berhasil diubah');window.location='" . $kembali . "';</script>";
    exit;
  } catch (Throwable $ex) {