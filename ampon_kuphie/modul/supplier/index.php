<?php
$carikode = mysqli_query($konek, "select max(kode_supplier) from tbl_supplier");
$datakode = mysqli_fetch_array($carikode);
if ($datakode[0]) {
    $nilaikode = substr($datakode[0], 3);
    $kode = (int) $nilaikode;
    $kode = $kode + 1;
    $kode_otomatis = "SPL" . str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {
    $kode_otomatis = "SPL001";
}
?>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Supplier</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Supplier</label>
                        <input type="text" name="txtkode" class="form-control" value="<?php echo $kode_otomatis ?>" readonly placeholder="Masukkan Kode Supplier" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')">
                    </div>
                    <div class="form-group">
                        <label>Nama Supplier</label>
                        <input type="text" name="txtnama" class="form-control" placeholder="Masukkan Nama Supplier" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="txtalamat" class="form-control" placeholder="Masukkan Alamat" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Nomor HP</label>
                        <input type="text" name="txtnomor" class="form-control" placeholder="Masukkan Nomor HP">
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
    $txtkode = $_POST['txtkode'];
    $txtnama = $_POST['txtnama'];
    $txtalamat = $_POST['txtalamat'];
    $txtnomor = $_POST['txtnomor'];
    $simpan = mysqli_query($konek, " INSERT INTO tbl_supplier(kode_supplier, nama_supplier, alamat, nomor_hp) VALUES('$txtkode', '$txtnama', '$txtalamat', '$txtnomor') ");

    if ($simpan) {

        echo "<script>
                    alert('Data berhasil disimpan');
                    window.location='?page=supplier';
                </script>";
    } else {

        echo "<script>alert('Data Anda Gagal di simpan')</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=supplier'>";
    }
}
?>
<div class="col-8">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-truck mr-2"></i> Data Supplier
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="tabel_supplier" class="table table-bordered table-hover ">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama Supplier</th>
                        <th>Alamat</th>
                        <th>Nomor HP</th>
                        <th width="18%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $qry = mysqli_query($konek, "SELECT * FROM tbl_supplier ORDER BY nama_supplier DESC");
                    while ($data = mysqli_fetch_array($qry)) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['kode_supplier']; ?></td>
                            <td><?php echo $data['nama_supplier']; ?></td>
                            <td><?php echo $data['alamat']; ?></td>
                            <td><?php echo $data['nomor_hp']; ?></td>
                            <td class="text-center">
                                <a href="?page=edit_supplier&id=<?php echo base64_encode($data['id_supplier']); ?>" class="btn btn-warning btn-sm"> <i class="fas fa-edit"></i> Edit</a>
                                <a href="?page=supplier&hapus=<?= $data['id_supplier']; ?>" onclick="return confirm('Yakin Anda Menghapus ?')" class="btn btn-danger btn-sm"> <i class="fas fa-eraser"></i> Hapus</a>
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
    $id_supplier = $_GET['hapus'];
    $cek = mysqli_query($konek, "SELECT COUNT(*) AS jml FROM tbl_barang_masuk WHERE id_supplier='$id_supplier'");
    $jml = mysqli_fetch_array($cek)['jml'];
    if ($jml > 0) {
        echo "<script>alert('Data Tidak Bisa di Hapus Karena Masih Digunakan pada Transaksi Barang Masuk')</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=supplier'>";
    } else {
        $qry = mysqli_query($konek, "delete from tbl_supplier where id_supplier='$id_supplier'");
        if ($qry) {
            echo "<script>alert('Data Berhasil di Hapus')</script>";
            echo "<meta http-equiv='refresh' content='0; url=?page=supplier'>";
        } else {
            echo "Gagal di Hapus" . mysqli_error();
            echo "<meta http-equiv='refresh' content='0; url=?page=supplier'>";
        }
    }
}
?>
