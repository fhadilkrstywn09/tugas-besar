<?php
require_once 'navbar.php';
require_once 'koneksi.php';

$guru = mysqli_query($koneksi, "SELECT id, nama FROM guru ORDER BY nama ASC");
?>
<div class="container mt-5">
  <div class="card">
    <div class="card-header">
      <h3 class="mb-0">Form Tambah Mata Pelajaran</h3>
    </div>
    <div class="card-body">
      <h3>Mata Pelajaran</h3>
      <form method="POST" action="aksi_tambah_mapel.php">
        <div class="mb-4">
          <label for="kode" class="form-label">Kode Mata Pelajaran</label>
          <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Mapel | Contoh: MP001" required>
        </div>
        <div class="mb-4">
          <label for="nama" class="form-label">Nama Mata Pelajaran</label>
          <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Mata Pelajaran | Contoh: Pemrograman Web" required>
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
        <a href="daftar_mapel.php" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>
<?php require_once 'footer.php'; ?>
