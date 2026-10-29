<?php
require_once 'auth.php';
wajib_login();
header('Location: ' . halaman_awal($_SESSION['role']));
exit;
