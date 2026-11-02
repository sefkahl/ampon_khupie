<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-boxes mr-2"></i> Data Barang
            </h3>
            <div class="card-tools">
                <a href="?page=tambah_barang" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="tabel_barang" class="table table-bordered table-hover ">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Harga Average</th>
                        <th>Keterangan</th>
                        <th width="18%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $qry = mysqli_query($konek, "select `tbl_barang`.`id_barang` AS `id_barang`, `tbl_barang`.`kode_barang` AS `kode_barang`, `tbl_barang`.`nama_barang` AS `nama_barang`, `tbl_barang`.`id_satuan` AS `id_satuan`, `tbl_barang`.`stok` AS `stok`, `tbl_barang`.`harga_average` AS `harga_average`, `tbl_barang`.`keterangan` AS `keterangan`, `tbl_satuan`.`nama_satuan` AS `nama_satuan` from (`tbl_barang` join `tbl_satuan` on((`tbl_barang`.`id_satuan` = `tbl_satuan`.`id_satuan`))) order by `tbl_barang`.`nama_barang` asc");
                    while ($data = mysqli_fetch_array($qry)) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['kode_barang']; ?></td>
                            <td><?php echo $data['nama_barang']; ?></td>
                            <td><?php echo $data['nama_satuan']; ?></td>
                            <td><?php echo $data['stok']; ?></td>
                            <td><?php echo 'Rp ' . number_format($data['harga_average'], 2, ',', '.'); ?></td>
                            <td><?php echo $data['keterangan']; ?></td>
                            <td class="text-center">
                                <a href="?page=edit_barang&id=<?php echo base64_encode($data['id_barang']); ?>" class="btn btn-warning btn-sm"> <i class="fas fa-edit"></i> Edit</a>
                                <a href="?page=barang&hapus=<?= $data['id_barang']; ?>" onclick="return confirm('Yakin Anda Menghapus ?')" class="btn btn-danger btn-sm"> <i class="fas fa-eraser"></i> Hapus</a>
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
    $id_barang = $_GET['hapus'];
    $cek = mysqli_query($konek, "SELECT (SELECT COUNT(*) FROM tbl_barang_masuk WHERE id_barang='$id_barang') + (SELECT COUNT(*) FROM tbl_barang_keluar WHERE id_barang='$id_barang') + (SELECT COUNT(*) FROM tbl_kartu_persediaan WHERE id_barang='$id_barang') AS jml");
    $jml = mysqli_fetch_array($cek)['jml'];
    if ($jml > 0) {
        echo "<script>alert('Data Tidak Bisa di Hapus Karena Masih Digunakan pada Transaksi Barang Masuk / Barang Keluar')</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=barang'>";
    } else {
        $qry = mysqli_query($konek, "delete from tbl_barang where id_barang='$id_barang'");
        if ($qry) {
            echo "<script>alert('Data Berhasil di Hapus')</script>";
            echo "<meta http-equiv='refresh' content='0; url=?page=barang'>";
        } else {
            echo "Gagal di Hapus" . mysqli_error();
            echo "<meta http-equiv='refresh' content='0; url=?page=barang'>";
        }
    }
}
?>
