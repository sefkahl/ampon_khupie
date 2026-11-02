<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah User</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="txtusername" class="form-control" placeholder="Masukkan Username" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="txtpassword" class="form-control" placeholder="Masukkan Password" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')">
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="txtrole" class="form-control" required oninvalid="this.setCustomValidity('Pilih Role')" oninput="setCustomValidity('')">
                            <option value="">-- Pilih Role --</option>
                            <option value="Admin">Admin</option>
                            <option value="Owner">Owner</option>
                            <option value="Petugas">Staf Gudang</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pegawai</label>
                        <select name="txtpegawai" class="form-control">
                            <option value="">-- Pilih Pegawai --</option>
                            <?php
                            $qry_pegawai = mysqli_query($konek, "select `tbl_pegawai`.`id_pegawai` AS `id_pegawai`, `tbl_pegawai`.`nama` AS `nama`, `m_jabatan`.`nama_jabatan` AS `nama_jabatan` from (`tbl_pegawai` join `m_jabatan` on((`tbl_pegawai`.`jabatan_id` = `m_jabatan`.`id_jabatan`))) order by `tbl_pegawai`.`nama` asc");
                            while ($data_pegawai = mysqli_fetch_array($qry_pegawai)) {
                            ?>
                                <option value="<?php echo $data_pegawai['id_pegawai']; ?>"><?php echo $data_pegawai['nama'] . ' - ' . $data_pegawai['nama_jabatan']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="submit" name="btnsimpan" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php

if (isset($_POST['btnsimpan'])) {
    $txtusername = $_POST['txtusername'];
    $txtpassword = password_hash($_POST['txtpassword'], PASSWORD_DEFAULT);
    $txtrole = $_POST['txtrole'];
    $txtpegawai = ($_POST['txtpegawai'] != '') ? "'" . $_POST['txtpegawai'] . "'" : "NULL";

    $cek_user = mysqli_fetch_array(mysqli_query($konek, "SELECT id_user FROM tbl_user WHERE username='$txtusername'"));
    if ($cek_user) {
        echo "<script>alert('Username Sudah Ada')</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=user'>";
    } else {
        $simpan = mysqli_query($konek, " INSERT INTO tbl_user(username, password, role, id_pegawai) VALUES('$txtusername', '$txtpassword', '$txtrole', $txtpegawai) ");

        if ($simpan) {

            echo "<script>
                    alert('Data berhasil disimpan');
                    window.location='?page=user';
                </script>";
        } else {

            echo "<script>alert('Data Anda Gagal di simpan')</script>";
            echo "<meta http-equiv='refresh' content='0; url=?page=user'>";
        }
    }
}
?>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user-cog mr-2"></i> Manajemen User
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="tabel_user" class="table table-bordered table-hover ">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Pegawai</th>
                        <th width="18%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $qry = mysqli_query($konek, "SELECT tbl_user.*, tbl_pegawai.nama FROM tbl_user LEFT JOIN tbl_pegawai ON tbl_user.id_pegawai = tbl_pegawai.id_pegawai ORDER BY tbl_user.username ASC");
                    while ($data = mysqli_fetch_array($qry)) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['username']; ?></td>
                            <td><?php echo $data['role']; ?></td>
                            <td><?php echo $data['nama']; ?></td>
                            <td class="text-center">
                                <a href="?page=edit_user&id=<?php echo base64_encode($data['id_user']); ?>" class="btn btn-warning btn-sm"> <i class="fas fa-edit"></i> Edit</a>
                                <a href="?page=user&hapus=<?= $data['id_user']; ?>" onclick="return confirm('Yakin Anda Menghapus ?')" class="btn btn-danger btn-sm"> <i class="fas fa-eraser"></i> Hapus</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
if (isset($_GET['hapus'])) {
    $qry = mysqli_query($konek, "delete from tbl_user where id_user='" . $_GET["hapus"] . "'");
    if ($qry) {
        echo "<script>alert('Data Berhasil di Hapus')</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=user'>";
    } else {
        echo "Gagal di Hapus" . mysqli_error();
        echo "<meta http-equiv='refresh' content='0; url=?page=user'>";
    }
}
?>
