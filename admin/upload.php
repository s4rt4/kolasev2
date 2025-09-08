<?php 
include "navbar.php"; 
include "../config.php";

$msg = "";

// proses upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama_foto = $_POST["nama_foto"];
  $kategori = $_POST["kategori"];
  $fotografer = !empty($_POST["fotografer"]) ? $_POST["fotografer"] : null;
  $tanggal = !empty($_POST["tanggal"]) ? $_POST["tanggal"] : date("Y-m-d");

  // simpan file ke folder /uploads
  $targetDir = "../uploads/";
  if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
  }

  $fileName = time() . "_" . basename($_FILES["file"]["name"]);
  $targetFile = $targetDir . $fileName;

  if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
    $stmt = $conn->prepare("INSERT INTO foto (nama_foto, file_path, tanggal, kategori_id, fotografer_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $nama_foto, $fileName, $tanggal, $kategori, $fotografer);
    $stmt->execute();
    $msg = "✅ Foto berhasil diupload!";
  } else {
    $msg = "❌ Gagal upload foto.";
  }
}
?>

<h2>Upload Foto</h2>
<?php if ($msg) echo "<div class='alert alert-info mt-3'>$msg</div>"; ?>

<form method="post" enctype="multipart/form-data" class="mt-3" style="max-width:600px;">
  <div class="mb-3">
    <label class="form-label">Nama Foto</label>
    <input type="text" name="nama_foto" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="kategori" class="form-select" required>
      <option value="">-- Pilih Kategori --</option>
      <?php
      $res = $conn->query("SELECT * FROM kategori");
      while ($row = $res->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['nama_kategori']}</option>";
      }
      ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Fotografer</label>
    <select name="fotografer" class="form-select">
      <option value="">-- Pilih Fotografer --</option>
      <?php
      $res = $conn->query("SELECT * FROM fotografer");
      while ($row = $res->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['nama_fotografer']}</option>";
      }
      ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Tanggal</label>
    <input type="date" name="tanggal" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">File Foto</label>
    <input type="file" name="file" class="form-control" accept="image/*" required>
  </div>
  <button type="submit" class="btn btn-primary"><i class="fa-solid fa-upload"></i> Upload</button>
</form>

</div>

<script>
document.getElementById("toggleSidebar").addEventListener("click", function() {
  document.querySelector(".sidebar").classList.toggle("collapsed");
  document.querySelector(".content").classList.toggle("expanded");
});
</script>


</body></html>
