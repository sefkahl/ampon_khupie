<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Satuan</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Satuan</label>
                        <input type="text" name="txturaian" class="form-control" placeholder="Masukkan Nama Satuan" required>
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
    $simpan = mysqli_query($konek, " INSERT INTO tbl_satuan(nama_satuan) VALUES('$txturaian') ");

    if ($simpan) {

        echo "<script>
                    alert('Data berhasil disimpan');
                    window.location='?page=satuan';
                </script>";
    } else {

        echo "<script>alert('Data Anda Gagal di simpan')</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=satuan'>";
    }
}
?>
<div class="col-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-ruler-combined mr-2"></i> Data Satuan
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="tabel_satuan" class="table table-bordered table-hover ">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Satuan</th>
                        <th width="30%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $qry = mysqli_query($konek, "SELECT * FROM tbl_satuan ORDER BY nama_satuan ASC");
                    while ($data = mysqli_fetch_array($qry)) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['nama_satuan']; ?></td>
                            <td class="text-center">
                                <a href="?page=edit_satuan&id=<?php echo base64_encode($data['id_satuan']); ?>" class="btn btn-warning btn-sm"> <i class="fas fa-edit"></i> Edit</a>
                                <a href="?page=satuan&hapus=<?= $data['id_satuan']; ?>" onclick="return confirm('Yakin Anda Menghapus ?')" class="btn btn-danger btn-sm"> <i class="fas fa-eraser"></i> Hapus</a>
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
    $id_satuan = $_GET['hapus'];
    $cek = mysqli_query($konek, "SELECT COUNT(*) AS jml FROM tbl_barang WHERE id_satuan='$id_satuan'");
    $jml = mysqli_fetch_array($cek)['jml'];
    if ($jml > 0) {
        echo "<script>alert('Data Tidak Bisa di Hapus Karena Masih Digunakan pada Data Barang')</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=satuan'>";
    } else {
        $qry = mysqli_query($konek, "delete from tbl_satuan where id_satuan='$id_satuan'");
        if ($qry) {
            echo "<script>alert('Data Berhasil di Hapus')</script>";
            echo "<meta http-equiv='refresh' content='0; url=?page=satuan'>";
        } else {
            echo "Gagal di Hapus" . mysqli_error();
            echo "<meta http-equiv='refresh' content='0; url=?page=satuan'>";
        }
    }
}
?>