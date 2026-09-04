<?php
$koneksi = mysqli_connect("localhost", "root", "", "jadwal_kuliah");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
