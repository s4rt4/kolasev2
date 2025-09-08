<?php 
include "navbar.php"; 
include "../config.php";

// tambah kategori
if (isset($_POST["tambah"])) {
  $nama = $_POST["nama"];
  $stmt = $conn->prepare("INSERT INTO kategori (nama_kategori) VALUES (?)");
  $stmt->bind_param("s", $nama);
  $stmt->execute();
  echo "<div class='alert alert-success mt-3'>Kategori berhasil ditambahkan!</div>";
}

// hapus kategori
if (isset($_GET["hapus"])) {
  $id = intval($_GET["hapus"]);
  $conn->query("DELETE FROM kategori WHERE id=$id");
  echo "<div class='alert alert-danger mt-3'>Kategori berhasil dihapus!</div>";
}
?>

<h2>Manajemen Kategori</h2>

<form method="post" class="mt-3 mb-4 d-flex">
  <input type="text" name="nama" placeholder="Nama kategori" class="form-control me-2" required>
  <button type="submit" name="tambah" class="btn btn-success"><i class="fa-solid fa-plus"></i> Tambah</button>
</form>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Nama Kategori</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $res = $conn->query("SELECT * FROM kategori ORDER BY id DESC");
    while ($row = $res->fetch_assoc()) {
      echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['nama_kategori']}</td>
        <td>
          <a href='?hapus={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus?\")'>
            <i class='fa-solid fa-trash'></i> Hapus
          </a>
        </td>
      </tr>";
    }
    ?>
  </tbody>
</table>

</div>

<script>
document.getElementById("toggleSidebar").addEventListener("click", function() {
  document.querySelector(".sidebar").classList.toggle("collapsed");
  document.querySelector(".content").classList.toggle("expanded");
});
</script>


</body></html>
