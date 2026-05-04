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
<?php  
if (isset($_POST['submit'])) {
    $matkul = $_POST['matkul'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $ruangan = $_POST['ruangan'];
    $dosen = $_POST['dosen'];   
    $sks = $_POST['sks'];

    $query = mysqli_query($koneksi, "INSERT INTO jadwal (matkul, hari, jam_mulai, jam_selesai, ruangan, dosen, sks) VALUES ('$matkul', '$hari', '$jam_mulai', '$jam_selesai', '$ruangan', '$dosen', '$sks')");
    if ($query){
    header("Location: jadwal.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}
?>
    <h1>Tambah Jadwal Kuliah</h1>
    <form  method="POST">
        
    <label for="matkul">Mata Kuliah:</label>
<input type="text" name="matkul" id="matkul" required><br><br>
        <label for="hari">Hari:</label>
        <input type="text" id="hari" name="hari" required><br><br>

        <label for="jam_mulai">Jam Mulai:</label>
        <input type="time" id="jam_mulai" name="jam_mulai" required><br><br>

        <label for="jam_selesai">Jam Selesai:</label>
        <input type="time" id="jam_selesai" name="jam_selesai" required><br><br>

        <label for="ruangan">Ruangan:</label>
        <input type="text" id="ruangan" name="ruangan" required><br><br>

        <label for="dosen">Dosen:</label>
        <input type="text" id="dosen" name="dosen" required><br><br>

        <label for="sks">SKS:</label>
        <input type="number" id="sks" name="sks" required><br><br>

        <input type="submit" name="submit" value="Tambah Jadwal">
    </form>
    
</body>
</html>