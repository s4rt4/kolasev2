<?php
include "config.php";

$kategori = $_GET['kategori'] ?? '';
$fotografer = $_GET['fotografer'] ?? '';
$cari = $_GET['cari'] ?? '';
$tanggal = $_GET['tanggal'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
$offset = ($page - 1) * $limit;

$sql = "SELECT f.*, k.nama_kategori, g.nama_fotografer 
        FROM foto f
        LEFT JOIN kategori k ON f.kategori_id = k.id
        LEFT JOIN fotografer g ON f.fotografer_id = g.id
        WHERE 1";

$params = [];
$types = "";

if ($kategori) {
  $sql .= " AND f.kategori_id = ?";
  $params[] = $kategori;
  $types .= "i";
}
if ($fotografer) {
  $sql .= " AND f.fotografer_id = ?";
  $params[] = $fotografer;
  $types .= "i";
}
if ($cari) {
  $sql .= " AND f.nama_foto LIKE ?";
  $params[] = "%$cari%";
  $types .= "s";
}
if ($tanggal) {
  $sql .= " AND f.tanggal = ?";
  $params[] = $tanggal;
  $types .= "s";
}

$sql .= " ORDER BY f.id DESC LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$types .= "ii";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$fotos = [];
while ($row = $result->fetch_assoc()) {
  $row['file_url'] = "uploads/" . $row['file_path'];
  $fotos[] = $row;
}

header("Content-Type: application/json");
echo json_encode($fotos);
