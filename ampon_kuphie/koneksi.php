<?php
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');

$server = 'localhost';
$username_database = 'root';
$password_database = '';
$nama_database = 'ampon_kuphie';

$konek = mysqli_connect($server, $username_database, $password_database, $nama_database);

if (!$konek) {
    die('GAGAL KONEK KE DATABASE');
}

?>
