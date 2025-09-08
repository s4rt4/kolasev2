<?php
include "config.php";

$res = $conn->query("SELECT * FROM fotografer ORDER BY nama_fotografer ASC");
$data = [];
while ($row = $res->fetch_assoc()) {
  $data[] = $row;
}
echo json_encode($data);
