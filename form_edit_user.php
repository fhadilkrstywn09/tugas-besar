<?php
require_once 'koneksi.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
function e($v) { return htmlspecialchars((string) $v); }
function q($k, $sql, $tipe, ...$p) {
  $s = mysqli_prepare($k, $sql);
  mysqli_stmt_bind_param($s, $tipe, ...$p);
  mysqli_stmt_execute($s);
  return $s;
}
function satu($s) { return mysqli_fetch_assoc(mysqli_stmt_get_result($s)); }

$id = (int) ($_GET['id'] ?? 0);
$user = satu(q($koneksi, "SELECT * FROM users WHERE id = ?", 'i', $id));
if (!$user) { echo "<script>alert('User tidak ditemukan');window.location='daftar_user.php';</script>"; exit; }
$role = $user['role'];
$kembali = ['siswa' => 'daftar_siswa.php', 'guru' => 'daftar_guru.php'][$role] ?? 'daftar_user.php';

// data profil: guru -> tabel guru, siswa -> tabel siswa, admin -> tidak ada
$profil = [];
if ($role == 'guru' || $role == 'siswa') {
  $profil = satu(q($koneksi, "SELECT * FROM $role WHERE user_id = ?", 'i', $id)) ?: [];
}
$semua = ['guru' => ['nip' => 'NIP', 'nama' => 'Nama Lengkap'], 'siswa' => ['nis' => 'NIS', 'nama' => 'Nama Lengkap', 'kelas' => 'Kelas']];
$isi = $semua[$role] ?? [];
$jk = $role != 'admin';
$aksi = ['siswa' => 'editsiswa', 'guru' => 'editguru'][$role] ?? 'edituser';
$error = '';

include 'navbar.php';
include 'edit_tampil.php';
include 'footer.php';
