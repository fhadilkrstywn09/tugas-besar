<?php
require_once 'auth.php';
wajib_login();
if ($_SESSION['role'] !== 'siswa') { header('Location: ' . halaman_awal($_SESSION['role'])); exit; }
require_once 'koneksi.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function ambil($k, $sql, $tipe, $param) {
  $s = mysqli_prepare($k, $sql);
  mysqli_stmt_bind_param($s, $tipe, $param);
  mysqli_stmt_execute($s);
  return mysqli_fetch_all(mysqli_stmt_get_result($s), MYSQLI_ASSOC);
}

$role = $_SESSION['role'];
$uid  = (int) $_SESSION['user_id'];
$profil = [];
$baris = [];

if ($role === 'guru') {
  $profil = ambil($koneksi, "SELECT id, nama, nip FROM guru WHERE user_id = ? LIMIT 1", 'i', $uid)[0] ?? [];
  if ($profil) {
    $baris = ambil($koneksi, "SELECT mp.kode_mapel AS kode, mp.`nama-mapel` AS mapel,
                                     GROUP_CONCAT(DISTINCT s.kelas ORDER BY s.kelas SEPARATOR ', ') AS keterangan
                              FROM mapel mp
                              LEFT JOIN mengajar m ON m.mapel_id = mp.id
                              LEFT JOIN siswa s ON m.siswa_id = s.id
                              WHERE mp.guru_id = ?
                              GROUP BY mp.id ORDER BY mp.`nama-mapel`", 'i', (int) $profil['id']);
  }
  $judul_tabel = 'Mata Pelajaran yang Diajar';
  $kolom_ket = 'Kelas';
} else {
  $profil = ambil($koneksi, "SELECT id, nama, nis, kelas FROM siswa WHERE user_id = ? LIMIT 1", 'i', $uid)[0] ?? [];
  if ($profil) {
    $baris = ambil($koneksi, "SELECT mp.kode_mapel AS kode, mp.`nama-mapel` AS mapel, g.nama AS keterangan
                              FROM mengajar m
                              JOIN mapel mp ON m.mapel_id = mp.id
                              LEFT JOIN guru g ON mp.guru_id = g.id
                              WHERE m.siswa_id = ? ORDER BY mp.`nama-mapel`", 'i', (int) $profil['id']);
  }
  $judul_tabel = 'Mata Pelajaran Saya';
  $kolom_ket = 'Guru';
}
$nama = $profil['nama'] ?? $_SESSION['nama'];
require_once 'navbar.php';
?>
<div class="container mt-4">
  <h3 class="mb-3">Selamat datang, <?= htmlspecialchars($nama) ?></h3>

  <div class="card mb-4">
    <div class="card-body">
      <p class="mb-1"><strong>Role:</strong> <?= htmlspecialchars(ucfirst($role)) ?></p>
      <?php if ($role === 'guru') { ?>
        <p class="mb-0"><strong>NIP:</strong> <?= htmlspecialchars((string) ($profil['nip'] ?? '-')) ?></p>
      <?php } else { ?>
        <p class="mb-1"><strong>NIS:</strong> <?= htmlspecialchars((string) ($profil['nis'] ?? '-')) ?></p>
        <p class="mb-0"><strong>Kelas:</strong> <?= htmlspecialchars((string) ($profil['kelas'] ?? '-')) ?></p>
      <?php } ?>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><h5 class="mb-0"><?= $judul_tabel ?></h5></div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped mb-0">
          <thead>
            <tr><th>No</th><th>Kode</th><th>Mata Pelajaran</th><th><?= $kolom_ket ?></th></tr>
          </thead>
          <tbody>
            <?php foreach ($baris as $i => $b) { ?>
              <tr>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars((string) $b['kode']) ?></td>
                <td><?= htmlspecialchars((string) $b['mapel']) ?></td>
                <td><?= htmlspecialchars((string) ($b['keterangan'] ?: '-')) ?></td>
              </tr>
            <?php } ?>
            <?php if (!$baris) { ?>
              <tr><td colspan="4" class="text-center text-muted">Belum ada data</td></tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php require_once 'footer.php'; ?>
