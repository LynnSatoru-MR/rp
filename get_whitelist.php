<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Konfigurasi database (sama dengan di atas)
$host = "localhost";
$user = "your_username";
$pass = "your_password";
$dbname = "your_database";
$table = "whitelist_data";

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Koneksi database gagal: " . $conn->connect_error]));
}

// Query untuk mengambil data
$sql = "SELECT rp_name, email, register_date, status FROM $table ORDER BY register_date DESC";
$result = $conn->query($sql);

$whitelists = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $whitelists[] = $row;
    }
    echo json_encode(["success" => true, "whitelists" => $whitelists]);
} else {
    echo json_encode(["success" => true, "whitelists" => []]);
}

$conn->close();
?>