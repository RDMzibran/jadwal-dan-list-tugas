<?php
include "koneksi.php";

$error = "";

if (isset($_POST["submit"])) {
    $matkul = $_POST["matkul"];
    $hari = $_POST["hari"];
    $jam_mulai = $_POST["jam_mulai"];
    $jam_selesai = $_POST["jam_selesai"];
    $ruangan = $_POST["ruangan"];
    $dosen = $_POST["dosen"];
    $sks = $_POST["sks"];

    $query = mysqli_query(
        $koneksi,
        "INSERT INTO jadwal (matkul, hari, jam_mulai, jam_selesai, ruangan, dosen, sks) VALUES ('$matkul', '$hari', '$jam_mulai', '$jam_selesai', '$ruangan', '$dosen', '$sks')"
    );

    if ($query) {
        header("Location: jadwal.php");
        exit;
    }

    $error = "Jadwal belum dapat disimpan. Silakan coba lagi.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f0f1a">
    <link rel="stylesheet" href="asset/css/tambah_jadwal.css">
    <title>Tambah Jadwal Kuliah</title>
</head>
<body>
    <main class="page-shell">
        <a href="jadwal.php" class="back-link" aria-label="Kembali ke halaman jadwal">
            <span aria-hidden="true">&larr;</span>
            Kembali ke Jadwal
        </a>

        <div class="form-layout">
            <section class="info-panel" aria-labelledby="page-title">
                <p class="eyebrow">JADWAL AKADEMIK</p>
                <h1 id="page-title">Tambah jadwal, atur harimu.</h1>
                <p class="intro-text">
                    Simpan detail mata kuliah agar agenda perkuliahanmu tetap rapi dan mudah dipantau.
                </p>

                <ul class="info-list">
                    <li>Isi seluruh data yang bertanda wajib.</li>
                    <li>Gunakan waktu mulai dan selesai yang sesuai.</li>
                    <li>Jadwal akan langsung muncul setelah disimpan.</li>
                </ul>
            </section>

            <section class="form-card" aria-labelledby="form-title">
                <div class="card-heading">
                    <p class="section-label">FORM JADWAL</p>
                    <h2 id="form-title">Detail perkuliahan</h2>
                    <p>Lengkapi informasi berikut untuk menambahkan jadwal baru.</p>
                </div>

                <?php if ($error !== "") { ?>
                    <div class="form-alert" role="alert">
                        <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
                    </div>
                <?php } ?>

                <form method="POST">
                    <div class="field-grid">
                        <div class="field field--wide">
                            <label for="matkul">Mata Kuliah <span aria-hidden="true">*</span></label>
                            <input type="text" name="matkul" id="matkul" placeholder="Contoh: Pemrograman Web" required>
                        </div>

                        <div class="field">
                            <label for="hari">Hari <span aria-hidden="true">*</span></label>
                            <select name="hari" id="hari" required>
                                <option value="" selected disabled>Pilih hari</option>
                                <option value="senin">Senin</option>
                                <option value="selasa">Selasa</option>
                                <option value="rabu">Rabu</option>
                                <option value="kamis">Kamis</option>
                                <option value="jumat">Jumat</option>
                                <option value="sabtu">Sabtu</option>
                                <option value="minggu">Minggu</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="sks">Jumlah SKS <span aria-hidden="true">*</span></label>
                            <input type="number" id="sks" name="sks" min="1" step="1" placeholder="Contoh: 3" required>
                        </div>

                        <div class="field">
                            <label for="jam_mulai">Jam Mulai <span aria-hidden="true">*</span></label>
                            <input type="time" id="jam_mulai" name="jam_mulai" required>
                        </div>

                        <div class="field">
                            <label for="jam_selesai">Jam Selesai <span aria-hidden="true">*</span></label>
                            <input type="time" id="jam_selesai" name="jam_selesai" required>
                        </div>

                        <div class="field">
                            <label for="ruangan">Ruangan <span aria-hidden="true">*</span></label>
                            <input type="text" id="ruangan" name="ruangan" placeholder="Contoh: Lab Komputer 2" required>
                        </div>

                        <div class="field">
                            <label for="dosen">Dosen Pengampu <span aria-hidden="true">*</span></label>
                            <input type="text" id="dosen" name="dosen" placeholder="Contoh: Budi Santoso, M.Kom." required>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="jadwal.php" class="button button--secondary">Batal</a>
                        <button type="submit" name="submit" class="button button--primary">
                            Simpan Jadwal
                            <span aria-hidden="true">&rarr;</span>
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
