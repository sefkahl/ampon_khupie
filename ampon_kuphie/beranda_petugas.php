  <?php 
  include 'koneksi.php';
  include 'valid_petugas.php';
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Beranda Petugas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css?v=2">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css?v=2">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css?v=2">
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css?v=2">
  <link rel="stylesheet" href="dist/css/adminlte.min.css?v=2">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css?v=2">
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css?v=2">
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css?v=2">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css?v=2">
  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css?v=2">
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css?v=2">
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css?v=2">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css?v=2">
  <style>
    .sidebar .nav-icon{
      font-size: 0.9rem !important;
    }

    
    @keyframes blink_status {
      50% { opacity: 0; }
    }
    .status-online {
      animation: blink_status 1s linear infinite;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed text-sm layout-navbar-fixed layout-footer-fixed sidebar-collapse">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link text-blak d-flex align-items-center font-weight-bold" data-toggle="dropdown" href="#">
           PROFIL - <?php echo isset($_SESSION['nama']) && $_SESSION['nama'] != '' ? $_SESSION['nama'] : 'Login Petugas'; ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="beranda_petugas.php?page=profil" class="dropdown-item">
            <div class="media">
              <div class="media-body">
                <h3 class="dropdown-item-title">Profil</h3>
                <p class="text-sm">Lihat Profil Saya</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="beranda_petugas.php?page=ubah_password" class="dropdown-item">
            <div class="media">
              <div class="media-body">
                <h3 class="dropdown-item-title">Ubah Password</h3>
                <p class="text-sm">Ganti Password Akun</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="keluar_petugas.php" class="dropdown-item">
            <div class="media">
              <div class="media-body">
                <h3 class="dropdown-item-title">Logout</h3> 
                <p class="text-sm">Keluar dari Sistem</p>
              </div>
            </div>
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <aside class="main-sidebar text-sm sidebar-dark-primary elevation-1">
      <a href="beranda_petugas.php?page=beranda" class="brand-link">
      <img src="gambar/logo.jpg" alt="Ampon Kuphi" class="brand-image img-circle elevation-1">
      <span class="brand-text font-weight-light">AMPON KUPHIE</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 d-flex">
        <div class="image">
          <?php $nama_avatar = isset($_SESSION['nama']) && $_SESSION['nama'] != '' ? $_SESSION['nama'] : 'Login Petugas'; ?>
          <div class="d-inline-flex justify-content-center align-items-center rounded-circle bg-primary"
            style="width: 40px; height: 40px; font-size: 18px;">
            <?php echo strtoupper(substr(trim($nama_avatar), 0, 1)); ?>
          </div>
        </div>
        <div class="info">
          <a href="beranda_petugas.php?page=profil" class="d-block"><?php echo isset($_SESSION['nama']) && $_SESSION['nama'] != '' ? $_SESSION['nama'] : 'Login Petugas'; ?></a>
          <span class="d-block text-success">
            <i class="fas fa-circle status-online mr-1" style="font-size: 9px;"></i>
            Online
          </span>
        </div>
      </div>
      <nav class="mt-2">
        <?php $menu_aktif = isset($_GET['page']) ? $_GET['page'] : 'beranda'; ?>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview">
            <a href="beranda_petugas.php?page=beranda" class="nav-link <?= $menu_aktif == 'beranda' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-home"></i><p> Dashboard </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="beranda_petugas.php?page=barang" class="nav-link <?= $menu_aktif == 'barang' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-th"></i><p>
                Data Barang
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
          </li>
          
          <li class="nav-item has-treeview <?= in_array($menu_aktif, ['barang_masuk', 'barang_keluar']) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= in_array($menu_aktif, ['barang_masuk', 'barang_keluar']) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-shopping-bag"></i><p>
                Transaksi
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="beranda_petugas.php?page=barang_masuk" class="nav-link <?= $menu_aktif == 'barang_masuk' ? 'active' : '' ?>"><i class="fas fa-gavel nav-icon"></i> <p>Barang Masuk</p></a></li>
              <li class="nav-item"><a href="beranda_petugas.php?page=barang_keluar" class="nav-link <?= $menu_aktif == 'barang_keluar' ? 'active' : '' ?>"><i class="fas fa-gavel nav-icon"></i> <p>Brang Keluar</p></a></li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?= in_array($menu_aktif, ['ubah_password']) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= in_array($menu_aktif, ['ubah_password']) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-tasks"></i><p>
                Setting
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="beranda_petugas.php?page=ubah_password" class="nav-link <?= $menu_aktif == 'ubah_password' ? 'active' : '' ?>"><i class="fas fa-key nav-icon"></i> <p>Ubah Password</p></a></li>
              <li class="nav-item"><a href="keluar_petugas.php" class="nav-link"><i class="fas fa-sign-out-alt nav-icon"></i> <p>Logout</p></a></li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
           <?php

          if (isset($_GET['page'])) {
            $page = $_GET['page'];
            switch ($page) {

              case 'beranda':
                include "modul/halaman_utama/index.php";
                break;

              case 'barang':
                include "modul/barang/index.php";
                break;
              case 'tambah_barang':
                include "modul/barang/tambah.php";
                break;
              case 'edit_barang':
                include "modul/barang/edit.php";
                break;
              case 'ubah_password':
                include "modul/user/ubah_password.php";
                break;
              case 'profil':
                include "modul/user/profil.php";
                break;
              case 'barang_masuk':
                include "modul/barang_masuk/index.php";
                break;
              case 'tambah_barang_masuk':
                include "modul/barang_masuk/tambah.php";
                break;
              case 'edit_barang_masuk':
                include "modul/barang_masuk/edit.php";
                break;
              case 'barang_keluar':
                include "modul/barang_keluar/index.php";
                break;
              case 'tambah_barang_keluar':
                include "modul/barang_keluar/tambah.php";
                break;
              case 'edit_barang_keluar':
                include "modul/barang_keluar/edit.php";
                break;

              default:
                include "modul/gagal/index.php";
                break;
            }
          } else {
            include "modul/halaman_utama/index.php";
          }
          ?>
      </div><!-- /.container-fluid -->
    </section>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2026-2027 <a href="#">TUGAS AKHIR : </a> Judul</strong> <br>
   PERANCANGAN SISTEM INFORMASI AKUNTANSI
PERSEDIAAN BAHAN HABIS PAKAI DENGAN
METODE AVERAGE PADA AMPON KUPHIE

    <div class="float-right d-none d-sm-inline-block">
      <b><?php echo date('d F Y'); ?></b>
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js?v=2"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js?v=2"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js?v=2"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js?v=2"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js?v=2"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js?v=2"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js?v=2"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js?v=2"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js?v=2"></script>
<script src="plugins/daterangepicker/daterangepicker.js?v=2"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js?v=2"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js?v=2"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js?v=2"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js?v=2"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js?v=2"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js?v=2"></script>

//Data Tables

<script src="plugins/datatables/jquery.dataTables.min.js?v=2"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js?v=2"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js?v=2"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js?v=2"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": true,
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": true,
    });
  });
</script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js?v=2"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js?v=2"></script>


<script>
  toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-right",
    timeOut: 3000,
    extendedTimeOut: 1000,
    preventDuplicates: true
  };
</script>


</body>
</html>
