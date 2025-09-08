<?php 
include "navbar.php"; 
include "../config.php";

// Hapus foto
if (isset($_GET["hapus"])) {
  $id = intval($_GET["hapus"]);
  $foto = $conn->query("SELECT file_path FROM foto WHERE id=$id")->fetch_assoc();
  if ($foto) {
    $file = "../uploads/" . $foto["file_path"];
    if (file_exists($file)) unlink($file);
  }
  $conn->query("DELETE FROM foto WHERE id=$id");
  echo "<div class='alert alert-danger mt-3'>Foto berhasil dihapus!</div>";
}

// --- Pagination setup ---
$limit = 10; // jumlah data per halaman
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// --- Pencarian ---
$cari = isset($_GET['cari']) ? $conn->real_escape_string($_GET['cari']) : '';
$where = '';
if (!empty($cari)) {
  $where = "WHERE f.nama_foto LIKE '%$cari%' 
            OR k.nama_kategori LIKE '%$cari%' 
            OR g.nama_fotografer LIKE '%$cari%'";
}

// Hitung total foto (sesuai filter)
$countSql = "SELECT COUNT(*) AS total 
             FROM foto f 
             LEFT JOIN kategori k ON f.kategori_id=k.id
             LEFT JOIN fotografer g ON f.fotografer_id=g.id
             $where";
$countRes = $conn->query($countSql);
$countRow = $countRes->fetch_assoc();
$totalFoto = $countRow['total'];
$totalPages = ceil($totalFoto / $limit);

echo "<h2>Daftar Foto</h2>";
echo "<p><strong>Jumlah foto:</strong> {$totalFoto}</p>";
?>

<!-- Form Pencarian -->
<form method="get" class="mb-3 d-flex">
  <input type="text" name="cari" value="<?php echo htmlspecialchars($cari); ?>" class="form-control me-2" placeholder="Cari nama, kategori, atau fotografer...">
  <button type="submit" class="btn btn-primary"><i class="fa-solid fa-search"></i> Cari</button>
</form>

<table class="table table-bordered table-striped mt-3">
  <thead class="table-dark">
    <tr>
      <th>No</th>
      <th>ID</th>
      <th>Preview</th>
      <th>Nama</th>
      <th>Kategori</th>
      <th>Fotografer</th>
      <th>Tanggal</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT f.*, k.nama_kategori, g.nama_fotografer 
            FROM foto f 
            LEFT JOIN kategori k ON f.kategori_id=k.id
            LEFT JOIN fotografer g ON f.fotografer_id=g.id
            $where
            ORDER BY f.id DESC
            LIMIT $limit OFFSET $offset";
    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
      $no = $offset + 1; // nomor urut sesuai halaman
      while ($row = $res->fetch_assoc()) {
        echo "<tr>
          <td>{$no}</td>
          <td>{$row['id']}</td>
          <td><img src='../uploads/{$row['file_path']}' alt='' width='80' style='height:80px;object-fit:cover;'></td>
          <td>{$row['nama_foto']}</td>
          <td>{$row['nama_kategori']}</td>
          <td>".($row['nama_fotografer'] ?? "-")."</td>
          <td>{$row['tanggal']}</td>
          <td>
            <a href='edit_foto.php?id={$row['id']}' class='btn btn-sm btn-warning'>
              <i class='fa-solid fa-pen'></i> Edit
            </a>
            <a href='?hapus={$row['id']}&page={$page}&cari=".urlencode($cari)."' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus?\")'>
              <i class='fa-solid fa-trash'></i> Hapus
            </a>
          </td>
        </tr>";
        $no++;
      }
    } else {
      echo "<tr><td colspan='8' class='text-center'>Tidak ada data</td></tr>";
    }
    ?>
  </tbody>
</table>

<!-- Pagination -->
<nav>
  <ul class="pagination">
    <?php if ($page > 1): ?>
      <li class="page-item">
        <a class="page-link" href="?page=<?php echo $page-1; ?>&cari=<?php echo urlencode($cari); ?>">Prev</a>
      </li>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
        <a class="page-link" href="?page=<?php echo $i; ?>&cari=<?php echo urlencode($cari); ?>"><?php echo $i; ?></a>
      </li>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
      <li class="page-item">
        <a class="page-link" href="?page=<?php echo $page+1; ?>&cari=<?php echo urlencode($cari); ?>">Next</a>
      </li>
    <?php endif; ?>
  </ul>
</nav>

</div>

<script src="../dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById("toggleSidebar").addEventListener("click", function() {
  document.querySelector(".sidebar").classList.toggle("collapsed");
  document.querySelector(".content").classList.toggle("expanded");
});
</script>


</body></html>
