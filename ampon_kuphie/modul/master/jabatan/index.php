<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Jabatan</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Jabatan</label>
                        <input type="text" name="txturaian" class="form-control" placeholder="Masukkan Nama Jabatan" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')">
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
    $txturaian = $_POST['txturaian'];
    $simpan = mysqli_query($konek, " INSERT INTO m_jabatan(nama_jabatan) VALUES('$txturaian') ");

    if ($simpan) {

        echo "<script>
                    alert('Data berhasil disimpan');
                    window.location='?page=m_jabatan';
                </script>";
    } else {

        echo "<script>alert('Data Anda Gagal di simpan')</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=m_jabatan'>";
    }
}
?>
<div class="col-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user-tie mr-2"></i> Data Jabatan
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="tabel_jabatan" class="table table-bordered table-hover ">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Jabatan</th>
                        <th width="30%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $qry = mysqli_query($konek, "SELECT * FROM m_jabatan ORDER BY id_jabatan DESC");
                    while ($data = mysqli_fetch_array($qry)) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['nama_jabatan']; ?></td>
                            <td class="text-center">
                                <a href="?page=edit_m_jabatan&id=<?php echo base64_encode($data['id_jabatan']); ?>" class="btn btn-warning btn-sm"> <i class="fas fa-edit"></i> Edit</a>
                                <a href="?page=m_jabatan&hapus=<?= $data['id_jabatan']; ?>" onclick="return confirm('Yakin Anda Menghapus ?')" class="btn btn-danger btn-sm"> <i class="fas fa-eraser"></i> Hapus</a>
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
    $qry = mysqli_query($konek, "delete from m_jabatan where id_jabatan='" . $_GET["hapus"] . "'");
    if ($qry) {
        echo "<script>alert('Data Berhasil di Hapus')</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=m_jabatan'>";
    } else {
        echo "Gagal di Hapus" . mysqli_error();
        echo "<meta http-equiv='refresh' content='0; url=?page=m_jabatan'>";
    }
}
?>
