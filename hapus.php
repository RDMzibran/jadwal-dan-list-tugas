<?php 

include 'koneksi.php';

mysqli_report(MYSQLI_REPORT_OFF);

if (isset($_GET['id'])){
$id = $_GET['id'];

$query = mysqli_query($koneksi, "DELETE FROM jadwal where id =  $id");

if($query){
    header("location: jadwal.php");
    exit;
}  else {
        echo "mohon maaf hapus tugas yang berkaitan dengan jadwal ini terlebih dahulu";
    }
}

?>

