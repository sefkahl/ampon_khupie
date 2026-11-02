<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-sign-in-alt mr-2"></i> Barang Masuk
            </h3>
            <div class="card-tools">
                <a href="?page=tambah_barang_masuk" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="tabel_barang_masuk" class="table table-bordered table-hover ">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nomor Transaksi</th>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Supplier</th>
                        <th>Jumlah</th>
                        <th>Harga Beli</th>
                        <th>Total</th>
                        <th>Keterangan</th>
                        <th width="18%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $qry = mysqli_query($konek, "select `tbl_barang_masuk`.`id_barang_masuk` AS `id_barang_masuk`, `tbl_barang_masuk`.`nomor_transaksi` AS `nomor_transaksi`, `tbl_barang_masuk`.`id_barang` AS `id_barang`, `tbl_barang_masuk`.`id_supplier` AS `id_supplier`, `tbl_barang_masuk`.`jumlah` AS `jumlah`, `tbl_barang_masuk`.`harga_beli` AS `harga_beli`, `tbl_barang_masuk`.`tanggal` AS `tanggal`, `tbl_barang_masuk`.`keterangan` AS `keterangan`, `tbl_barang`.`kode_barang` AS `kode_barang`, `tbl_barang`.`nama_barang` AS `nama_barang`, `tbl_supplier`.`nama_supplier` AS `nama_supplier` from ((`tbl_barang_masuk` join `tbl_barang` on((`tbl_barang_masuk`.`id_barang` = `tbl_barang`.`id_barang`))) join `tbl_supplier` on((`tbl_barang_masuk`.`id_supplier` = `tbl_supplier`.`id_supplier`))) order by `tbl_barang_masuk`.`id_barang_masuk` desc");
                    while ($data = mysqli_fetch_array($qry)) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['nomor_transaksi']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($data['tanggal'])); ?></td>
                            <td><?php echo $data['kode_barang'] . ' - ' . $data['nama_barang']; ?></td>
                            <td><?php echo $data['nama_supplier']; ?></td>
                            <td><?php echo $data['jumlah']; ?></td>
                            <td><?php echo 'Rp ' . number_format($data['harga_beli'], 0, ',', '.'); ?></td>
                            <td><?php echo 'Rp ' . number_format($data['jumlah'] * $data['harga_beli'], 0, ',', '.'); ?></td>
                            <td><?php echo $data['keterangan']; ?></td>
                            <td class="text-center">
                                <a href="?page=edit_barang_masuk&id=<?php echo base64_encode($data['id_barang_masuk']); ?>" class="btn btn-warning btn-sm"> <i class="fas fa-edit"></i> Edit</a>
                                <a href="?page=barang_masuk&hapus=<?= $data['id_barang_masuk']; ?>" onclick="return confirm('Yakin Anda Menghapus ?')" class="btn btn-danger btn-sm"> <i class="fas fa-eraser"></i> Hapus</a>
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
    $id_hapus = $_GET['hapus'];
    $data_hapus = mysqli_fetch_array(mysqli_query($konek, "SELECT * FROM tbl_barang_masuk WHERE id_barang_masuk='$id_hapus'"));
    if ($data_hapus) {
        $kartu_hapus = mysqli_fetch_array(mysqli_query($konek, "SELECT * FROM tbl_kartu_persediaan WHERE id_barang_masuk='$id_hapus'"));
        if ($kartu_hapus) {
            $stok_baru = $kartu_hapus['saldo_stok'] - $kartu_hapus['jumlah'];
            $nilai_baru = $kartu_hapus['saldo_nilai'] - $kartu_hapus['total'];
            $avg_baru = $stok_baru > 0 ? round($nilai_baru / $stok_baru, 2) : 0;

            mysqli_begin_transaction($konek);
            try {
                mysqli_query($konek, " UPDATE tbl_barang SET stok='$stok_baru', harga_average='$avg_baru' WHERE id_barang='$data_hapus[id_barang]' ");
                mysqli_query($konek, " DELETE FROM tbl_kartu_persediaan WHERE id_barang_masuk='$id_hapus' ");
                mysqli_query($konek, " DELETE FROM tbl_barang_masuk WHERE id_barang_masuk='$id_hapus' ");
                mysqli_commit($konek);
                echo "<script>alert('Data Berhasil di Hapus')</script>";
            } catch (Exception $e) {
                mysqli_rollback($konek);
                echo "<script>alert('Data Gagal di Hapus')</script>";
            }
        } else {
            mysqli_query($konek, "DELETE FROM tbl_barang_masuk WHERE id_barang_masuk='$id_hapus'");
            echo "<script>alert('Data Berhasil di Hapus')</script>";
        }
    } else {
        echo "<script>alert('Data Berhasil di Hapus')</script>";
    }
    echo "<meta http-equiv='refresh' content='0; url=?page=barang_masuk'>";
}
?>
