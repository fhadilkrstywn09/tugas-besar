<?php
require_once 'navbar.php';
require_once 'koneksi.php';

$kelas = mysqli_query($koneksi, "SELECT DISTINCT kelas FROM siswa WHERE kelas IS NOT NULL AND kelas <> '' ORDER BY kelas ASC");
$guru  = mysqli_query($koneksi, "SELECT id, nama FROM guru ORDER BY nama ASC");
?>
<div class="container mt-5">
  <div class="card">
    <div class="card-header">
      <h3 class="mb-0">Form Tambah Mengajar</h3>
    </div>
    <div class="card-body">
      <h3>Pengajar</h3>
      <form method="POST" action="aksi_tambah_mengajar.php">
        <div class="mb-3">
          <label for="kelas" class="form-label">Pilih Kelas</label>
          <select class="form-select" id="kelas" name="kelas" required>
            <option value="" selected disabled>Pilih Kelas...</option>
            <?php while ($k = mysqli_fetch_assoc($kelas)) { ?>
              <option value="<?= htmlspecialchars($k['kelas']); ?>"><?= htmlspecialchars($k['kelas']); ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="mb-4">
          <label for="guru_id" class="form-label">Pilih Guru</label>
          <select class="form-select" id="guru_id" name="guru_id" required>
            <option value="" selected disabled>Pilih Guru...</option>
            <?php while ($g = mysqli_fetch_assoc($guru)) { ?>
              <option value="<?= (int) $g['id']; ?>"><?= htmlspecialchars($g['nama']); ?></option>
            <?php } ?>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
        <a href="daftar_mengajar.php" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>
<?php require_once 'footer.php'; ?>
