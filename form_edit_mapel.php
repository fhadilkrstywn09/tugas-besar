<?php
require_once 'koneksi.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = mysqli_prepare($koneksi, "SELECT id, kode_mapel, `nama-mapel` AS nama_mapel, guru_id FROM mapel WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$mapel = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$mapel) {
    echo "<script>alert('Data mapel tidak ditemukan'); window.location.href='daftar_mapel.php';</script>";
    exit;
}

$guru = mysqli_query($koneksi, "SELECT id, nama FROM guru ORDER BY nama ASC");

require_once 'navbar.php';
?>
<div class="container mt-5">
  <div class="card">
    <div class="card-header">
      <h3 class="mb-0">Form Edit Mata Pelajaran</h3>
    </div>
    <div class="card-body">
      <h3>Mata Pelajaran</h3>
      <form method="POST" action="aksi_edit_mapel.php">
        <input type="hidden" name="id" value="<?= (int) $mapel['id']; ?>">
        <div class="mb-4">
          <label for="kode" class="form-label">Kode Mata Pelajaran</label>
          <input type="text" class="form-control" id="kode" name="kode" value="<?= htmlspecialchars($mapel['kode_mapel']); ?>" required>
        </div>
        <div class="mb-4">
          <label for="nama" class="form-label">Nama Mata Pelajaran</label>
          <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($mapel['nama_mapel']); ?>" required>
        </div>
        <div class="mb-4">
          <label for="guru_id" class="form-label">Pilih Guru</label>
          <select class="form-select" id="guru_id" name="guru_id" required>
            <option value="" disabled>Pilih Guru...</option>
            <?php while ($g = mysqli_fetch_assoc($guru)) { ?>
              <option value="<?= (int) $g['id']; ?>" <?= $g['id'] == $mapel['guru_id'] ? 'selected' : ''; ?>><?= htmlspecialchars($g['nama']); ?></option>
            <?php } ?>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Data</button>
        <a href="daftar_mapel.php" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>
<?php require_once 'footer.php'; ?>
