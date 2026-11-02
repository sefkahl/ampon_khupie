<?php
$carikode = mysqli_query($konek, "select max(nomor_transaksi) from tbl_barang_masuk");
$datakode = mysqli_fetch_array($carikode);
if ($datakode[0]) {
    $nilaikode = substr($datakode[0], 2);
    $kode = (int) $nilaikode;
    $kode = $kode + 1;
    $nomor_transaksi = "BM" . str_pad($kode, 5, "0", STR_PAD_LEFT);
} else {
    $nomor_transaksi = "BM00001";
}
?>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-sign-in-alt mr-2"></i>Tambah Barang Masuk
            </h3>
        </div>
        <form method="POST">
            <div class="card-body">
                <div class="form-group">
                    <label>Nomor Transaksi</label>
                    <input type="text" class="form-control" id="nomor" name="txtnomor" value="<?php echo $nomor_transaksi ?>" placeholder="Nomor Transaksi" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" readonly/>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="txttanggal" value="<?php echo date('Y-m-d'); ?>" required oninvalid="this.setCustomValidity('Pilih Tanggal')" oninput="setCustomValidity('')" />
                </div>
                <div class="form-group">
                    <label>Barang</label>
                    <select class="form-control" id="barang" name="txtbarang" required oninvalid="this.setCustomValidity('Pilih Barang')" oninput="setCustomValidity('')">
                        <option value="">-- Pilih Barang --</option>
                        <?php
                        $qry_barang = mysqli_query($konek, "SELECT * FROM tbl_barang ORDER BY nama_barang ASC");
                        while ($data_barang = mysqli_fetch_array($qry_barang)) {
                        ?>
                            <option value="<?php echo $data_barang['id_barang']; ?>"><?php echo $data_barang['kode_barang'] . ' - ' . $data_barang['nama_barang']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Supplier</label>
                    <select class="form-control" id="supplier" name="txtsupplier" required oninvalid="this.setCustomValidity('Pilih Supplier')" oninput="setCustomValidity('')">
                        <option value="">-- Pilih Supplier --</option>
                        <?php
                        $qry_supplier = mysqli_query($konek, "SELECT * FROM tbl_supplier ORDER BY nama_supplier ASC");
                        while ($data_supplier = mysqli_fetch_array($qry_supplier)) {
                        ?>
                            <option value="<?php echo $data_supplier['id_supplier']; ?>"><?php echo $data_supplier['kode_supplier'] . ' - ' . $data_supplier['nama_supplier']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" class="form-control" id="jumlah" name="txtjumlah" min="1" required oninvalid="this.setCustomValidity('Isi Jumlah')" oninput="setCustomValidity('')" />
                </div>
                <div class="form-group">
                    <label>Harga Beli</label>
                    <input type="number" class="form-control" id="harga" name="txtharga" min="0.01" step="0.01" required oninvalid="this.setCustomValidity('Isi Harga Beli')" oninput="setCustomValidity('')" />
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="txtket" rows="2" placeholder="Keterangan"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <a href="?page=barang_masuk" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" name="btnsimpan" class="btn btn-primary float-right">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>

        <?php
        if (isset($_POST["btnsimpan"])) {
            $txtnomor = $_POST['txtnomor'];
            $txttanggal = $_POST['txttanggal'];
            $txtbarang = $_POST['txtbarang'];
            $txtsupplier = $_POST['txtsupplier'];
            $txtjumlah = $_POST['txtjumlah'];
            $txtharga = $_POST['txtharga'];
            $txtket = $_POST['txtket'];

            $cek_barang = mysqli_fetch_array(mysqli_query($konek, "SELECT stok, harga_average FROM tbl_barang WHERE id_barang='$txtbarang'"));
            $nilai_lama = $cek_barang['stok'] * $cek_barang['harga_average'];
            $stok_baru = $cek_barang['stok'] + $txtjumlah;
            $nilai_baru = $nilai_lama + ($txtjumlah * $txtharga);
            $avg_baru = $stok_baru > 0 ? round($nilai_baru / $stok_baru, 2) : 0;

            mysqli_begin_transaction($konek);
            try {
                mysqli_query($konek, " INSERT INTO tbl_barang_masuk(nomor_transaksi, id_barang, id_supplier, jumlah, harga_beli, tanggal, keterangan) VALUES('$txtnomor', '$txtbarang', '$txtsupplier', '$txtjumlah', '$txtharga', '$txttanggal', '$txtket') ");
                $id_masuk = mysqli_insert_id($konek);
                mysqli_query($konek, " UPDATE tbl_barang SET stok='$stok_baru', harga_average='$avg_baru' WHERE id_barang='$txtbarang' ");
                mysqli_query($konek, " INSERT INTO tbl_kartu_persediaan(id_barang, id_barang_masuk, tanggal, jenis, jumlah, harga, total, saldo_stok, saldo_nilai, harga_average) VALUES('$txtbarang', '$id_masuk', '$txttanggal', 'Masuk', '$txtjumlah', '$txtharga', '" . ($txtjumlah * $txtharga) . "', '$stok_baru', '$nilai_baru', '$avg_baru') ");
                mysqli_commit($konek);

                echo "<script>
                    alert('Data berhasil disimpan');
                    window.location='?page=barang_masuk';
                </script>";
        ?>
                <script type="text/javascript">
                    document.location.href = "?page=barang_masuk";
                </script>
        <?php
            } catch (Exception $e) {
                mysqli_rollback($konek);
                echo "<script>alert('Data Anda Gagal di simpan')</script>";
                echo "<meta http-equiv='refresh' content='0; url=?page=barang_masuk'>";
            }
        }
        ?>

    </div>
</div>
