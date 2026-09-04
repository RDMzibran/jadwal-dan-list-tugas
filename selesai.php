<?php
include 'koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($koneksi, "UPDATE tugas SET status='Selesai' WHERE id='$id'");

if($query){
   header("location: list_tugas.php");
}else{
    echo "Gagal update";
}
?>