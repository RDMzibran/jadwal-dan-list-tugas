<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h3>Tambah tugas</h3>
<h3><a href="list_tugas.php">Kembali</a></h3>


<?php
if(isset($_POST['Tambah'])){

$judul_tugas =$_POST['judul_tugas'];
$jadwal_id =$_POST['jadwal_id'];
$deskripsi =$_POST['Deskripsi'];
$deadline =$_POST['Deadline'];


$query = mysqli_query($koneksi, "INSERT INTO tugas (judul_tugas, jadwal_id, deskripsi, deadline ) VALUES ('$judul_tugas', '$jadwal_id', '$deskripsi', '$deadline' ) ");


if($query){
   header("location: list_tugas.php" );

}else{
   echo "Error: " . mysqli_error($koneksi);
}
}

?>

   <form method="POST">
<label for="judul_tugas">Judul Tugas</label>
<input type="text" name="judul_tugas" placeholder="judul tugas" required>

<label for="jadwal_id">Matakuliah</label>
<select name="jadwal_id" >
      <?php
      include 'koneksi.php';
      $query = mysqli_query($koneksi, "SELECT id, matkul from jadwal");
      while ($data = mysqli_fetch_assoc($query)){
      ?>

         <option value="<?php echo $data['id'];  ?>">
         <?php  echo $data['matkul']
         ?>
      </option>
      <?php  } ?>

</select>

<label for="deskripsi">Deskripsi</label>
<textarea name="Deskripsi" id="deskripsi" placeholder="Deskripsi tugas"></textarea>

<label for="deadline">Deadline</label>
<input type="datetime-local" name="Deadline" id="Deadline">


<button type="submit" name="Tambah">Tambah</button>

   </form>

</body>
</html>