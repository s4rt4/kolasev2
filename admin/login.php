<?php
session_start();
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $stmt = $conn->prepare("SELECT * FROM admin WHERE username=?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();

  if ($result && password_verify($password, $result["password"])) {
    $_SESSION["admin"] = $result["id"];
    header("Location: dashboard.php");
    exit();
  } else {
    $error = "Username atau password salah!";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <style>
    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #6a11cb, #2575fc);
    }
    .login-card {
      width: 100%;
      max-width: 400px;
      border-radius: 12px;
    }
  </style>
</head>
<body>

<div class="card shadow-lg p-4 login-card">
  <h3 class="text-center mb-4 text-primary"><i class="fa-solid fa-user-shield"></i> Login Admin</h3>
  
  <?php if (isset($error)) : ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" required autofocus>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">
      <i class="fa-solid fa-right-to-bracket"></i> Login
    </button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
