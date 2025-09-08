<?php
include "navbar.php"; // ✅ sidebar + navbar admin
include "../config.php";

// Ambil ID foto
if (!isset($_GET["id"])) {
  echo "<div class='alert alert-danger'>ID foto tidak ditemukan.</div>";
  exit;
}

$id = intval($_GET["id"]);

// Ambil data foto
$res = $conn->query("SELECT * FROM foto WHERE id=$id");
if ($res->num_rows == 0) {
  echo "<div class='alert alert-danger'>Foto tidak ditemukan.</div>";
  exit;
}
$foto = $res->fetch_assoc();

// Update data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nama_foto = $conn->real_escape_string($_POST["nama_foto"]);
  $kategori_id = intval($_POST["kategori_id"]);
  $fotografer_id = intval($_POST["fotografer_id"]);
  $tanggal = $conn->real_escape_string($_POST["tanggal"]);

  $sql = "UPDATE foto 
          SET nama_foto='$nama_foto', kategori_id=$kategori_id, fotografer_id=$fotografer_id, tanggal='$tanggal'
          WHERE id=$id";

  if ($conn->query($sql)) {
    echo "<div class='alert alert-success mt-3'>Data foto berhasil diperbarui!</div>";
    $res = $conn->query("SELECT * FROM foto WHERE id=$id");
    $foto = $res->fetch_assoc();
  } else {
    echo "<div class='alert alert-danger mt-3'>Gagal update data: " . $conn->error . "</div>";
  }
}

// Ambil data kategori & fotografer untuk dropdown
$kategoriRes = $conn->query("SELECT * FROM kategori ORDER BY nama_kategori");
$fotograferRes = $conn->query("SELECT * FROM fotografer ORDER BY nama_fotografer");
?>

<div class="container mt-4">
  <h2>Edit Foto</h2>

  <form method="post" class="mt-3">
    <div class="mb-3">
      <label class="form-label">Nama Foto</label>
      <input type="text" name="nama_foto" class="form-control" value="<?php echo htmlspecialchars($foto['nama_foto']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Kategori</label>
      <select name="kategori_id" class="form-select" required>
        <option value="">-- Pilih Kategori --</option>
        <?php while ($k = $kategoriRes->fetch_assoc()) { ?>
          <option value="<?php echo $k['id']; ?>" <?php if ($k['id'] == $foto['kategori_id']) echo "selected"; ?>>
            <?php echo $k['nama_kategori']; ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Fotografer</label>
      <select name="fotografer_id" class="form-select" required>
        <option value="">-- Pilih Fotografer --</option>
        <?php while ($g = $fotograferRes->fetch_assoc()) { ?>
          <option value="<?php echo $g['id']; ?>" <?php if ($g['id'] == $foto['fotografer_id']) echo "selected"; ?>>
            <?php echo $g['nama_fotografer']; ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Tanggal</label>
      <input type="date" name="tanggal" class="form-control" value="<?php echo $foto['tanggal']; ?>" required>
    </div>

    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Simpan</button>
    <a href="foto.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>

<script src="../dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById("toggleSidebar").addEventListener("click", function() {
  document.querySelector(".sidebar").classList.toggle("collapsed");
  document.querySelector(".content").classList.toggle("expanded");
});
</script>


</body></html>
