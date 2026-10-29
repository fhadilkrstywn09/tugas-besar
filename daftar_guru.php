<?php
require_once 'auth.php';
wajib_login();
// Daftar guru hanya untuk admin dan guru
if (!in_array($_SESSION['role'], ['admin', 'guru'], true)) { header('Location: beranda.php'); exit; }
$adalah_admin = $_SESSION['role'] === 'admin';
require_once 'navbar.php';
require_once 'koneksi.php';

// Satu baris per mapel yang diajar (guru tanpa mapel tampil dengan "-")
$sql = "SELECT guru.user_id, users.username, users.role, guru.nama, mapel.`nama-mapel` AS mapel
        FROM guru
        LEFT JOIN users ON guru.user_id = users.id
        LEFT JOIN mapel ON mapel.guru_id = guru.id
        ORDER BY guru.id ASC, mapel.`nama-mapel` ASC";
$hasil = mysqli_query($koneksi, $sql);
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<div class="container-fluid mt-4 px-3">
  <h2 class="text-center mb-4">Daftar Guru</h2>
  <table id="tabelGuru" class="table table-striped table-bordered align-top" style="width:100%">
    <thead>
      <tr>
        <th>No</th>
        <th>Username</th>
        <th>Role</th>
        <th>Nama</th>
        <th>Mapel</th>
        <?php if ($adalah_admin) { ?><th>Aksi</th><?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; while ($data = mysqli_fetch_assoc($hasil)) { ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars((string) $data['username']); ?></td>
        <td><?= htmlspecialchars((string) ($data['role'] ?? 'guru')); ?></td>
        <td><?= htmlspecialchars((string) $data['nama']); ?></td>
        <td><?= htmlspecialchars($data['mapel'] ?? '-'); ?></td>
        <?php if ($adalah_admin) { ?>
        <td>
          <a href="form_edit_user.php?id=<?= (int) $data['user_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="aksi_hapus.php?id=<?= (int) $data['user_id']; ?>&role=guru&dari=daftar_guru.php" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus guru ini?')">Hapus</a>
        </td>
        <?php } ?>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script>
  $(document).ready(function () {
    $('#tabelGuru').DataTable({
      language: {
        lengthMenu: "Tampilkan _MENU_ data per halaman",
        search: "Cari:",
        zeroRecords: "Data tidak ditemukan",
        info: "Menampilkan halaman _PAGE_ dari _PAGES_",
        infoEmpty: "Tidak ada data",
        infoFiltered: "(disaring dari _MAX_ total data)",
        paginate: { first: "Pertama", last: "Terakhir", next: "Selanjutnya", previous: "Sebelumnya" }
      },
      columnDefs: <?= $adalah_admin ? '[{ orderable: false, targets: 5 }]' : '[]' ?>
    });
  });
</script>
<?php require_once 'footer.php'; ?>
