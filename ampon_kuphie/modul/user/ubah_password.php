<?php
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan Login Terlebih Dahulu')</script>";
    echo "<meta http-equiv='refresh' content='0; url=login_admin.php'>";
}
?>


<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-key mr-2"></i> Ubah Password
            </h3>
        </div>
        <form method="POST">
            <div class="card-body">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Password Lama</label>
                    <input type="password" class="form-control" name="txtlama" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" placeholder="Masukkan Password Lama">
                </div>
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" class="form-control" name="txtbaru" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" placeholder="Masukkan Password Baru">
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" name="txtkonfirmasi" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" placeholder="Ulangi Password Baru">
                </div>
            </div>
            <div class="card-footer">
                <a href="?page=beranda" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" name="btnsimpan" class="btn btn-primary float-right">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>

        <?php
        if (isset($_POST["btnsimpan"])) {
            $txtlama = $_POST['txtlama'];
            $txtbaru = $_POST['txtbaru'];
            $txtkonfirmasi = $_POST['txtkonfirmasi'];
            $id_user = $_SESSION['id_user'];

            $cek = mysqli_fetch_array(mysqli_query($konek, "SELECT password FROM tbl_user WHERE id_user='$id_user'"));

            if ($cek && password_verify($txtlama, $cek['password'])) {
                if ($txtbaru != $txtkonfirmasi) {
                    echo "<script>alert('Konfirmasi Password Tidak Sama')</script>";
                    echo "<meta http-equiv='refresh' content='0; url=?page=ubah_password'>";
                } else {
                    $password_baru = password_hash($txtbaru, PASSWORD_DEFAULT);
                    $ubah = mysqli_query($konek, "UPDATE tbl_user SET password='$password_baru' WHERE id_user='$id_user'");

                    if ($ubah) {
                        echo "<script>
                            alert('Password Berhasil Diubah');
                            window.location='?page=beranda';
                        </script>";
                ?>
                        <script type="text/javascript">
                            document.location.href = "?page=beranda";
                        </script>
                <?php
                    } else {
                        echo "<script>alert('Terjadi Kesalahan Inputan')</script>";
                        echo "<meta http-equiv='refresh' content='0; url=?page=ubah_password'>";
                    }
                }
            } else {
                echo "<script>alert('Password Lama Salah')</script>";
                echo "<meta http-equiv='refresh' content='0; url=?page=ubah_password'>";
            }
        }
        ?>

    </div>
</div>
