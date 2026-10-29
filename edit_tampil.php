<div class="container mt-4"><div class="card shadow-sm">
  <div class="card-header"><h4 style="margin:0;">Edit <?= e(ucfirst($role)) ?></h4></div>
  <div class="card-body">
    <?php if ($error != '') { ?><div class="alert alert-danger"><?= e($error) ?></div><?php } ?>
    <form method="POST" action="aksi_edit_user.php?aksi=<?= $aksi ?>">
      <input type="hidden" name="id" value="<?= (int) ($profil['id'] ?? 0) ?>">
      <input type="hidden" name="user_id" value="<?= $id ?>">
      <input type="hidden" name="role" value="<?= e($role) ?>">
      <?php foreach ($isi as $c => $label) { ?>
        <div class="mb-3"><label><?= $label ?></label>
        <input type="text" name="<?= $c == 'nama' ? 'nama_lengkap' : $c ?>" class="form-control" value="<?= e($profil[$c] ?? '') ?>" required></div>
      <?php } ?>
      <?php if ($jk) { ?>
        <div class="mb-3"><label>Jenis Kelamin</label><br>
        <input type="radio" name="jenis_kelamin" value="L" <?= ($profil['jenis_kelamin'] ?? '') == 'L' ? 'checked' : '' ?> required> Laki-laki
        <input type="radio" name="jenis_kelamin" value="P" <?= ($profil['jenis_kelamin'] ?? '') == 'P' ? 'checked' : '' ?>> Perempuan</div>
      <?php } ?>
      <hr><h5>Akun</h5>
      <div class="mb-3"><label>Username</label>
      <input type="text" name="username" class="form-control" value="<?= e($user['username']) ?>" required></div>
      <div class="mb-3"><label>Password baru</label>
      <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin diganti"></div>
      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="<?= e($kembali) ?>" class="btn btn-secondary">Batal</a>
    </form>
  </div></div></div>
