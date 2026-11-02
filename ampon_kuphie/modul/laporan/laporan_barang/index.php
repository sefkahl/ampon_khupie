<?php
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

$where_cari = '';
if ($cari != '') {
    $where_cari = " where (`tbl_barang`.`kode_barang` like '%$cari%' or `tbl_barang`.`nama_barang` like '%$cari%') ";
}

$qry = mysqli_query($konek, "select `tbl_barang`.`id_barang` AS `id_barang`, `tbl_barang`.`kode_barang` AS `kode_barang`, `tbl_barang`.`nama_barang` AS `nama_barang`, `tbl_barang`.`stok` AS `stok`, `tbl_barang`.`harga_average` AS `harga_average`, `tbl_barang`.`keterangan` AS `keterangan`, `tbl_satuan`.`nama_satuan` AS `nama_satuan` from (`tbl_barang` join `tbl_satuan` on((`tbl_barang`.`id_satuan` = `tbl_satuan`.`id_satuan`)))" . $where_cari . " order by `tbl_barang`.`nama_barang` asc");

$no = 1;
$rows = array();
while ($data = mysqli_fetch_array($qry)) {
    $rows[] = array(
        'no' => $no++,
        'kode' => $data['kode_barang'],
        'nama' => $data['nama_barang'],
        'satuan' => $data['nama_satuan'],
        'stok' => $data['stok'],
        'harga' => 'Rp ' . number_format($data['harga_average'], 0, ',', '.'),
        'nilai' => 'Rp ' . number_format($data['stok'] * $data['harga_average'], 0, ',', '.'),
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
            <h3 class="card-title"><i class="fas fa-file-alt mr-2"></i>Laporan Data Barang</h3>
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
                <h5 class="mb-1">Laporan Data Barang</h5>
                <p class="mb-0"><?php echo 'Per ' . date('d-m-Y'); ?></p>
            </div>

            <form method="GET" class="laporan-filter mb-3">
                <input type="hidden" name="page" value="lap_barang">
                <div class="row">
                    <div class="col-md-4">
                        <label>Cari Barang</label>
                        <input type="text" name="cari" class="form-control" value="<?php echo $cari; ?>" placeholder="Kode atau Nama Barang">
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
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Harga Average</th>
                        <th>Nilai Persediaan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $grand_total = 0;
                    foreach ($rows as $row) {
                        $grand_total += (int) str_replace(array('Rp ', '.'), '', $row['nilai']);
                    ?>
                        <tr>
                            <td><?php echo $row['no']; ?></td>
                            <td><?php echo $row['kode']; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['satuan']; ?></td>
                            <td><?php echo $row['stok']; ?></td>
                            <td><?php echo $row['harga']; ?></td>
                            <td><?php echo $row['nilai']; ?></td>
                            <td><?php echo $row['ket']; ?></td>
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
                        <th colspan="6" class="text-right">Grand Total Nilai Persediaan</th>
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
            ['No', 'Kode Barang', 'Nama Barang', 'Satuan', 'Stok', 'Harga Average', 'Nilai Persediaan', 'Keterangan']
        ];
        data.forEach(function(r) {
            body.push([r.no, r.kode, r.nama, r.satuan, r.stok, r.harga, r.nilai, r.ket]);
        });
        var dd = {
            content: [{
                text: 'AMPON KUPHIE',
                style: 'header'
            }, {
                text: 'Laporan Data Barang',
                style: 'subheader'
            }, {
                text: 'Per <?php echo date('d-m-Y'); ?>',
                style: 'periode'
            }, {
                table: {
                    headerRows: 1,
                    widths: ['auto', 'auto', '*', 'auto', 'auto', 'auto', 'auto', '*'],
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
        pdfMake.createPdf(dd).download('laporan_barang.pdf');
    }
</script>
