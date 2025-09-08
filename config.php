<?php
$host = "localhost";
$user = "root"; // ganti sesuai setting MySQL kamu
$pass = "";
$db   = "kolase_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
