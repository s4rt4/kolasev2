<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION["admin"])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <link rel="stylesheet" href="../dist/css/bootstrap.min.css">   <!-- Bootstrap lokal -->
  <link rel="stylesheet" href="../dist/css/all.min.css">         <!-- Font Awesome lokal -->
  <link rel="stylesheet" href="../dist/css/admin.css">

</head>
<body>
  <!-- Tombol Toggle -->
<button class="toggle-btn" id="toggleSidebar">
  <i class="fa-solid fa-bars"></i>
</button>

  <!-- Sidebar -->
  <div class="sidebar d-flex flex-column p-3">
    <h4 class="mb-4"><i class="fa-solid fa-images"></i> Admin Kolase</h4>

    <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF'])=='dashboard.php'?'active':'' ?>">
      <i class="fa-solid fa-house"></i> Dashboard
    </a>
    <a href="upload.php" class="<?= basename($_SERVER['PHP_SELF'])=='upload.php'?'active':'' ?>">
      <i class="fa-solid fa-upload"></i> Upload Foto
    </a>
    <a href="kategori.php" class="<?= basename($_SERVER['PHP_SELF'])=='kategori.php'?'active':'' ?>">
      <i class="fa-solid fa-tags"></i> Kategori
    </a>
    <a href="fotografer.php" class="<?= basename($_SERVER['PHP_SELF'])=='fotografer.php'?'active':'' ?>">
      <i class="fa-solid fa-user"></i> Fotografer
    </a>
    <a href="foto.php" class="<?= basename($_SERVER['PHP_SELF'])=='foto.php'?'active':'' ?>">
      <i class="fa-solid fa-list"></i> Daftar Foto
    </a>
    <a href="admins.php" class="<?= basename($_SERVER['PHP_SELF'])=='admins.php'?'active':'' ?>">
      <i class="fa-solid fa-users-gear"></i> Admin
    </a>

    <hr class="text-white">
    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
  </div>

  <!-- Content -->
  <div class="content">
