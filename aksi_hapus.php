<?php

require_once 'koneksi.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$id = (int) ($_GET['id'] ?? 0);

// halaman tujuan setelah hapus (hanya yang diizinkan)
$kembali = in_array($_GET['dari'] ?? '', ['daftar_siswa.php', 'daftar_guru.php'], true) ? $_GET['dari'] : 'daftar_user.php';

try {
  if ($id <= 0) {
    throw new Exception('id tidak valid');
  }

  // Hapus user beserta data siswa / guru miliknya (LEFT JOIN: tetap terhapus
  // walaupun user tidak punya baris di tabel siswa/guru, mis. admin)
  $stmt = mysqli_prepare($koneksi, "DELETE users, siswa, guru FROM users LEFT JOIN siswa ON siswa.user_id = users.id LEFT JOIN guru ON guru.user_id = users.id WHERE users.id = ?");
  mysqli_stmt_bind_param($stmt, 'i', $id);
  mysqli_stmt_execute($stmt);

  echo "<script>alert('User Berhasil di hapus');window.location.href='" . $kembali . "';</script>";
} catch (Throwable $e) {
  echo "<script>alert('User Tidak Berhasil di hapus');window.location.href='" . $kembali . "';</script>";
}
