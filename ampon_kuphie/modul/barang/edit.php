<?php
$id = base64_decode($_GET["id"]);
$sqlku = mysqli_query($konek, "SELECT * FROM tbl_barang WHERE id_barang='$id'");
$data  = mysqli_fetch_array($sqlku);

$satuan = $data['id_satuan'];
?>


<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-boxes mr-2"></i>Edit Data Barang
            </h3>
        </div>
        <form method="POST">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Barang</label>
                            <input type="text" class="form-control" id="kode" name="txtkode" value="<?php echo $data['kode_barang']; ?>" placeholder="Kode Barang" readonly required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" />
                        </div>
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control" id="nama" name="txtnama" value="<?php echo $data['nama_barang']; ?>" placeholder="Nama Barang" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" />
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" class="form-control" id="stok" name="txtstok" value="<?php echo $data['stok']; ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label>Satuan</label>
                            <select class="form-control" id="satuan" name="txtsatuan" required oninvalid="this.setCustomValidity('Pilih Satuan')" oninput="setCustomValidity('')">
                                <option value="">-- Pilih Satuan --</option>
                                <?php
                                $qry_satuan = mysqli_query($konek, "SELECT * FROM tbl_satuan ORDER BY nama_satuan ASC");
                                while ($data_satuan = mysqli_fetch_array($qry_satuan)) {
                                ?>
                                    <option value="<?php echo $data_satuan['id_satuan']; ?>" <?php if ($satuan == $data_satuan['id_satuan']) { echo "selected"; } ?>><?php echo $data_satuan['nama_satuan']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="txtket" rows="2" placeholder="Keterangan"><?php echo $data['keterangan']; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="?page=barang" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" name="btnedit" class="btn btn-primary float-right">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>

        <?php
        if (isset($_POST["btnedit"])) {
            $txtnama = $_POST['txtnama'];
            $txtsatuan = $_POST['txtsatuan'];
            $txtstok = ($_POST['txtstok'] != '') ? $_POST['txtstok'] : 0;
            $txtket = $_POST['txtket'];
            $edit = mysqli_query($konek, "UPDATE tbl_barang SET nama_barang='$txtnama', id_satuan='$txtsatuan', stok='$txtstok', keterangan='$txtket' WHERE id_barang='$id'");
            if ($edit) {
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
                echo "<script>alert('Terjadi Kesalahan Inputan')</script>";
                echo "<meta http-equiv='refresh' content='0; url=?page=barang'>";
            }
        }
        ?>

    </div>
</div>
