<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Konfigurasi database
$host = "209.97.167.247";
$user = "u13_wncCnUDG48";
$pass = "=n!89PXDRC7wpZb+OS+^tRLd";
$dbname = "s13_Indo";
$table = "whitelist_data";

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Koneksi database gagal: " . $conn->connect_error]));
}

// Ambil data dari request
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Data tidak valid"]);
    exit;
}

// Bersihkan data
$rp_name = $conn->real_escape_string($data['rp_name']);
$password = password_hash($conn->real_escape_string($data['password']), PASSWORD_DEFAULT);
$email = $conn->real_escape_string($data['email']);
$register_date = $conn->real_escape_string($data['register_date']);
$status = $conn->real_escape_string($data['status']);

// Query untuk memasukkan data
$sql = "INSERT INTO $table (rp_name, password, email, register_date, status) 
        VALUES ('$rp_name', '$password', '$email', '$register_date', '$status')";

if ($conn->query($sql) {
    echo json_encode(["success" => true, "message" => "Data whitelist berhasil disimpan"]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
}

$conn->close();

?>
