<?php
// Menetapkan parameter koneksi database
$host = "localhost";
$user = "root";
$passwd = ""; // Sesuaikan dengan password MySQL Anda
$name = "crud1"; // Sesuaikan dengan nama database Anda

// Membuat koneksi ke database
$link = mysqli_connect($host, $user, $passwd, $name);

// Memeriksa koneksi
if (!$link) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
