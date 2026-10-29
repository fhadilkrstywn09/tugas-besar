<?php
include_once("navbar.php");

// ambil role dari POST
$role = isset($_POST['role']) ? $_POST['role'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
?>

<div class="container mt-4">
  <div class="col-12 col-md-10 mx-auto">

    <div class="card shadow-sm" style="border-radius:10px; border:1px solid #ddd;">

      <!-- HEADER -->
      <div class="card-header" style="background:#f5f5f5; padding:15px 20px;">
        <h3 style="margin:0;">Form Tambah User</h3>
      </div>

      <!-- BODY -->
      <div class="card-body" style="padding:25px;">

        <!-- FORM PILIH ROLE -->
        <form method="POST">

          <h5>Data Akun</h5>

          <!-- Username -->
          <div class="mb-3">
            <input type="text" name="username" 
            value="<?php echo $username; ?>"
            class="form-control"
            placeholder="Username"
            required>
          </div>

          <!-- Password -->
          <div class="mb-3">
            <input type="password" name="password" 
            value="<?php echo $password; ?>"
            class="form-control"
            placeholder="Password"
            required>
          </div>

          <!-- Role -->
          <div class="mb-3">
            <select name="role" class="form-control" onchange="this.form.submit()" required>
              <option value="">-- Pilih Role --</option>
              <option value="admin" <?php if($role=="admin") echo "selected"; ?>>Admin</option>
              <option value="guru" <?php if($role=="guru") echo "selected"; ?>>Guru</option>
              <option value="siswa" <?php if($role=="siswa") echo "selected"; ?>>Siswa</option>
            </select>
          </div>

        </form>

        <hr>

        <!-- FORM SIMPAN -->
        <?php if($role != ""){ ?>

        <form method="POST" action="aksi_tambah_user.php">

          <!-- kirim data akun -->
          <input type="hidden" name="username" value="<?php echo $username; ?>">
          <input type="hidden" name="password" value="<?php echo $password; ?>">
          <input type="hidden" name="role" value="<?php echo $role; ?>">

          <!-- ================= SISWA ================= -->
          <?php if($role == "siswa"){ ?>
            <h5>Data Siswa</h5>

            <div class="mb-3">
              <input type="text" name="nama" class="form-control" placeholder="Nama Siswa" required>
            </div>

            <div class="mb-3">
              <select name="jenis_kelamin" class="form-control" required>
                <option value="">-- Jenis Kelamin --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>

            <div class="mb-3">
              <input type="text" name="nis" class="form-control" placeholder="NIS" required>
            </div>

            <div class="mb-3">
              <input type="text" name="kelas" class="form-control" placeholder="Kelas" required>
            </div>
          <?php } ?>

          <!-- ================= GURU ================= -->
          <?php if($role == "guru"){ ?>
            <h5>Data Guru</h5>

            <div class="mb-3">
              <input type="text" name="nama" class="form-control" placeholder="Nama Guru" required>
            </div>

            <div class="mb-3">
              <select name="jenis_kelamin" class="form-control" required>
                <option value="">-- Jenis Kelamin --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>

            <div class="mb-3">
              <input type="text" name="nip" class="form-control" placeholder="NIP" required>
            </div>
          <?php } ?>

          <!-- ================= ADMIN ================= -->
          <?php if($role == "admin"){ ?>
            <h5>Admin tidak perlu data tambahan</h5>
          <?php } ?>

          <br>

          <!-- BUTTON -->
          <button type="submit" name="tambah" class="btn btn-primary">
            Simpan Data
          </button>

          <a href="dashboard.php" class="btn btn-secondary">
            Kembali
          </a>

        </form>

        <?php } ?>

      </div>
    </div>

  </div>
</div>

<?php include("footer.php"); ?>