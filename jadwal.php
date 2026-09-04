<?php
include "koneksi.php";
include "header.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kuliah</title>
    <link rel="stylesheet" href="asset/css/jadwal.css">
</head>
<body>

<div class="wrapper">
    <div class="header">
        <h1><a href="list_tugas.php">List Tugas</a></h1>
        <h1>📚 Jadwal Kuliah</h1>
        <a href="tambah.php" class="btn-add">+ Tambah Jadwal</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mata Kuliah</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Ruangan</th>
                    <th>Dosen</th>
                    <th>SKS</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($koneksi, "SELECT * FROM jadwal");
                $no = 1;
                while ($data = mysqli_fetch_array($query)) { ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $data["matkul"] ?></td>
                    <td><?= $data["hari"] ?></td>
                    <td><?= $data["jam_mulai"] ?></td>
                    <td><?= $data["jam_selesai"] ?></td>
                    <td><?= $data["ruangan"] ?></td>
                    <td><?= $data["dosen"] ?></td>
                    <td><?= $data["sks"] ?></td>
                    <td class="aksi">
                        <a href="edit.php?id=<?= $data[
                            "id"
                        ] ?>" class="edit">Edit</a>
                        <a href="hapus.php?id=<?= $data[
                            "id"
                        ] ?>" class="hapus">Hapus</a>
                    </td>
                </tr>
                <?php }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="asset/js/jadwal.js"></script>
</body>
</html>
