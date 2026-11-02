<?php
$total_barang = mysqli_fetch_array(mysqli_query($konek, "SELECT COUNT(*) FROM tbl_barang"))[0];
$total_masuk = mysqli_fetch_array(mysqli_query($konek, "SELECT COUNT(*) FROM tbl_barang_masuk"))[0];
$total_keluar = mysqli_fetch_array(mysqli_query($konek, "SELECT COUNT(*) FROM tbl_barang_keluar"))[0];
$nilai_persediaan = mysqli_fetch_array(mysqli_query($konek, "SELECT IFNULL(SUM(stok * harga_average), 0) FROM tbl_barang"))[0];
$total_stok = mysqli_fetch_array(mysqli_query($konek, "SELECT IFNULL(SUM(stok), 0) FROM tbl_barang"))[0];
$stok_menipis = mysqli_fetch_array(mysqli_query($konek, "SELECT COUNT(*) FROM tbl_barang WHERE stok <= 10"))[0];
$total_supplier = mysqli_fetch_array(mysqli_query($konek, "SELECT COUNT(*) FROM tbl_supplier"))[0];
$harga_average = $total_stok > 0 ? round($nilai_persediaan / $total_stok, 2) : 0;
$nilai_masuk_bulan = mysqli_fetch_array(mysqli_query($konek, "SELECT IFNULL(SUM(jumlah * harga_beli), 0) FROM tbl_barang_masuk WHERE MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())"))[0];
$nilai_keluar_bulan = mysqli_fetch_array(mysqli_query($konek, "SELECT IFNULL(SUM(jumlah * harga_pokok), 0) FROM tbl_barang_keluar WHERE MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())"))[0];
?>
<div class="col-12">
  <div class="row">
    <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3><?php echo $total_barang; ?></h3>
          <p>Total Barang</p>
        </div>
        <div class="icon">
          <i class="fas fa-boxes"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3><?php echo $total_masuk; ?></h3>
          <p>Barang Masuk</p>
        </div>
        <div class="icon">
          <i class="fas fa-sign-in-alt"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3><?php echo $total_keluar; ?></h3>
          <p>Barang Keluar</p>
        </div>
        <div class="icon">
          <i class="fas fa-sign-out-alt"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3><?php echo 'Rp ' . number_format($nilai_persediaan, 0, ',', '.'); ?></h3>
          <p>Nilai Persediaan</p>
        </div>
        <div class="icon">
          <i class="fas fa-coins"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3><?php echo $total_stok; ?></h3>
          <p>Total Stok</p>
        </div>
        <div class="icon">
          <i class="fas fa-box-open"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-maroon">
        <div class="inner">
          <h3><?php echo $stok_menipis; ?></h3>
          <p>Stok Menipis</p>
        </div>
        <div class="icon">
          <i class="fas fa-exclamation-triangle"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-teal">
        <div class="inner">
          <h3><?php echo $total_supplier; ?></h3>
          <p>Total Supplier</p>
        </div>
        <div class="icon">
          <i class="fas fa-truck"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-olive">
        <div class="inner">
          <h3><?php echo 'Rp ' . number_format($harga_average, 0, ',', '.'); ?></h3>
          <p>Harga Average</p>
        </div>
        <div class="icon">
          <i class="fas fa-calculator"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-lightblue">
        <div class="inner">
          <h3><?php echo 'Rp ' . number_format($nilai_masuk_bulan, 0, ',', '.'); ?></h3>
          <p>Nilai Masuk Bulan Ini</p>
        </div>
        <div class="icon">
          <i class="fas fa-arrow-down"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-purple">
        <div class="inner">
          <h3><?php echo 'Rp ' . number_format($nilai_keluar_bulan, 0, ',', '.'); ?></h3>
          <p>Nilai Keluar Bulan Ini</p>
        </div>
        <div class="icon">
          <i class="fas fa-arrow-up"></i>
        </div>
      </div>
    </div>
  </div>
</div>
