<?php 
include "navbar.php"; 
include "../config.php";

// --- Statistik ---
$totalFoto = $conn->query("SELECT COUNT(*) AS total FROM foto")->fetch_assoc()['total'];
$totalKategori = $conn->query("SELECT COUNT(*) AS total FROM kategori")->fetch_assoc()['total'];
$totalFotografer = $conn->query("SELECT COUNT(*) AS total FROM fotografer")->fetch_assoc()['total'];

// --- Pencarian ---
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// --- Data untuk grafik Donut (kategori) ---
$sqlKategori = "SELECT k.nama_kategori, COUNT(f.id) AS jumlah 
                FROM kategori k 
                LEFT JOIN foto f ON f.kategori_id = k.id
                GROUP BY k.id";
$resKategori = $conn->query($sqlKategori);
$kategoriLabels = [];
$kategoriCounts = [];
while ($row = $resKategori->fetch_assoc()) {
  $kategoriLabels[] = $row['nama_kategori'];
  $kategoriCounts[] = $row['jumlah'];
}

// --- Data untuk grafik Bar (per bulan) ---
$sqlBulan = "SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, COUNT(*) AS jumlah 
             FROM foto 
             GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
             ORDER BY bulan ASC";
$resBulan = $conn->query($sqlBulan);
$bulanLabels = [];
$bulanCounts = [];
while ($row = $resBulan->fetch_assoc()) {
  $bulanLabels[] = $row['bulan'];
  $bulanCounts[] = $row['jumlah'];
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="mb-0">Dashboard Admin</h2>
  <form method="get" action="dashboard.php" class="d-flex" style="max-width: 300px;">
    <input type="text" name="search" 
           class="form-control form-control-sm rounded-pill me-2"
           placeholder="Cari foto..."
           value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit" class="btn btn-sm btn-primary rounded-pill">
      <i class="fa fa-search"></i>
    </button>
  </form>
</div>

<?php if ($search): ?>
  <p class="text-muted">Hasil pencarian untuk: <strong><?php echo htmlspecialchars($search); ?></strong></p>
<?php endif; ?>

<!-- Statistik ringkas -->
<div class="row mb-4">
  <div class="col-md-4">
    <div class="card text-center shadow-sm">
      <div class="card-body">
        <i class="fa-solid fa-image fa-2x text-primary"></i>
        <h5 class="mt-2">Total Foto</h5>
        <h3 class="text-primary"><?php echo $totalFoto; ?></h3>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-center shadow-sm">
      <div class="card-body">
        <i class="fa-solid fa-tags fa-2x text-success"></i>
        <h5 class="mt-2">Kategori</h5>
        <h3 class="text-success"><?php echo $totalKategori; ?></h3>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-center shadow-sm">
      <div class="card-body">
        <i class="fa-solid fa-user fa-2x text-info"></i>
        <h5 class="mt-2">Fotografer</h5>
        <h3 class="text-info"><?php echo $totalFotografer; ?></h3>
      </div>
    </div>
  </div>
</div>

<!-- Grafik -->
<div class="row mb-4">
  <div class="col-lg-6">
    <div class="card shadow-sm chart-card">
      <div class="card-body text-center">
        <h5><i class="fa-solid fa-chart-pie text-danger"></i> Distribusi Foto per Kategori</h5>
        <div style="max-width:400px; margin:auto;">
          <canvas id="donutChart" height="280"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card shadow-sm chart-card">
      <div class="card-body text-center">
        <h5><i class="fa-solid fa-chart-column text-success"></i> Upload Foto per Bulan</h5>
        <div style="max-width:400px; margin:auto;">
          <canvas id="barChart" height="280"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
  <div class="col-md-4">
    <div class="card text-center shadow-sm">
      <div class="card-body">
        <i class="fa-solid fa-upload fa-2x text-primary"></i>
        <h5 class="mt-2">Upload Foto</h5>
        <a href="upload.php" class="btn btn-primary btn-sm">Masuk</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-center shadow-sm">
      <div class="card-body">
        <i class="fa-solid fa-tags fa-2x text-success"></i>
        <h5 class="mt-2">Kategori</h5>
        <a href="kategori.php" class="btn btn-success btn-sm">Masuk</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-center shadow-sm">
      <div class="card-body">
        <i class="fa-solid fa-user fa-2x text-info"></i>
        <h5 class="mt-2">Fotografer</h5>
        <a href="fotografer.php" class="btn btn-info btn-sm text-white">Masuk</a>
      </div>
    </div>
  </div>
</div>

<!-- Foto Terbaru -->
<div class="card shadow-sm" id="fotoTerbaru">
  <div class="card-body">
    <h5><i class="fa-solid fa-clock text-warning"></i> Foto Terbaru</h5>
    <div class="table-responsive">
      <table class="table table-bordered mt-3">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Preview</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Fotografer</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sqlLatest = "SELECT f.*, k.nama_kategori, g.nama_fotografer 
                        FROM foto f 
                        LEFT JOIN kategori k ON f.kategori_id=k.id
                        LEFT JOIN fotografer g ON f.fotografer_id=g.id";

          if ($search) {
            $sqlLatest .= " WHERE f.nama_foto LIKE '%$search%' 
                            OR k.nama_kategori LIKE '%$search%' 
                            OR g.nama_fotografer LIKE '%$search%'";
          }

          $sqlLatest .= " ORDER BY f.id DESC LIMIT 5";
          $resLatest = $conn->query($sqlLatest);

          if ($resLatest->num_rows > 0) {
            $no = 1;
            while ($row = $resLatest->fetch_assoc()) {
              echo "<tr>
                      <td>{$no}</td>
                      <td><img src='../uploads/{$row['file_path']}' width='80' style='height:80px;object-fit:cover;'></td>
                      <td>{$row['nama_foto']}</td>
                      <td>{$row['nama_kategori']}</td>
                      <td>".($row['nama_fotografer'] ?? "-")."</td>
                      <td>{$row['tanggal']}</td>
                    </tr>";
              $no++;
            }
          } else {
            echo "<tr><td colspan='6' class='text-center'>Tidak ada data</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="../dist/js/chart.umd.js"></script>
<script>
console.log("Chart.js loaded?", typeof Chart);

const donutCtx = document.getElementById('donutChart').getContext('2d');
new Chart(donutCtx, {
  type: 'doughnut',
  data: {
    labels: <?php echo json_encode($kategoriLabels); ?>,
    datasets: [{
      data: <?php echo json_encode($kategoriCounts); ?>,
      backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
    }]
  },
  options: { responsive: true, maintainAspectRatio: false }
});

const barCtx = document.getElementById('barChart').getContext('2d');
new Chart(barCtx, {
  type: 'bar',
  data: {
    labels: <?php echo json_encode($bulanLabels); ?>,
    datasets: [{
      label: 'Upload Foto',
      data: <?php echo json_encode($bulanCounts); ?>,
      backgroundColor: '#36A2EB'
    }]
  },
  options: { responsive: true, maintainAspectRatio: false }
});
</script>

</div>

<script>
document.getElementById("toggleSidebar").addEventListener("click", function() {
  document.querySelector(".sidebar").classList.toggle("collapsed");
  document.querySelector(".content").classList.toggle("expanded");
});
</script>

<script>
  // Jika ada parameter search di URL, scroll ke Foto Terbaru
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has("search")) {
    document.getElementById("fotoTerbaru").scrollIntoView({ behavior: "smooth" });
  }
</script>


</body></html>
