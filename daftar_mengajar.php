<?php
require_once 'navbar.php';
require_once 'koneksi.php';

// Guru diambil dari mapel.guru_id, kelas diambil dari data siswa yang terhubung di tabel mengajar.
// Satu baris untuk setiap kombinasi guru - kelas - mapel.
$sql = "SELECT DISTINCT g.id AS guru_id, g.nama AS nama_guru, s.kelas,
               mp.id AS mapel_id, mp.`nama-mapel` AS nama_mapel, mp.kode_mapel AS kode
        FROM mengajar m
        JOIN mapel mp ON m.mapel_id = mp.id
        JOIN siswa s ON m.siswa_id = s.id
        LEFT JOIN guru g ON mp.guru_id = g.id
        ORDER BY g.id ASC, mp.id ASC, s.kelas ASC";
$hasil = mysqli_query($koneksi, $sql);
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<div class="container-fluid mt-4 px-3">
  <h2 class="text-center mb-4">Daftar Guru Mengajar</h2>

  <table id="tabelMengajar" class="table table-striped table-bordered align-top" style="width:100%">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Guru</th>
        <th>Kelas</th>
        <th>Nama Mata Pelajaran</th>
        <th>Kode Mata Pelajaran</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; while ($data = mysqli_fetch_assoc($hasil)) { ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars((string) ($data['nama_guru'] ?? '-')); ?></td>
        <td><?= htmlspecialchars((string) $data['kelas']); ?></td>
        <td><?= htmlspecialchars((string) $data['nama_mapel']); ?></td>
        <td><?= htmlspecialchars((string) $data['kode']); ?></td>
        <td>
          <a href="form_edit_mengajar.php?mapel_id=<?= (int) $data['mapel_id']; ?>&kelas=<?= urlencode($data['kelas']); ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="aksi_hapus_mengajar.php?mapel_id=<?= (int) $data['mapel_id']; ?>&kelas=<?= urlencode($data['kelas']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data mengajar ini?')">Hapus</a>
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
    $('#tabelMengajar').DataTable({
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
