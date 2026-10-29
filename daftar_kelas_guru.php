<?php
require_once 'auth.php';
wajib_login();
// Halaman ini khusus guru
if ($_SESSION['role'] !== 'guru') { header('Location: ' . halaman_awal($_SESSION['role'])); exit; }
require_once 'navbar.php';
require_once 'koneksi.php';

// Kelas dan mapel yang diajar oleh guru yang sedang login, beserta jumlah siswanya
$sql = "SELECT mp.id AS mapel_id, mp.`nama-mapel` AS mapel, s.kelas, COUNT(DISTINCT s.id) AS jumlah
        FROM guru g
        JOIN mapel mp ON mp.guru_id = g.id
        JOIN mengajar m ON m.mapel_id = mp.id
        JOIN siswa s ON m.siswa_id = s.id
        WHERE g.user_id = ?
        GROUP BY mp.id, s.kelas
        ORDER BY mp.id ASC, s.kelas ASC";
$stmt = mysqli_prepare($koneksi, $sql);
$uid = (int) $_SESSION['user_id'];
mysqli_stmt_bind_param($stmt, 'i', $uid);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<div class="container-fluid mt-4 px-3">
  <h2 class="text-center mb-4">Daftar Kelas yang Diajar</h2>

  <table id="tabelKelasGuru" class="table table-striped table-bordered align-top" style="width:100%">
    <thead>
      <tr>
        <th>No</th>
        <th>Kelas</th>
        <th>Mata Pelajaran</th>
        <th>Jumlah Siswa</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; while ($data = mysqli_fetch_assoc($hasil)) { ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars((string) $data['kelas']); ?></td>
        <td><?= htmlspecialchars((string) $data['mapel']); ?></td>
        <td><?= (int) $data['jumlah']; ?> siswa</td>
        <td>
          <a href="lihat_kelas_guru.php?mapel_id=<?= (int) $data['mapel_id']; ?>&kelas=<?= urlencode($data['kelas']); ?>" class="btn btn-primary btn-sm">Lihat</a>
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
    $('#tabelKelasGuru').DataTable({
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
