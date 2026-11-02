<?php
$carikode = mysqli_query($konek, "select max(kode_barang) from tbl_barang");
$datakode = mysqli_fetch_array($carikode);
if ($datakode[0]) {
    $nilaikode = substr($datakode[0], 4);
    $kode = (int) $nilaikode;
    $kode = $kode + 1;
    $kode_otomatis = "BRG-" . str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {
    $kode_otomatis = "BRG-001";
}
?>

<div class="col-8">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-boxes mr-2"></i>Tambah Data Barang
            </h3>
        </div>
        <form method="POST">
            <div class="card-body">
                <div class="form-group">
                    <label>Kode Barang</label>
                    <input type="text" class="form-control" id="kode" name="txtkode" value="<?php echo $kode_otomatis ?>" readonly ="Kode Barang" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" />
                </div>
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" class="form-control" id="nama" name="txtnama" placeholder="Nama Barang" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" />
                </div>
                <div class="form-group">
                    <label>Satuan</label>
                    <select class="form-control" id="satuan" name="txtsatuan" required oninvalid="this.setCustomValidity('Pilih Satuan')" oninput="setCustomValidity('')">
                        <option value="">-- Pilih Satuan --</option>
                        <?php
                        $qry_satuan = mysqli_query($konek, "SELECT * FROM tbl_satuan ORDER BY nama_satuan ASC");
                        while ($data_satuan = mysqli_fetch_array($qry_satuan)) {
                        ?>
                            <option value="<?php echo $data_satuan['id_satuan']; ?>"><?php echo $data_satuan['nama_satuan']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Stok (Opsional)</label>
                    <input type="number" class="form-control" id="stok" name="txtstok" value="0" min="0">
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="txtket" rows="2" placeholder="Keterangan"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <a href="?page=barang" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" name="btnsimpan" class="btn btn-primary float-right">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>

        <?php
        if (isset($_POST["btnsimpan"])) {
            $txtkode = $_POST['txtkode'];
            $txtnama = $_POST['txtnama'];
            $txtsatuan = $_POST['txtsatuan'];
            $txtstok = ($_POST['txtstok'] != '') ? $_POST['txtstok'] : 0;
            $txtket = $_POST['txtket'];
            $simpan = mysqli_query($konek, " INSERT INTO tbl_barang(kode_barang, nama_barang, id_satuan, stok, harga_average, keterangan) VALUES('$txtkode', '$txtnama', '$txtsatuan', '$txtstok', 0, '$txtket') ");
            if ($simpan) {
                echo "<script>
                    alert('Data berhasil disimpan');
                    window.location='?page=barang';
                </script>";
        ?>
                <script type="text/javascript">
                    document.location.href = "?page=barang";
                </script>
        <?php
            } else {
                echo "<script>alert('Data Anda Gagal di simpan')</script>";
                echo "<meta http-equiv='refresh' content='0; url=?page=barang'>";
            }
        }
        ?>

    </div>
</div>
