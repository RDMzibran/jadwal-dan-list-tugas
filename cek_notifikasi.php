<?php
// 1. Paksa PHP menampilkan error jika ada masalah di latar belakang (Anti-Blank)
error_reporting(E_ALL);
ini_set("display_errors", 1);

// 2. Hubungkan ke file koneksi database bawaan project kamu
include "koneksi.php"; // Menggunakan variabel $koneksi asli milikmu

// Set zona waktu ke Indonesia Timur (Sorong) agar sinkron dengan jam laptopmu
date_default_timezone_set("Asia/Jayapura");
$jam_sekarang = date("H:i:s");

// Deklarasikan header JSON agar bisa dibaca sempurna oleh AJAX di halaman index
header("Content-Type: application/json");

$response_output = [
    "status" => "success",
    "message" => "Proses pengecekan selesai dijalankan.",
];

// Data Akses Telegram BARU yang Sudah Kamu Buat & Di-start
$botToken = "8245191677:AAGZS0HAQs8lKWHUREEHErnNOdcXKLoW-qY";
$chatId = "6257906135";

// Ambil data hari lokal untuk pengecekan jadwal kuliah otomatis
$hari_ini = strtolower(date("l"));
$daftar_hari = [
    "sunday" => "minggu",
    "monday" => "senin",
    "tuesday" => "selasa",
    "wednesday" => "rabu",
    "thursday" => "kamis",
    "friday" => "jumat",
    "saturday" => "sabtu",
];
$hari_lokal = $daftar_hari[$hari_ini];

// ==========================================
// KONDISI 1: CEK JADWAL KULIAH HARI INI
// ==========================================
$query_jadwal = "SELECT * FROM jadwal
                 WHERE hari = '$hari_lokal'
                 AND TIMEDIFF(jam_mulai, '$jam_sekarang')
                 BETWEEN '00:00:00' AND '00:30:00'";

$res_jadwal = mysqli_query($koneksi, $query_jadwal);

while ($row_jadwal = mysqli_fetch_assoc($res_jadwal)) {
    $response_output["ada_jadwal"] = true;
    $response_output["matkul_jadwal"] = $row_jadwal["matkul"];
    $response_output["dosen_jadwal"] = $row_jadwal["dosen"];
    $response_output["jam_jadwal"] = substr($row_jadwal["jam_mulai"], 0, 5);

    $pesan_jadwal = "📚 *PENGINGAT KULIAH HARI INI!*\n\n";
    $pesan_jadwal .= "Mata Kuliah: *" . ucwords($row_jadwal["matkul"]) . "*\n";
    $pesan_jadwal .= "Dosen: " . $row_jadwal["dosen"] . "\n";
    $pesan_jadwal .=
        "Jam: *" . substr($row_jadwal["jam_mulai"], 0, 5) . "* WIT\n";

    kirimTelegram($botToken, $chatId, $pesan_jadwal);
}

// =======================================================
// KONDISI 2: CEK TUGAS YANG MENDEKATI DEADLINE (OTOMATIS)
// =======================================================
// Mengembalikan kueri ke mode dinamis agar melacak tugas yang belum dinotif
$query_tugas = "SELECT t.*, j.matkul FROM tugas t
                JOIN jadwal j ON t.jadwal_id = j.id
                WHERE t.status = 'belum' AND t.is_notified = 0 LIMIT 1";

$res_tugas = mysqli_query($koneksi, $query_tugas);

if (!$res_tugas) {
    echo json_encode([
        "status" => "error",
        "message" => "Kueri SQL Error: " . mysqli_error($koneksi),
    ]);
    exit();
}

$data_tugas = mysqli_fetch_assoc($res_tugas);

if ($data_tugas) {
    $waktu_deadline = strtotime($data_tugas["deadline"]);
    $waktu_sekarang = time();
    $selisih_jam = ($waktu_deadline - $waktu_sekarang) / 3600;

    // Jika deadline sisa kurang dari atau sama dengan 6 jam, kirim notif
    if ($selisih_jam > 0 && $selisih_jam <= 6) {
        $response_output["ada_tugas"] = true;
        $response_output["judul"] = $data_tugas["judul_tugas"];
        $response_output["matkul"] = $data_tugas["matkul"];
        $response_output["sisa_waktu"] = round($selisih_jam, 1);

        $pesan_tugas = "🚨 *PENGINGAT TUGAS KULIAH!*\n\n";
        $pesan_tugas .=
            "Mata Kuliah: *" . ucwords($data_tugas["matkul"]) . "*\n";
        $pesan_tugas .= "Tugas: *" . $data_tugas["judul_tugas"] . "*\n";
        $pesan_tugas .= "Deadline: *" . $data_tugas["deadline"] . "*\n\n";
        $pesan_tugas .=
            "Segera selesaikan tugasmu sebelum batas waktu, Bran! 💻🔥";

        // Eksekusi pengiriman ke Telegram
        $result_telegram = kirimTelegram($botToken, $chatId, $pesan_tugas);

        // Decode respon dari Telegram untuk melacak status sukses/gagal
        $res_fwd = json_decode($result_telegram, true);

        if (isset($res_fwd["ok"]) && $res_fwd["ok"] == true) {
            $tugas_id = $data_tugas["id"];
            // Update status ke 1 setelah Telegram benar-benar sukses menerima pesan
            mysqli_query(
                $koneksi,
                "UPDATE tugas SET is_notified = 1 WHERE id = $tugas_id",
            );
            $response_output["info_tugas"] =
                "Notifikasi berhasil terkirim ke Telegram BARU dan database diperbarui!";
        } else {
            $response_output["info_tugas"] =
                "Telegram menolak pesan. Log respons: " . $result_telegram;
        }
    } else {
        $response_output["info_tugas"] =
            "Ada tugas, tetapi sisa waktu belum masuk rentang 6 jam. Sisa waktu: " .
            round($selisih_jam, 2) .
            " jam.";
    }
} else {
    $response_output["info_tugas"] =
        "Tidak ada tugas dengan status 'belum' dan is_notified = 0.";
}

// Cetak output JSON murni ke layar browser
echo json_encode($response_output);

// ====================================================================
// FUNGSI UTAMA CURL TELEGRAM (VERSI TERBARU - ANTI REJECT 401)
// ====================================================================
function kirimTelegram($token, $chat_id, $text)
{
    $url = "https://api.telegram.org/bot" . trim($token) . "/sendMessage";

    $postData = http_build_query([
        "chat_id" => trim($chat_id),
        "text" => $text,
        "parse_mode" => "Markdown",
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Header wajib untuk mengamankan autentikasi token API Telegram
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/x-www-form-urlencoded",
    ]);

    // Bypass SSL lokal komputer agar request XAMPP/Laragon ke luar lancar
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
?>
