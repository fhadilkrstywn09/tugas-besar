<?php
require_once 'koneksi.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function selesai($pesan, $tujuan = 'daftar_mengajar.php') {
    echo "<script>alert('" . addslashes($pesan) . "'); window.location.href='$tujuan';</script>";
    exit;
}
function jumlah($k, $sql, $tipe, $param) {
    $s = mysqli_prepare($k, $sql);
    mysqli_stmt_bind_param($s, $tipe, $param);
    mysqli_stmt_execute($s);
    $b = mysqli_fetch_row(mysqli_stmt_get_result($s));
    return (int) $b[0];
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') { selesai('Akses tidak diizinkan'); }

$kelas   = trim($_POST['kelas'] ?? '');
$guru_id = (int) ($_POST['guru_id'] ?? 0);
if ($kelas === '' || $guru_id <= 0) { selesai('Data belum lengkap', 'form_tambah_mengajar.php'); }

try {
    if (jumlah($koneksi, "SELECT COUNT(*) FROM mapel WHERE guru_id = ?", 'i', $guru_id) == 0) {
        selesai('Guru ini belum punya mata pelajaran. Tambahkan mapel untuk guru ini dulu.', 'form_tambah_mengajar.php');
    }
    if (jumlah($koneksi, "SELECT COUNT(*) FROM siswa WHERE kelas = ?", 's', $kelas) == 0) {
        selesai('Kelas ini belum punya siswa.', 'form_tambah_mengajar.php');
    }

    // Hubungkan semua siswa di kelas itu dengan semua mapel milik guru tersebut (yang sudah ada dilewati)
    mysqli_begin_transaction($koneksi);

    // id diisi manual karena kolom id di tabel mengajar belum AUTO_INCREMENT
    $r = mysqli_query($koneksi, "SELECT COALESCE(MAX(id), 0) FROM mengajar FOR UPDATE");
    $id_berikut = (int) mysqli_fetch_row($r)[0];

    $cari = mysqli_prepare($koneksi, "SELECT mp.id, s.id
        FROM mapel mp
        JOIN siswa s ON s.kelas = ?
        WHERE mp.guru_id = ?
          AND NOT EXISTS (SELECT 1 FROM mengajar m WHERE m.mapel_id = mp.id AND m.siswa_id = s.id)");
    mysqli_stmt_bind_param($cari, 'si', $kelas, $guru_id);
    mysqli_stmt_execute($cari);
    $pasangan = mysqli_fetch_all(mysqli_stmt_get_result($cari));

    if (count($pasangan) == 0) {
        mysqli_rollback($koneksi);
        selesai('Guru ini sudah mengajar di kelas tersebut.', 'form_tambah_mengajar.php');
    }

    $ins = mysqli_prepare($koneksi, "INSERT INTO mengajar (id, mapel_id, siswa_id) VALUES (?, ?, ?)");
    foreach ($pasangan as [$mapel_id, $siswa_id]) {
        $id_berikut++;
        mysqli_stmt_bind_param($ins, 'iii', $id_berikut, $mapel_id, $siswa_id);
        mysqli_stmt_execute($ins);
    }
    mysqli_commit($koneksi);

    selesai('Data mengajar berhasil ditambahkan');
} catch (Throwable $e) {
    @mysqli_rollback($koneksi);
    selesai('Data mengajar gagal ditambahkan: ' . $e->getMessage(), 'form_tambah_mengajar.php');
}
