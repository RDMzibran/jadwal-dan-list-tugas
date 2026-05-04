<?php
include "koneksi.php";
?>

<?php
$id = $_GET['id'];
if(isset($_GET['id'])){
    

    $query = mysqli_query($koneksi, "DELETE FROM tugas WHERE id = '$id'");
    if($query){
        header("location: list_tugas.php");
        exit;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}