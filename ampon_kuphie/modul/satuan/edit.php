<?php
$id = base64_decode($_GET["id"]);
$sqlku = mysqli_query($konek, "SELECT * FROM tbl_satuan WHERE id_satuan='$id'");
$data  = mysqli_fetch_array($sqlku);
?>


<div class="col-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-ruler-combined mr-2"></i>Edit Data Satuan
            </h3>
        </div>
        <form method="POST">
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Satuan</label>
                    <input type="text" class="form-control" id="uraian" name="txturaian" value="<?php echo $data['nama_satuan']; ?>" placeholder="Satuan" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" />
                </div>
            </div>
            <div class="card-footer">
                <a href="?page=satuan" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" name="btnedit" class="btn btn-primary float-right">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>

        <?php
        if (isset($_POST["btnedit"])) {
            $txturaian = $_POST['txturaian'];
            $edit = mysqli_query($konek, "UPDATE  tbl_satuan SET nama_satuan='$txturaian' WHERE id_satuan='$id'");
            if ($edit) {
                echo "<script>
                    alert('Data berhasil disimpan');
                    window.location='?page=satuan';
                </script>";
        ?>
                <script type="text/javascript">
                    document.location.href = "?page=satuan";
                </script>
        <?php
            } else {
                echo "<script>alert('Terjadi Kesalahan Inputan')</script>";
                echo "<meta http-equiv='refresh' content='0; url=?page=satuan'>";
            }
        }
        ?>

    </div>
</div>