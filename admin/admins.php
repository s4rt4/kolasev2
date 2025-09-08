<?php 
include "navbar.php"; 
include "../config.php";

// tambah admin
if (isset($_POST["tambah"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $hash = password_hash($password, PASSWORD_BCRYPT);

  $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
  $stmt->bind_param("ss", $username, $hash);

  if ($stmt->execute()) {
    echo "<div class='alert alert-success mt-3'>Admin baru berhasil ditambahkan!</div>";
  } else {
    echo "<div class='alert alert-danger mt-3'>Gagal menambahkan admin (username mungkin sudah ada).</div>";
  }
}

// hapus admin
if (isset($_GET["hapus"])) {
  $id = intval($_GET["hapus"]);
  $cek = $conn->query("SELECT COUNT(*) as total FROM admin")->fetch_assoc();
  if ($cek['total'] > 1) {
    $conn->query("DELETE FROM admin WHERE id=$id");
    echo "<div class='alert alert-danger mt-3'>Admin berhasil dihapus!</div>";
  } else {
    echo "<div class='alert alert-warning mt-3'>Minimal harus ada 1 admin tersisa!</div>";
  }
}
?>

<h2>Manajemen Admin</h2>

<!-- Form tambah admin -->
<form method="post" class="mt-3 mb-4" style="max-width:400px;">
  <div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" name="username" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <button type="submit" name="tambah" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i> Tambah Admin</button>
</form>

<!-- Tabel daftar admin -->
<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $res = $conn->query("SELECT * FROM admin ORDER BY id DESC");
    while ($row = $res->fetch_assoc()) {
      echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['username']}</td>
        <td>
          <a href='?hapus={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus admin ini?\")'>
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
