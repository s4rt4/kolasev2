<?php
include "config.php";

$res = $conn->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
$data = [];
while ($row = $res->fetch_assoc()) {
  $data[] = $row;
}
echo json_encode($data);
