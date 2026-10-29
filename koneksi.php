<?php

  $host ="127.0.0.1"; //nama server yang kita gunakan
  $username ="root"; //username atau nama akun pengguna
  $pass ="root"; //password pengguna
//untuk database disesuaikan dengan nama database yang kalian alan gunakan
  $database ="Muhamad_fhadilah_sipn";

//perintah untuk menghubungkan database yang kita gunakan dengan project PHP kita
$koneksi = mysqli_connect($host, $username, $pass, $database, 3306);

//untuk mengecek apakah koneksi kedatabasenya berhasil atau gagal
if (!$koneksi) {
  die("koneksi kedatabase gagal" . mysqli_connect_error());
}else {
 // echo "koneksi kedatabase berhasil";
}