<?php
$tgl_awal = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : date('Y-m-01');
$tgl_akhir = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : date('Y-m-d');
$txtbarang = isset($_GET['txtbarang']) ? $_GET['txtbarang'] : '';

$qry_barang = mysqli_query($konek, "select `tbl_barang`.`id_barang` AS `id_barang`, `tbl_barang`.`kode_barang` AS `kode_barang`, `tbl_barang`.`nama_barang` AS `nama_barang`, `tbl_barang`.`stok` AS `stok`, `tbl_barang`.`harga_average` AS `harga_average` from `tbl_barang` order by `tbl_barang`.`nama_barang` asc");

$periode = date('d-m-Y', strtotime($tgl_awal)) . ' s/d ' . date('d-m-Y', strtotime($tgl_akhir));
$no = 1;
$rows = array();
$grand_total = 0;
while ($data = mysqli_fetch_array($qry_barang)) {
    if ($txtbarang != '' && $data['id_barang'] != $txtbarang) {
        continue;
    }

    $sum_masuk = mysqli_fetch_array(mysqli_query($konek, "select ifnull(sum(jumlah), 0) from tbl_kartu_persediaan where id_barang='$data[id_barang]' and jenis='Masuk' and tanggal between '$tgl_awal' and '$tgl_akhir'"));
    $sum_keluar = mysqli_fetch_array(mysqli_query($konek, "select ifnull(sum(jumlah), 0) from tbl_kartu_persediaan where id_barang='$data[id_barang]' and jenis='Keluar' and tanggal between '$tgl_awal' and '$tgl_akhir'"));

    $nilai_persediaan = $data['stok'] * $data['harga_average'];
    $grand_total += $nilai_persediaan;

    $rows[] = array(
        'no' => $no++,
        'kode' => $data['kode_barang'],
        'nama' => $data['nama_barang'],
        'masuk' => (int) $sum_masuk[0],
        'keluar' => (int) $sum_keluar[0],
        'stok' => $data['stok'],
        'harga' => 'Rp ' . number_format($data['harga_average'], 0, ',', '.'),
        'nilai' => 'Rp ' . number_format($nilai_persediaan, 0, ',', '.'),
    );
}
?>

<style>
    @media print {
        .main-header,
        .main-sidebar,
        .content-header,
        .laporan-filter,
        .laporan-tools,
        .card-tools {
            display: none !important;
        }
        .content-wrapper {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .print-kop {
            display: block !important;
        }
    }
    .print-kop {
        display: none;
    }
</style>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-chart-line mr-2"></i>Laporan Persediaan (Average)</h3>
            <div class="card-tools laporan-tools">
                <button type="button" class="btn btn-info btn-sm" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
                <button type="button" class="btn btn-danger btn-sm" onclick="cetakPDF()">
                    <i class="fas fa-file-pdf"></i> PDF
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="print-kop text-center mb-3">
                <h4 class="mb-0"><b>AMPON KUPHIE</b></h4>
                <h5 class="mb-1">Laporan Persediaan (Average)</h5>
                <p class="mb-0">Periode: <?php echo $periode; ?></p>
            </div>

            <form method="GET" class="laporan-filter mb-3">
                <input type="hidden" name="page" value="lap_persediaan">
                <div class="row">
                    <div class="col-md-3">
                        <label>Tanggal Awal</label>
                        <input type="date" name="tgl_awal" class="form-control" value="<?php echo $tgl_awal; ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" class="form-control" value="<?php echo $tgl_akhir; ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Barang</label>
                        <select name="txtbarang" class="form-control">
                            <option value="">-- Semua Barang --</option>
                            <?php
                            $qry_filter = mysqli_query($konek, "SELECT * FROM tbl_barang ORDER BY nama_barang ASC");
                            while ($data_filter = mysqli_fetch_array($qry_filter)) {
                            ?>
                                <option value="<?php echo $data_filter['id_barang']; ?>" <?php if ($txtbarang == $data_filter['id_barang']) { echo "selected"; } ?>><?php echo $data_filter['kode_barang'] . ' - ' . $data_filter['nama_barang']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>&nbsp;</label><br>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> Preview
                        </button>
                    </div>
                </div>
            </form>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Barang Masuk</th>
                        <th>Barang Keluar</th>
                        <th>Saldo Stok</th>
                        <th>Harga Average</th>
                        <th>Nilai Persediaan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows as $row) {
                    ?>
                        <tr>
                            <td><?php echo $row['no']; ?></td>
                            <td><?php echo $row['kode']; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['masuk']; ?></td>
                            <td><?php echo $row['keluar']; ?></td>
                            <td><?php echo $row['stok']; ?></td>
                            <td><?php echo $row['harga']; ?></td>
                            <td><?php echo $row['nilai']; ?></td>
                        </tr>
                    <?php
                    }
                    if (empty($rows)) {
                    ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak Ada Data</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="7" class="text-right">Grand Total Nilai Persediaan</th>
                        <th><?php echo 'Rp ' . number_format($grand_total, 0, ',', '.'); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script>
    function cetakPDF() {
        var data = <?php echo json_encode($rows); ?>;
        var body = [
            ['No', 'Kode Barang', 'Nama Barang', 'Barang Masuk', 'Barang Keluar', 'Saldo Stok', 'Harga Average', 'Nilai Persediaan']
        ];
        data.forEach(function(r) {
            body.push([r.no, r.kode, r.nama, r.masuk, r.keluar, r.stok, r.harga, r.nilai]);
        });
        var dd = {
            content: [{
                text: 'AMPON KUPHIE',
                style: 'header'
            }, {
                text: 'Laporan Persediaan (Average)',
                style: 'subheader'
            }, {
                text: 'Periode: <?php echo $periode; ?>',
                style: 'periode'
            }, {
                table: {
                    headerRows: 1,
                    widths: ['auto', 'auto', '*', 'auto', 'auto', 'auto', 'auto', 'auto'],
                    body: body
                }
            }],
            styles: {
                header: {
                    fontSize: 16,
                    bold: true,
                    alignment: 'center'
                },
                subheader: {
                    fontSize: 13,
                    bold: true,
                    alignment: 'center',
                    margin: [0, 4, 0, 0]
                },
                periode: {
                    fontSize: 10,
                    alignment: 'center',
                    margin: [0, 2, 0, 12]
                }
            }
        };
        pdfMake.createPdf(dd).download('laporan_persediaan.pdf');
    }
</script>
