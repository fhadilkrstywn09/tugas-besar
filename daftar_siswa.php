<?php
require_once 'navbar.php';
require_once 'koneksi.php';

$sql = "SELECT siswa.user_id, users.username, users.role, siswa.nama, siswa.kelas
        FROM siswa
        LEFT JOIN users ON siswa.user_id = users.id
        ORDER BY siswa.id ASC";
$hasil = mysqli_query($koneksi, $sql);
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<div class="container-fluid mt-4 px-3">
  <h2 class="text-center mb-4">Daftar Siswa</h2>

  <table id="tabelSiswa" class="table table-striped table-bordered align-top" style="width:100%">
    <thead>
      <tr>
        <th>No</th>
        <th>Username</th>
        <th>Role</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; while ($data = mysqli_fetch_assoc($hasil)) { ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars((string) $data['username']); ?></td>
        <td><?= htmlspecialchars((string) ($data['role'] ?? 'siswa')); ?></td>
        <td><?= htmlspecialchars((string) $data['nama']); ?></td>
        <td><?= htmlspecialchars((string) $data['kelas']); ?></td>
        <td>
          <a href="form_edit_user.php?id=<?= (int) $data['user_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="aksi_hapus.php?id=<?= (int) $data['user_id']; ?>&role=siswa&dari=daftar_siswa.php" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">Hapus</a>
        </td>
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
    $('#tabelSiswa').DataTable({
      language: {
        lengthMenu: "Tampilkan _MENU_ data per halaman",
        search: "Cari:",
        zeroRecords: "Data tidak ditemukan",
        info: "Menampilkan halaman _PAGE_ dari _PAGES_",
        infoEmpty: "Tidak ada data",
        infoFiltered: "(disaring dari _MAX_ total data)",
        paginate: { first: "Pertama", last: "Terakhir", next: "Selanjutnya", previous: "Sebelumnya" }
      },
      columnDefs: [{ orderable: false, targets: 5 }]
    });
  });
</script>
<?php require_once 'footer.php'; ?>
