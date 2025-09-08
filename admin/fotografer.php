<?php 
include "navbar.php"; 
include "../config.php";

// tambah fotografer
if (isset($_POST["tambah"])) {
  $nama = $_POST["nama"];
  $stmt = $conn->prepare("INSERT INTO fotografer (nama_fotografer) VALUES (?)");
  $stmt->bind_param("s", $nama);
  $stmt->execute();
  echo "<div class='alert alert-success mt-3'>Fotografer berhasil ditambahkan!</div>";
}

// hapus fotografer
if (isset($_GET["hapus"])) {
  $id = intval($_GET["hapus"]);
  $conn->query("DELETE FROM fotografer WHERE id=$id");
  echo "<div class='alert alert-danger mt-3'>Fotografer berhasil dihapus!</div>";
}
?>

<h2>Manajemen Fotografer</h2>

<form method="post" class="mt-3 mb-4 d-flex">
  <input type="text" name="nama" placeholder="Nama fotografer" class="form-control me-2" required>
  <button type="submit" name="tambah" class="btn btn-success"><i class="fa-solid fa-plus"></i> Tambah</button>
</form>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Nama Fotografer</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $res = $conn->query("SELECT * FROM fotografer ORDER BY id DESC");
    while ($row = $res->fetch_assoc()) {
      echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['nama_fotografer']}</td>
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
