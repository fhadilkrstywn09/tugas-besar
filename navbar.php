<?php
require_once 'auth.php';
wajib_login();
$nama_login = $_SESSION['nama'] ?? '';
$user_login = $_SESSION['username'] ?? '';
$role_login = $_SESSION['role'] ?? '';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<!-- start navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>

        <?php if ($role_login === 'admin') { ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">User</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="daftar_user.php">Daftar User</a></li>
            <li><a class="dropdown-item" href="formall.php">Tambah User</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Siswa</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="daftar_siswa.php">Daftar Siswa</a></li>
            <li><a class="dropdown-item" href="Form.php">Tambah Siswa</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Guru</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="daftar_guru.php">Daftar Guru</a></li>
            <li><a class="dropdown-item" href="formall.php">Tambah Guru</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Mapel</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="daftar_mapel.php">Daftar Mapel</a></li>
            <li><a class="dropdown-item" href="tambah_mapel.php">Tambah Mapel</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Mengajar</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="daftar_mengajar.php">Daftar Mengajar</a></li>
            <li><a class="dropdown-item" href="form_tambah_mengajar.php">Tambah Mengajar</a></li>
          </ul>
        </li>
        <?php } elseif ($role_login === 'guru') { ?>
        <li class="nav-item">
          <a class="nav-link" href="nilai_siswa.php">Nilai Siswa</a>
        </li>
        <?php } ?>
      </ul>

      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>

      <ul class="navbar-nav ms-lg-3">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= htmlspecialchars($nama_login); ?> ( <?= htmlspecialchars($role_login === 'admin' ? $user_login : $role_login); ?> )
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="pengaturan.php">Pengaturan</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- end navbar -->
