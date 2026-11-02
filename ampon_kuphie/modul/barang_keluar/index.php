<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-sign-out-alt mr-2"></i> Barang Keluar
            </h3>
            <div class="card-tools">
                <a href="?page=tambah_barang_keluar" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="tabel_barang_keluar" class="table table-bordered table-hover ">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nomor Transaksi</th>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Pokok</th>
                        <th>Total</th>
                        <th>Keterangan</th>
                        <th width="18%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $qry = mysqli_query($konek, "select `tbl_barang_keluar`.`id_barang_keluar` AS `id_barang_keluar`, `tbl_barang_keluar`.`nomor_transaksi` AS `nomor_transaksi`, `tbl_barang_keluar`.`id_barang` AS `id_barang`, `tbl_barang_keluar`.`jumlah` AS `jumlah`, `tbl_barang_keluar`.`harga_pokok` AS `harga_pokok`, `tbl_barang_keluar`.`tanggal` AS `tanggal`, `tbl_barang_keluar`.`keterangan` AS `keterangan`, `tbl_barang`.`kode_barang` AS `kode_barang`, `tbl_barang`.`nama_barang` AS `nama_barang` from (`tbl_barang_keluar` join `tbl_barang` on((`tbl_barang_keluar`.`id_barang` = `tbl_barang`.`id_barang`))) order by `tbl_barang_keluar`.`id_barang_keluar` desc");
                    while ($data = mysqli_fetch_array($qry)) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['nomor_transaksi']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($data['tanggal'])); ?></td>
                            <td><?php echo $data['kode_barang'] . ' - ' . $data['nama_barang']; ?></td>
                            <td><?php echo $data['jumlah']; ?></td>
                            <td><?php echo 'Rp ' . number_format($data['harga_pokok'], 0, ',', '.'); ?></td>
                            <td><?php echo 'Rp ' . number_format($data['jumlah'] * $data['harga_pokok'], 0, ',', '.'); ?></td>
                            <td><?php echo $data['keterangan']; ?></td>
                            <td class="text-center">
                                <a href="?page=edit_barang_keluar&id=<?php echo base64_encode($data['id_barang_keluar']); ?>" class="btn btn-warning btn-sm"> <i class="fas fa-edit"></i> Edit</a>
                                <a href="?page=barang_keluar&hapus=<?= $data['id_barang_keluar']; ?>" onclick="return confirm('Yakin Anda Menghapus ?')" class="btn btn-danger btn-sm"> <i class="fas fa-eraser"></i> Hapus</a>
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
    $data_hapus = mysqli_fetch_array(mysqli_query($konek, "SELECT * FROM tbl_barang_keluar WHERE id_barang_keluar='$id_hapus'"));
    if ($data_hapus) {
        $kartu_hapus = mysqli_fetch_array(mysqli_query($konek, "SELECT * FROM tbl_kartu_persediaan WHERE id_barang_keluar='$id_hapus'"));
        if ($kartu_hapus) {
            $stok_baru = $kartu_hapus['saldo_stok'] + $kartu_hapus['jumlah'];
            $nilai_baru = $kartu_hapus['saldo_nilai'] + $kartu_hapus['total'];
            $avg_baru = $stok_baru > 0 ? round($nilai_baru / $stok_baru, 2) : 0;

            mysqli_begin_transaction($konek);
            try {
                mysqli_query($konek, " UPDATE tbl_barang SET stok='$stok_baru', harga_average='$avg_baru' WHERE id_barang='$data_hapus[id_barang]' ");
                mysqli_query($konek, " DELETE FROM tbl_kartu_persediaan WHERE id_barang_keluar='$id_hapus' ");
                mysqli_query($konek, " DELETE FROM tbl_barang_keluar WHERE id_barang_keluar='$id_hapus' ");
                mysqli_commit($konek);
                echo "<script>alert('Data Berhasil di Hapus')</script>";
            } catch (Exception $e) {
                mysqli_rollback($konek);
                echo "<script>alert('Data Gagal di Hapus')</script>";
            }
        } else {
            mysqli_query($konek, "DELETE FROM tbl_barang_keluar WHERE id_barang_keluar='$id_hapus'");
            echo "<script>alert('Data Berhasil di Hapus')</script>";
        }
    } else {
        echo "<script>alert('Data Berhasil di Hapus')</script>";
    }
    echo "<meta http-equiv='refresh' content='0; url=?page=barang_keluar'>";
}
?>
