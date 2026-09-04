<?php include "header.php"; ?>

<div>
    <h3>Selamat datang di web saya</h3>
    <p>web ini dibuat untuk mengingatkan perkuliahan anda.</p>
</div>
<hr />
<p>fitur yang ada pada web ini yaitu :</p>
<ul>
    <li>Mengingatkan jadwal kuliah</li>
    <li>tidak terlambat saat perkuliahan</li>
    <li>sisanya terserah kalian</li>
</ul>

<p>
    untuk mengakses halaman jadwal perkuliahan silahkan click link dibawah ini.
</p>
<a href="jadwal.php">jadwal perkuliahan</a>

<h3>Alasan terbuatnay web ini</h3>
<p>gabut</p>

<h4>Tentang</h4>
<p>
    web ini menggunakan fitur CRUD dan mysql sebagai database jadi kita bisa mengedit jadwal kita sesukanya
</p>

<script>
// 1. Jalankan fungsi pengecekan pertama kali saat halaman berhasil dimuat
cekNotifikasiOtomatis();

// 2. Set Timer Otomatis: Jalankan fungsi ini setiap 5000 milidetik (5 detik) sekali secara gaib
setInterval(function() {
    cekNotifikasiOtomatis();
}, 5000);

function cekNotifikasiOtomatis() {
    // Tembak file cek_notifikasi.php di latar belakang sistem
    fetch('cek_notifikasi.php')
        .then(response => response.json())
        .then(data => {
            console.log("Sistem memantau database...", data);

            // Jika bot Telegram sukses mengirim pesan dan database diperbarui
            if (data.status === "success" && data.info_tugas && data.info_tugas.includes("berhasil terkirim")) {

                // MELETUPKAN JENDELA POP-OUT DI LAYAR INDEX KAMU
                alert("🚨 PENGINGAT SISTEM:\nAda tugas mepet yang hampir mendekati deadline! Notifikasi pengingat baru saja dikirimkan langsung ke Telegram kamu, Bran. Kelola tugasmu sekarang!");

                // Opsional: Muat ulang halaman index setelah tombol OK di klik agar tampilan dashboard kamu ikut terupdate
                window.location.reload();
            }
        })
        .catch(error => {
            console.error("Gagal melakukan sinkronisasi otomatis:", error);
        });
}
</script>

</body>
</html>
