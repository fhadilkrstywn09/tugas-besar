<?php
require_once 'navbar.php';
?>

<!-- awal content -->
<div class="container">
<!-- awal kolom -->
<div class="container">
  <div class="row align-items-start">
    <div class="col-1">
      <!--One of three columns  1 -->
    </div>
    <div class="col-10">
       <br>
      <!-- awal card -->
       <div class="card">
         <div class="card-header">
          <h3>Tabel</h3>
          </div>
        <div class="card-body">
            <!-- awal Tabel -->
             <table class="table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Username</th>
      <th scope="col">Role</th>
      <th scope="col">Nama</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>

  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Akmal12</td>
      <td>Siswa</td>
      <td>Akmal</td>
      <td>
        <a href="#" class="btn btn-warning">Edit</a>
        <a href="#" class="btn btn-danger">Hapus</a>
      </td>
    </tr>
  </tbody>

             </table>
            <!-- akhir tabel -->
         </div>
       </div>
      <!-- akhir card -->
      
    </div>
    <div class="col-2">
      <!--One of three columns 3 -->
    </div>
  </div>
</div>
  <!-- akhir kolom -->
  
</div>
<!-- akhir content -->

<?php
require_once 'footer.php';
?>