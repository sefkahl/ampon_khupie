<?php
if (strpos($_SERVER['SCRIPT_NAME'], 'modul/gagal/') !== false) {
    header('HTTP/1.1 404 Not Found');
    $gagal_base = dirname(dirname(dirname($_SERVER['SCRIPT_NAME'])));
    $home = $gagal_base . '/index.php';
    ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AMPON KUPHIE | 404</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="<?php echo $gagal_base; ?>/plugins/fontawesome-free/css/all.min.css?v=2">
  <link rel="stylesheet" href="<?php echo $gagal_base; ?>/dist/css/adminlte.min.css?v=2">
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
      font-size: 6rem;
      font-weight: bold;
      margin-bottom: 1rem;
      color: #007bff;
    }

    .error-content p {
      font-size: 1.5rem;
      margin-bottom: 2rem;
      color: #6c757d;
    }

    .lottie-animation {
      max-width: 400px;
      margin-bottom: 2rem;
    }

    .lottie-animation i {
      font-size: 7rem;
      color: #f39c12;
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
    <div class="lottie-animation" id="lottie-404">
      <i class="fas fa-exclamation-triangle text-warning"></i>
    </div>
    <div class="error-content">
      <h1>404</h1>
      <p>Oops! Halaman Tidak Ditemukan</p>
      <p style="font-size: 1rem;">Silahkan Klik Tombol Home.</p>
      <a href="<?php echo $home; ?>" class="btn btn-outline-primary">
        <i class="fas fa-home"></i> Home
      </a>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.6/lottie.min.js"></script>
  <script>
    if (typeof lottie !== 'undefined') {
      var gagalLottie = document.getElementById('lottie-404');
      gagalLottie.innerHTML = '';
      lottie.loadAnimation({
        container: gagalLottie,
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: 'https://assets9.lottiefiles.com/packages/lf20_lk80fpsm.json'
      });
    }
  </script>
</body>

</html>
    <?php
    die();
}
?>
<style>
    .gagal-wrapper {
        text-align: center;
        padding: 3rem 1rem;
    }

    .gagal-wrapper h1 {
        font-size: 4rem;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 0.5rem;
    }

    .gagal-wrapper p {
        font-size: 1.3rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .gagal-wrapper .btn {
        padding: 0.6rem 1.8rem;
        border-radius: 2rem;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.25);
    }
</style>
<div class="col-md-12">
    <div class="gagal-wrapper">
        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
        <h1>404</h1>
        <p>Oops! Halaman Tidak Ditemukan</p>
        <p style="font-size: 1rem;">Silahkan Klik Tombol Home.</p>
        <a href="?page=beranda" class="btn btn-outline-primary">
            <i class="fas fa-home mr-2"></i>Home
        </a>
    </div>
</div>
