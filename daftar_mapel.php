<?php
require_once 'navbar.php';
require_once 'koneksi.php';

$sql = "SELECT mp.id, mp.kode_mapel AS kode, mp.`nama-mapel` AS nama_mapel, g.nama AS nama_guru
        FROM mapel mp
        LEFT JOIN guru g ON mp.guru_id = g.id
        ORDER BY mp.id DESC";
$hasil = mysqli_query($koneksi, $sql);
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<div class="container-fluid mt-4 px-3">
  <h2 class="text-center mb-4">Daftar Mata Pelajaran</h2>
  <table id="tabelMapel" class="table table-striped table-bordered align-top" style="width:100%">
    <thead>
      <tr>
        <th>No</th>
        <th>Kode Mata Pelajaran</th>
        <th>Nama Mata Pelajaran</th>
        <th>Nama Guru</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; while ($data = mysqli_fetch_assoc($hasil)) { ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars((string) $data['kode']); ?></td>
        <td><?= htmlspecialchars((string) $data['nama_mapel']); ?></td>
        <td><?= htmlspecialchars((string) ($data['nama_guru'] ?? '-')); ?></td>
        <td>
          <a href="form_edit_mapel.php?id=<?= urlencode($data['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="aksi_hapus_mapel.php?id=<?= urlencode($data['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus mapel ini?')">Hapus</a>
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
    $('#tabelMapel').DataTable({
      language: {
        lengthMenu: "Tampilkan _MENU_ data per halaman",
        search: "Cari:",
        zeroRecords: "Data tidak ditemukan",
        info: "Menampilkan halaman _PAGE_ dari _PAGES_",
        infoEmpty: "Tidak ada data",
        infoFiltered: "(disaring dari _MAX_ total data)",
        paginate: { first: "Pertama", last: "Terakhir", next: "Selanjutnya", previous: "Sebelumnya" }
      },
      columnDefs: [{ orderable: false, targets: 4 }]
    });
  });
</script>
<?php require_once 'footer.php'; ?>
