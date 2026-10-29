<?php
require_once 'navbar.php';
require_once 'koneksi.php';
$sql = "SELECT users.*, COALESCE(siswa.nama, guru.nama) AS nama
        FROM users
        LEFT JOIN siswa ON users.id = siswa.user_id
        LEFT JOIN guru ON users.id = guru.user_id
        ORDER BY users.id DESC";
$hasil = mysqli_query($koneksi, $sql);
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<div class="container-fluid mt-4 px-3">
  <h2 class="text-center mb-4">Daftar User</h2>

  <table id="tabelUser" class="table table-striped table-bordered align-top" style="width:100%">
    <thead>
      <tr>
        <th>No</th>
        <th>Username</th>
        <th>Role</th>
        <th>Nama</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; while ($data = mysqli_fetch_assoc($hasil)) { ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($data['username']); ?></td>
        <td><?= htmlspecialchars($data['role']); ?></td>
        <td><?= htmlspecialchars((string) $data['nama']); ?></td>
        <td>
          <a href="form_edit_user.php?id=<?= $data['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="aksi_hapus.php?id=<?= $data['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data?')">Hapus</a>
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
    $('#tabelUser').DataTable({
      language: {
        lengthMenu: "Tampilkan _MENU_ data per halaman",
        search: "Cari:",
        zeroRecords: "Data tidak ditemukan",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        infoEmpty: "Tidak ada data",
        infoFiltered: "(disaring dari _MAX_ total data)",
        paginate: { first: "Pertama", last: "Terakhir", next: "Selanjutnya", previous: "Sebelumnya" }
      },
      columnDefs: [{ orderable: false, targets: 4 }]
    });
  });
</script>
<?php require_once 'footer.php'; ?>
