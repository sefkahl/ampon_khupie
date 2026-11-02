<?php
$id = base64_decode($_GET["id"]);
$sqlku = mysqli_query($konek, "SELECT * FROM m_jabatan WHERE id_jabatan='$id'");
$data  = mysqli_fetch_array($sqlku);
?>


<div class="col-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user-tie mr-2"></i>Edit Data Jabatan
            </h3>
        </div>
        <form method="POST">
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Jabatan</label>
                    <input type="text" class="form-control" id="uraian" name="txturaian" value="<?php echo $data['nama_jabatan']; ?>" placeholder="Jabatan" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" />
                </div>
            </div>
            <div class="card-footer">
                <a href="?page=m_jabatan" class="btn btn-secondary">
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
            $edit = mysqli_query($konek, "UPDATE  m_jabatan SET nama_jabatan='$txturaian' WHERE id_jabatan='$id'");
            if ($edit) {
                echo "<script>
                    alert('Data berhasil disimpan');
                    window.location='?page=m_jabatan';
                </script>";
        ?>
                <script type="text/javascript">
                    document.location.href = "?page=m_jabatan";
                </script>
        <?php
            } else {
                echo "<script>alert('Terjadi Kesalahan Inputan')</script>";
                echo "<meta http-equiv='refresh' content='0; url=?page=m_jabatan'>";
            }
        }
        ?>

    </div>
</div>
