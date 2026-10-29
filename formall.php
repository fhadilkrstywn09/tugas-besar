<?php
include_once("navbar.php");

// ambil jenis dari URL
$jenis = isset($_GET['jenis']) ? $_GET['jenis'] : '';
?>

<div class="container mt-4">

  <div class="card shadow-sm" style="border-radius:12px; border:1px solid #ddd;">
    
    <div class="card-header" style="background:#f3f3f3;">
      <h4 style="margin:0;">Form Tambah User</h4>
    </div>

    <div class="card-body">

      <!-- PILIH JENIS -->
      <form method="GET">
        <div class="mb-3">
          <label>Pilih Jenis User</label>
          <div class="d-flex gap-2">
            <select name="jenis" class="form-control">
              <option value="">-- pilih --</option>
              <option value="guru" <?= ($jenis=='guru')?'selected':''; ?>>Guru</option>
              <option value="siswa" <?= ($jenis=='siswa')?'selected':''; ?>>Siswa</option>
              <option value="admin" <?= ($jenis=='admin')?'selected':''; ?>>Admin</option>
            </select>
            <button type="submit" class="btn btn-primary">Pilih</button>
          </div>
        </div>
      </form>

      <hr>

      <!-- ================= GURU ================= -->
      <?php if ($jenis == 'guru') { ?>
      <form action="aksi_tambah_user.php" method="POST">
        <input type="hidden" name="role" value="guru">

        <h5>Data Guru</h5>

        <div class="mb-3">
          <label>NIP</label>
          <input type="text" name="nip" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Nama Lengkap</label>
          <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Jenis Kelamin</label><br>
          <input type="radio" name="jenis_kelamin" value="L" required> Laki-laki
          <input type="radio" name="jenis_kelamin" value="P"> Perempuan
        </div>

        <hr>
        <h5>Akun</h5>

        <div class="mb-3">
          <label>Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <button class="btn btn-primary">Simpan</button>
      </form>
      <?php } ?>

      <!-- ================= SISWA ================= -->
      <?php if ($jenis == 'siswa') { ?>
      <form action="aksi_tambah_user.php" method="POST">
        <input type="hidden" name="role" value="siswa">

        <h5>Data Siswa</h5>

        <div class="mb-3">
          <label>NIS</label>
          <input type="text" name="nis" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Nama Lengkap</label>
          <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Kelas</label>
          <input type="text" name="kelas" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Jenis Kelamin</label><br>
          <input type="radio" name="jenis_kelamin" value="L" required> Laki-laki
          <input type="radio" name="jenis_kelamin" value="P"> Perempuan
        </div>

        <hr>
        <h5>Akun</h5>

        <div class="mb-3">
          <label>Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <button class="btn btn-primary">Simpan</button>
      </form>
      <?php } ?>

      <!-- ================= ADMIN ================= -->
      <?php if ($jenis == 'admin') { ?>
      <form action="aksi_tambah_user.php" method="POST">
        <input type="hidden" name="role" value="admin">

        <h5>Data Admin</h5>

        <div class="mb-3">
          <label>Nama</label>
          <input type="text" name="nama" class="form-control" required>
        </div>

        <hr>
        <h5>Akun</h5>

        <div class="mb-3">
          <label>Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <button class="btn btn-primary">Simpan</button>
      </form>
      <?php } ?>

    </div>
  </div>

</div>

<?php include("footer.php"); ?>