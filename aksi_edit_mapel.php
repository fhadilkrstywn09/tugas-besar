<?php
require_once 'koneksi.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function selesai($pesan) {
    echo "<script>alert('" . addslashes($pesan) . "'); window.location.href='daftar_mapel.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') { selesai('Akses tidak diizinkan'); }

$id      = (int) ($_POST['id'] ?? 0);
$kode    = trim($_POST['kode'] ?? '');
$nama    = trim($_POST['nama'] ?? '');
$guru_id = (int) ($_POST['guru_id'] ?? 0);
if ($id <= 0 || $kode === '' || $nama === '' || $guru_id <= 0) { selesai('Data belum lengkap'); }

try {
    // kode + guru yang sama tidak boleh dobel (selain data ini sendiri)
    $cek = mysqli_prepare($koneksi, "SELECT 1 FROM mapel WHERE kode_mapel = ? AND guru_id = ? AND id <> ? LIMIT 1");
    mysqli_stmt_bind_param($cek, 'sii', $kode, $guru_id, $id);
    mysqli_stmt_execute($cek);
    if (mysqli_num_rows(mysqli_stmt_get_result($cek)) > 0) {
        selesai("Mapel $kode untuk guru tersebut sudah ada");
    }

    $stmt = mysqli_prepare($koneksi, "UPDATE mapel SET kode_mapel = ?, `nama-mapel` = ?, guru_id = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'ssii', $kode, $nama, $guru_id, $id);
    mysqli_stmt_execute($stmt);

    selesai('Data mapel berhasil diubah');
} catch (Throwable $e) {
    selesai('Data mapel gagal diubah: ' . $e->getMessage());
}
