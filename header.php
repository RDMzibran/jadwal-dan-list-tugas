<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Informasi Jadwal Kuliah</title>
    <link rel="stylesheet" href="style.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js"></script>

    <script>
        // Konfigurasi Firebase milikmu
        const firebaseConfig = {
            apiKey: "AIzaSyAghFvNck1H1H_Yq4Wsr2iwG9kT2utBmFAQ",
            authDomain: "jadwalkuliah-aefbb.firebaseapp.com",
            projectId: "jadwalkuliah-aefbb",
            storageBucket: "jadwalkuliah-aefbb.firebasestorage.app",
            messagingSenderId: "411828073455",
            appId: "1:411828073455:web:15b90e84695871eeca3c1a",
            measurementId: "G-RF7LY35TDG"
        };

        // Inisialisasi Firebase
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        // Registrasi Service Worker & Ambil Token
        if ("serviceWorker" in navigator) {
            navigator.serviceWorker
                .register("firebase-messaging-sw.js")
                .then((registration) => {
                    console.log("Service Worker Firebase aktif!");
                    messaging
                        .getToken({
                            validVapidKey: "BOYsP9MJm52P7LS-tVEI7Eh19hLNOLtTVRhAHzk8WW22VPHRxllUAAXgg87KZIA25-kPCrxSK2MHUvPkW5FtR1w",
                            serviceWorkerRegistration: registration,
                        })
                        .then((currentToken) => {
                            if (currentToken) {
                                console.log("Token Perangkat:", currentToken);
                            }
                        })
                        .catch((err) => {
                            console.log("Gagal ambil token:", err);
                        });
                });
        }

        // Fungsi Polling Pengecekan Tugas (SweetAlert2)
        function cekTugasTerdekat() {
            fetch("cek_notifikasi.php")
                .then((response) => {
                    if (!response.ok) throw new Error("HTTP error " + response.status);
                    return response.json();
                })
                .then((data) => {

                    if (data && data.ada_jadwal) {
                        Swal.fire({
                            title: "📚 Pengingat Kuliah",
                            html: `
                                Mata Kuliah: <b>${data.matkul_jadwal}</b><br>
                                Dosen: <b>${data.dosen_jadwal}</b><br>
                                Jam Mulai: <b>${data.jam_jadwal}</b>
                            `,
                            icon: "info",
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 7000,
                            timerProgressBar: true
                        });
                    }

                    if (data && data.ada_tugas) {
                        Swal.fire({
                            title: "🚨 Pengingat Tugas!",
                            html: `Tugas <b>${data.judul}</b> untuk mata kuliah <b>${data.matkul}</b> harus dikumpul dalam <b>${data.sisa_waktu} jam lagi</b>!`,
                            icon: "warning",
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 7000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener("mouseenter", Swal.stopTimer);
                                toast.addEventListener("mouseleave", Swal.resumeTimer);
                            },
                        });
                    }

                })
                .catch((error) => console.error("Gagal mengecek notifikasi:", error));
        }

        // Jalankan pengecekan setiap 10 detik di halaman mana pun
        setInterval(cekTugasTerdekat, 10000);
        document.addEventListener("DOMContentLoaded", cekTugasTerdekat);
    </script>
</head>
<body>
