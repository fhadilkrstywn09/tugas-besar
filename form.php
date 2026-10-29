<?php
include_once("navbar.php");
?>

<!-- awal konten -->
<div class="container mt-4">
  
<!-- awal kolom -->
<div class="container">
  <div class="row align-items-start">

    <div class="col-2"></div>

    <div class="col-12 col-md-10 mx-auto">
      <br>

      <!--awal card -->
      <div class="card shadow-sm" style="border-radius:12px; border:1px solid #ddd;">

        <!-- HEADER -->
        <div class="card-header" style="background:#f3f3f3; padding:18px 25px;">
          <h3 style="margin:0; font-weight:600;">Form Tambah User (Siswa)</h3> 
        </div>

        <!-- BODY -->
        <div class="card-body" style="padding:30px;">

        <!-- awal form -->
        <form action="aksi_tambah_user.php" method="POST">
          <h3>data profil user 2</h3>

          <div class="mb-4">
            <label class="form-label">NIS</label>
            <input type="text" name="nis" class="form-control form-control-lg"
            placeholder="Nomor Induk Siswa | Contoh: 1234567890" required>
          </div>

          <div class="mb-4">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control form-control-lg"
            placeholder="Nama Lengkap Siswa | Contoh: Ujang Asep" required>
          </div>

          <div class="mb-4">
            <label class="form-label">Kelas</label>
            <input type="text" name="kelas" class="form-control form-control-lg"
            placeholder="Kelas Siswa | Contoh: XI-RPL-1" required>
          </div>

          <!-- JENIS KELAMIN -->
          <div class="mb-4">
            <label class="form-label">Jenis Kelamin</label><br>
            <input type="radio" name="jenis_kelamin" value="L" required> Laki-laki <br>
            <input type="radio" name="jenis_kelamin" value="P"> Perempuan
          </div>

          <hr style="margin:35px 0; border-top:1px solid #ccc;">

          <!-- BAGIAN AKUN -->
          <h4 style="font-weight:600; margin-bottom:25px;">Data Kredensial Akun</h4>

          <div class="mb-4">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control form-control-lg"
            placeholder="Username Akun | Contoh: ujang123" required>
          </div>

          <div class="mb-4">
            <label class="form-label">Password Akun</label>
            <input type="password" name="password" class="form-control form-control-lg"
            placeholder="Password Akun | Contoh: password123" required>
          </div>

          <div class="mb-4">
            <input type="text" name="role" class="form-control form-control-lg" value="siswa" readonly>
          </div>

          <!-- BUTTON -->
          <button type="submit" name="tambah" class="btn btn-primary">Simpan data</button>
          <a href="tabel.php" class="btn btn-secondary">Kembali</a>
        </form>
        <!-- akhir form -->
        
        </div>
      </div>
      <!-- akhir card -->
      
    </div>

    <div class="col-2"></div>

  </div>
</div>
<!-- akhir kolom -->

</div>
<!-- akhir konten -->

<?php include("footer.php"); ?>