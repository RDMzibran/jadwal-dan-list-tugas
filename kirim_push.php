<?php
// 1. Hubungkan ke file koneksi database bawaan project kamu
include "koneksi.php";

// Set zona waktu agar penghitungan selisih jamnya sinkron dengan laptopmu
date_default_timezone_set("Asia/Jayapura");
$jam_sekarang = date("Y-m-d H:i:s");

// 2. Ambil data tugas mepet (selisih jam deadline dengan jam sekarang sisa 0 sampai 6 jam)
// Menggunakan JOIN jadwal agar bisa mengambil nama mata kuliah secara akurat
$query = "SELECT t.*, j.matkul FROM tugas t
          JOIN jadwal j ON t.jadwal_id = j.id
          WHERE t.status = 'belum'
          AND t.is_notified = 0
          AND TIMESTAMPDIFF(HOUR, '$jam_sekarang', t.deadline) BETWEEN 0 AND 6
          LIMIT 1";

$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if ($data) {
    // Ambil Token Perangkat yang tercetak di console browser kamu saat halaman dibuka
    $deviceToken = "PASTE_TOKEN_PERANGKAT_KAMU_YANG_DARI_CONSOLE_DISINI";

    // Project ID Firebase kamu
    $projectId = "jadwalkuliah-aefbb";

    // URL Endpoint Firebase Cloud Messaging v1
    $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

    // Token OAuth2 dari Google Auth helper/Service Account JSON
    $accessToken = "MASUKKAN_ACCESS_TOKEN_OAUTH2_KAMU";

    $message = [
        "message" => [
            "token" => $deviceToken,
            "notification" => [
                "title" => "🚨 Pengingat Tugas Kuliah!",
                "body" =>
                    "Tugas '" .
                    $data["judul_tugas"] .
                    "' untuk matkul " .
                    ucwords($data["matkul"]) .
                    " harus dikumpul mepet waktu!",
            ],
        ],
    ];

    $options = [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . $accessToken,
            "Content-Type: application/json",
        ],
        CURLOPT_POSTFIELDS => json_encode($message),
        CURLOPT_RETURNTRANSFER => true,
        // Keamanan Tambahan: Bypass SSL di Localhost XAMPP Windows
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    ];

    $ch = curl_init();
    curl_setopt_array($ch, $options);

    // FIX UTAMA: Eksekusi pengiriman data cURL ke Firebase Cloud Messaging
    $response = curl_exec($ch);

    // Periksa status pengiriman
    if ($response === false) {
        echo "Gagal mengirim Push Notif. Error cURL: " . curl_error($ch);
    } else {
        // Jika sukses, ubah is_notified agar tidak terkirim terus-menerus
        $tugas_id = $data["id"];
        mysqli_query(
            $koneksi,
            "UPDATE tugas SET is_notified = 1 WHERE id = $tugas_id",
        );
        echo "Push notification berhasil dikirim ke latar belakang sistem. Respon: " .
            $response;
    }

    curl_close($ch);
} else {
    echo "Sistem: Tidak ada data tugas mepet yang perlu dikirim push notif saat ini.";
}
?>
