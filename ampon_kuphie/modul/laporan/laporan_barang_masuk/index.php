<?php
$tgl_awal = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : date('Y-m-01');
$tgl_akhir = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : date('Y-m-d');

$qry = mysqli_query($konek, "select `tbl_barang_masuk`.`id_barang_masuk` AS `id_barang_masuk`, `tbl_barang_masuk`.`nomor_transaksi` AS `nomor_transaksi`, `tbl_barang_masuk`.`jumlah` AS `jumlah`, `tbl_barang_masuk`.`harga_beli` AS `harga_beli`, `tbl_barang_masuk`.`tanggal` AS `tanggal`, `tbl_barang_masuk`.`keterangan` AS `keterangan`, `tbl_barang`.`kode_barang` AS `kode_barang`, `tbl_barang`.`nama_barang` AS `nama_barang`, `tbl_supplier`.`nama_supplier` AS `nama_supplier` from ((`tbl_barang_masuk` join `tbl_barang` on((`tbl_barang_masuk`.`id_barang` = `tbl_barang`.`id_barang`))) join `tbl_supplier` on((`tbl_barang_masuk`.`id_supplier` = `tbl_supplier`.`id_supplier`))) where (`tbl_barang_masuk`.`tanggal` between '$tgl_awal' and '$tgl_akhir') order by `tbl_barang_masuk`.`id_barang_masuk` asc");

$no = 1;
$rows = array();
while ($data = mysqli_fetch_array($qry)) {
    $rows[] = array(
        'no' => $no++,
        'nomor' => $data['nomor_transaksi'],
        'tanggal' => date('d-m-Y', strtotime($data['tanggal'])),
        'barang' => $data['kode_barang'] . ' - ' . $data['nama_barang'],
        'supplier' => $data['nama_supplier'],
        'jumlah' => $data['jumlah'],
        'harga' => 'Rp ' . number_format($data['harga_beli'], 0, ',', '.'),
        'total' => 'Rp ' . number_format($data['jumlah'] * $data['harga_beli'], 0, ',', '.'),
        'ket' => $data['keterangan'],
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
            <h3 class="card-title"><i class="fas fa-file-import mr-2"></i>Laporan Barang Masuk</h3>
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
                <h5 class="mb-1">Laporan Barang Masuk</h5>
                <p class="mb-0">Periode: <?php echo date('d-m-Y', strtotime($tgl_awal)) . ' s/d ' . date('d-m-Y', strtotime($tgl_akhir)); ?></p>
            </div>

            <form method="GET" class="laporan-filter mb-3">
                <input type="hidden" name="page" value="lap_barang_masuk">
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
                        <th>Nomor Transaksi</th>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Supplier</th>
                        <th>Jumlah</th>
                        <th>Harga Beli</th>
                        <th>Total</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $grand_total = 0;
                    foreach ($rows as $row) {
                        $grand_total += (int) str_replace(array('Rp ', '.'), '', $row['total']);
                    ?>
                        <tr>
                            <td><?php echo $row['no']; ?></td>
                            <td><?php echo $row['nomor']; ?></td>
                            <td><?php echo $row['tanggal']; ?></td>
                            <td><?php echo $row['barang']; ?></td>
                            <td><?php echo $row['supplier']; ?></td>
                            <td><?php echo $row['jumlah']; ?></td>
                            <td><?php echo $row['harga']; ?></td>
                            <td><?php echo $row['total']; ?></td>
                            <td><?php echo $row['ket']; ?></td>
                        </tr>
                    <?php
                    }
                    if (empty($rows)) {
                    ?>
                        <tr>
                            <td colspan="9" class="text-center">Tidak Ada Data</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="7" class="text-right">Grand Total</th>
                        <th><?php echo 'Rp ' . number_format($grand_total, 0, ',', '.'); ?></th>
                        <th></th>
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
            ['No', 'Nomor Transaksi', 'Tanggal', 'Barang', 'Supplier', 'Jumlah', 'Harga Beli', 'Total', 'Keterangan']
        ];
        data.forEach(function(r) {
            body.push([r.no, r.nomor, r.tanggal, r.barang, r.supplier, r.jumlah, r.harga, r.total, r.ket]);
        });
        var dd = {
            content: [{
                text: 'AMPON KUPHIE',
                style: 'header'
            }, {
                text: 'Laporan Barang Masuk',
                style: 'subheader'
            }, {
                text: 'Periode: <?php echo date('d-m-Y', strtotime($tgl_awal)) . ' s/d ' . date('d-m-Y', strtotime($tgl_akhir)); ?>',
                style: 'periode'
            }, {
                table: {
                    headerRows: 1,
                    widths: ['auto', 'auto', 'auto', '*', '*', 'auto', 'auto', 'auto', '*'],
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
        pdfMake.createPdf(dd).download('laporan_barang_masuk.pdf');
    }
</script>
