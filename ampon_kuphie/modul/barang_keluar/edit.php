<?php
$id = base64_decode($_GET["id"]);
$sqlku = mysqli_query($konek, "SELECT * FROM tbl_barang_keluar WHERE id_barang_keluar='$id'");
$data  = mysqli_fetch_array($sqlku);

$barang = $data['id_barang'];
?>


<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-sign-out-alt mr-2"></i>Edit Barang Keluar
            </h3>
        </div>
        <form method="POST">
            <div class="card-body">
                <div class="form-group">
                    <label>Nomor Transaksi</label>
                    <input type="text" class="form-control" value="<?php echo $data['nomor_transaksi']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="txttanggal" value="<?php echo $data['tanggal']; ?>" required oninvalid="this.setCustomValidity('Pilih Tanggal')" oninput="setCustomValidity('')" />
                </div>
                <div class="form-group">
                    <label>Barang</label>
                    <select class="form-control" id="barang" name="txtbarang" required oninvalid="this.setCustomValidity('Pilih Barang')" oninput="setCustomValidity('')">
                        <option value="">-- Pilih Barang --</option>
                        <?php
                        $qry_barang = mysqli_query($konek, "SELECT * FROM tbl_barang ORDER BY nama_barang ASC");
                        while ($data_barang = mysqli_fetch_array($qry_barang)) {
                        ?>
                            <option value="<?php echo $data_barang['id_barang']; ?>" <?php if ($barang == $data_barang['id_barang']) { echo "selected"; } ?>><?php echo $data_barang['kode_barang'] . ' - ' . $data_barang['nama_barang']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" class="form-control" id="jumlah" name="txtjumlah" value="<?php echo $data['jumlah']; ?>" min="1" required oninvalid="this.setCustomValidity('Isi Jumlah')" oninput="setCustomValidity('')" />
                </div>
                <div class="form-group">
                    <label>Harga Pokok</label>
                    <input type="text" class="form-control" value="<?php echo 'Rp ' . number_format($data['harga_pokok'], 0, ',', '.'); ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="txtket" rows="2" placeholder="Keterangan"><?php echo $data['keterangan']; ?></textarea>
                </div>
            </div>
            <div class="card-footer">
                <a href="?page=barang_keluar" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" name="btnedit" class="btn btn-primary float-right">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>

        <?php
        if (isset($_POST["btnedit"])) {
            $txttanggal = $_POST['txttanggal'];
            $txtbarang = $_POST['txtbarang'];
            $txtjumlah = $_POST['txtjumlah'];
            $txtket = $_POST['txtket'];

            $kartu_lama = mysqli_fetch_array(mysqli_query($konek, "SELECT * FROM tbl_kartu_persediaan WHERE id_barang_keluar='$id'"));

            mysqli_begin_transaction($konek);
            try {
                if ($kartu_lama) {
                    $stok_kembali = $kartu_lama['saldo_stok'] + $kartu_lama['jumlah'];
                    $nilai_kembali = $kartu_lama['saldo_nilai'] + $kartu_lama['total'];
                    $avg_kembali = $stok_kembali > 0 ? round($nilai_kembali / $stok_kembali, 2) : 0;
                    mysqli_query($konek, " UPDATE tbl_barang SET stok='$stok_kembali', harga_average='$avg_kembali' WHERE id_barang='$data[id_barang]' ");
                    mysqli_query($konek, " DELETE FROM tbl_kartu_persediaan WHERE id_barang_keluar='$id' ");
                }

                $cek_barang = mysqli_fetch_array(mysqli_query($konek, "SELECT stok, harga_average FROM tbl_barang WHERE id_barang='$txtbarang'"));
                if ($txtjumlah > $cek_barang['stok']) {
                    mysqli_rollback($konek);
                    echo "<script>alert('Stok Barang Tidak Mencukupi')</script>";
                    echo "<meta http-equiv='refresh' content='0; url=?page=barang_keluar'>";
                } else {
                    $harga_pokok = $cek_barang['harga_average'];
                    $nilai_lama = $cek_barang['stok'] * $cek_barang['harga_average'];
                    $stok_baru = $cek_barang['stok'] - $txtjumlah;
                    $nilai_baru = $nilai_lama - ($txtjumlah * $harga_pokok);

                    mysqli_query($konek, " UPDATE tbl_barang_keluar SET id_barang='$txtbarang', jumlah='$txtjumlah', harga_pokok='$harga_pokok', tanggal='$txttanggal', keterangan='$txtket' WHERE id_barang_keluar='$id' ");
                    mysqli_query($konek, " UPDATE tbl_barang SET stok='$stok_baru' WHERE id_barang='$txtbarang' ");
                    mysqli_query($konek, " INSERT INTO tbl_kartu_persediaan(id_barang, id_barang_keluar, tanggal, jenis, jumlah, harga, total, saldo_stok, saldo_nilai, harga_average) VALUES('$txtbarang', '$id', '$txttanggal', 'Keluar', '$txtjumlah', '$harga_pokok', '" . ($txtjumlah * $harga_pokok) . "', '$stok_baru', '$nilai_baru', '$harga_pokok') ");
                    mysqli_commit($konek);

                    echo "<script>
                        alert('Data berhasil disimpan');
                        window.location='?page=barang_keluar';
                    </script>";
        ?>
                    <script type="text/javascript">
                        document.location.href = "?page=barang_keluar";
                    </script>
        <?php
                }
            } catch (Exception $e) {
                mysqli_rollback($konek);
                echo "<script>alert('Terjadi Kesalahan Inputan')</script>";
                echo "<meta http-equiv='refresh' content='0; url=?page=barang_keluar'>";
            }
        }
        ?>

    </div>
</div>
