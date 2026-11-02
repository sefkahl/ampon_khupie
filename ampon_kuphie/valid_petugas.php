<?php
session_start();

if (isset($_SESSION['username']) && $_SESSION['role'] != 'Petugas') {
    if ($_SESSION['role'] == 'Owner') {
        header('Location: beranda_owner.php');
    } else {
        header('Location: beranda.php');
    }
    exit;
}

if (!isset($_SESSION['username'])) {
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AMPON KUPHIE | Harap Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css?v=2">
  <link rel="stylesheet" href="dist/css/adminlte.min.css?v=2">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    .error-container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: #f8f9fa;
    }

    .error-content {
      text-align: center;
    }

    .error-content h1 {
      font-size: 3.5rem;
      font-weight: bold;
      margin-bottom: 1rem;
      color: #007bff;
    }

    .error-content p {
      font-size: 1.5rem;
      margin-bottom: 2rem;
      color: #6c757d;
    }

    .lock-icon {
      width: 140px;
      height: 140px;
      background-color: #e7f1ff;
      border-radius: 50%;
      display: inline-flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 2rem;
    }

    .error-content .btn {
      padding: 0.6rem 1.8rem;
      border-radius: 2rem;
      box-shadow: 0 2px 8px rgba(0, 123, 255, 0.25);
    }
  </style>
</head>
<body>
  <div class="error-container">
    <div class="lock-icon">
      <i class="fas fa-lock text-primary" style="font-size: 5rem;"></i>
    </div>
    <div class="error-content">
      <h1>Harap Login</h1>
      <p>Belum Login — Silakan login untuk mengakses halaman ini</p>
      <p style="font-size: 1rem;">Anda harus login terlebih dahulu</p>
      <a href="login_petugas.php" class="btn btn-outline-primary">
        <i class="fas fa-sign-in-alt"></i> Login Sekarang
      </a>
    </div>
  </div>
</body>
</html>
<?php
    die();
}
?>
