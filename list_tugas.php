<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="asset/css/listtugas.css">
</head>
<body>
    <h3><a href="jadwal.php">Lihat Jadwal</a></h3>
    <h3><a href="tambah_tugas.php">Tambah Tugas</a></h3>
    
    <h3>List Daftar Tugas</h3>
    <table>
        <tr>
            <td id="nomor">no</td>
            <td id="judul">Judul Tugas</td>
            <td id="matkul">Mata Kuliah</td>
            <td id="deskripsi">Deskripsi</td>
            <td id="deadline">Deadline</td>
            <td id="status">Status</td>
            <td id="aksi">Aksi</td>
        </tr>

        <?php

$query = mysqli_query($koneksi, "SELECT * FROM tugas");
$no =  1;
while ($data = mysqli_fetch_array($query)){


?>

<tr>
<td><?= $no++; ?></td>
<td><?= $data['judul_tugas']; ?></td>
<td><?= $data['jadwal_id']; ?></td>
<td><?= $data['deskripsi']; ?></    td>
<td><?= $data['deadline']; ?></td>

<td>
<?= $data['status']; ?>

<?php
if($data['status']=="belum"){
echo " <a href='selesai.php?id=".$data['id']."'>Tandai Selesai</a>";
}
?>
<td>
     <a href="edit_tugas.php?id=<?= $data['id']; ?>" class="edit">Edit</a>
                                                                 <a href="hapus_tugas.php?id=<?= $data['id']; ?>" class="hapus">Hapus</a>

</td>
</tr>

<?php } ?>
</table>

</body>
</html>