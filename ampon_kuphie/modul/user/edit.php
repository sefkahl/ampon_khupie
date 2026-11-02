<?php
$id = base64_decode($_GET["id"]);
$sqlku = mysqli_query($konek, "SELECT * FROM tbl_user WHERE id_user='$id'");
$data  = mysqli_fetch_array($sqlku);

$pegawai = $data['id_pegawai'];
?>


<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user-cog mr-2"></i>Edit Data User
            </h3>
        </div>
        <form method="POST">
            <div class="card-body">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" id="username" name="txtusername" value="<?php echo $data['username']; ?>" placeholder="Username" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" />
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="password" name="txtpassword" placeholder="Kosongkan jika tidak diganti">
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" id="role" name="txtrole" required oninvalid="this.setCustomValidity('Pilih Role')" oninput="setCustomValidity('')">
                        <option value="">-- Pilih Role --</option>
                        <option value="Admin" <?php if ($data['role'] == 'Admin') echo 'selected'; ?>>Admin</option>
                        <option value="Owner" <?php if ($data['role'] == 'Owner') echo 'selected'; ?>>Owner</option>
                        <option value="Petugas" <?php if ($data['role'] == 'Petugas') echo 'selected'; ?>>Staf Gudang</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Pegawai</label>
                    <select class="form-control" id="pegawai" name="txtpegawai">
                        <option value="">-- Pilih Pegawai --</option>
                        <?php
                        $qry_pegawai = mysqli_query($konek, "SELECT * FROM tbl_pegawai ORDER BY nama ASC");
                        while ($data_pegawai = mysqli_fetch_array($qry_pegawai)) {
                        ?>
                            <option value="<?php echo $data_pegawai['id_pegawai']; ?>" <?php if ($pegawai == $data_pegawai['id_pegawai']) { echo "selected"; } ?>><?php echo $data_pegawai['nama']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <a href="?page=user" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" name="btnedit" class="btn btn-primary float-right">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>

        <?php
        if (isset($_POST["btnedit"])) {
            $txtusername = $_POST['txtusername'];
            $txtrole = $_POST['txtrole'];
            $txtpegawai = ($_POST['txtpegawai'] != '') ? "'" . $_POST['txtpegawai'] . "'" : "NULL";

            $cek_user = mysqli_fetch_array(mysqli_query($konek, "SELECT id_user FROM tbl_user WHERE username='$txtusername' AND id_user!='$id'"));
            if ($cek_user) {
                echo "<script>alert('Username Sudah Ada')</script>";
                echo "<meta http-equiv='refresh' content='0; url=?page=user'>";
            } else {
                if ($_POST['txtpassword'] != '') {
                    $txtpassword = password_hash($_POST['txtpassword'], PASSWORD_DEFAULT);
                    $edit = mysqli_query($konek, "UPDATE tbl_user SET username='$txtusername', password='$txtpassword', role='$txtrole', id_pegawai=$txtpegawai WHERE id_user='$id'");
                } else {
                    $edit = mysqli_query($konek, "UPDATE tbl_user SET username='$txtusername', role='$txtrole', id_pegawai=$txtpegawai WHERE id_user='$id'");
                }
                if ($edit) {
                    echo "<script>
                    alert('Data berhasil disimpan');
                    window.location='?page=user';
                </script>";
        ?>
                <script type="text/javascript">
                    document.location.href = "?page=user";
                </script>
        <?php
                } else {
                    echo "<script>alert('Terjadi Kesalahan Inputan')</script>";
                    echo "<meta http-equiv='refresh' content='0; url=?page=user'>";
                }
            }
        }
        ?>

    </div>
</div>
