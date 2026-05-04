<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="asset/css/edit.css">
</head>
<body>
<?php  
$id = $_GET['id'];

if (isset($_POST['submit'])) {
    $matkul = $_POST['matkul'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $ruangan = $_POST['ruangan'];
    $dosen = $_POST['dosen'];   
    $sks = $_POST['sks'];

    $query = mysqli_query($koneksi, "UPDATE jadwal SET matkul = '$matkul', hari = '$hari', jam_mulai = '$jam_mulai', jam_selesai = '$jam_selesai', ruangan = '$ruangan', dosen = '$dosen', sks = '$sks' WHERE id = $_GET[id]");
    if ($query){
    header("Location: jadwal.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}

$query = mysqli_query($koneksi, "SELECT * FROM jadwal WHERE id = '$_GET[id]'");
$data = mysqli_fetch_array($query);

?>
   <div class="container">
    <h1>Edit Jadwal Kuliah</h1>

    <form method="POST" id="formJadwal">
        
        <label>Mata Kuliah</label>
        <input type="text" name="matkul" required value="<?php echo $data['matkul']; ?>">

        <label>Hari</label>
        <input type="text" name="hari" required value="<?php echo $data['hari']; ?>">

        <label>Jam Mulai</label>
        <input type="time" name="jam_mulai" required value="<?php echo $data['jam_mulai']; ?>">

        <label>Jam Selesai</label>
        <input type="time" name="jam_selesai" required value="<?php echo $data['jam_selesai']; ?>">

        <label>Ruangan</label>
        <input type="text" name="ruangan" required value="<?php echo $data['ruangan']; ?>">

        <label>Dosen</label>
        <input type="text" name="dosen" required value="<?php echo $data['dosen']; ?>">

        <label>SKS</label>
        <input type="number" name="sks" required value="<?php echo $data['sks']; ?>">

        <button type="submit" name="submit">Update Jadwal</button>
    </form>
</div>

<script src="asset/js/edit.js"></script>
</body>
</html>