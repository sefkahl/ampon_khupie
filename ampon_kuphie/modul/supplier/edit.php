<?php
$id = base64_decode($_GET["id"]);
$sqlku = mysqli_query($konek, "SELECT * FROM tbl_supplier WHERE id_supplier='$id'");
$data  = mysqli_fetch_array($sqlku);
?>


<div class="col-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-truck mr-2"></i>Edit Data Supplier
            </h3>
        </div>
        <form method="POST">
            <div class="card-body">
                <!-- <div class="form-group">
                    <label>Kode Supplier</label>
                    <input type="text" class="form-control" id="kode" name="txtkode" value="<?php echo $data['kode_supplier']; ?>" placeholder="Kode Supplier" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" />
                </div> -->
                <div class="form-group">
                    <label>Nama Supplier</label>
                    <input type="text" class="form-control" id="nama" name="txtnama" value="<?php echo $data['nama_supplier']; ?>" placeholder="Nama Supplier" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" />
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" id="alamat" name="txtalamat" rows="2" placeholder="Alamat"><?php echo $data['alamat']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Nomor HP</label>
                    <input type="text" class="form-control" id="nomor" name="txtnomor" value="<?php echo $data['nomor_hp']; ?>" placeholder="Nomor HP">
                </div>
            </div>
            <div class="card-footer">
                <a href="?page=supplier" class="btn btn-secondary">
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
            $txtalamat = $_POST['txtalamat'];
            $txtnomor = $_POST['txtnomor'];
            $edit = mysqli_query($konek, "UPDATE  tbl_supplier SET nama_supplier='$txtnama', alamat='$txtalamat', nomor_hp='$txtnomor' WHERE id_supplier='$id'");
            if ($edit) {
                echo "<script>
                    alert('Data berhasil disimpan');
                    window.location='?page=supplier';
                </script>";
        ?>
                <script type="text/javascript">
                    document.location.href = "?page=supplier";
                </script>
        <?php
            } else {
                echo "<script>alert('Terjadi Kesalahan Inputan')</script>";
                echo "<meta http-equiv='refresh' content='0; url=?page=supplier'>";
            }
        }
        ?>

    </div>
</div>
