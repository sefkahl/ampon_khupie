<?php
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

$where_cari = '';
if ($cari != '') {
    $where_cari = " where (`tbl_pegawai`.`nama` like '%$cari%') ";
}

$qry = mysqli_query($konek, "select `tbl_pegawai`.`id_pegawai` AS `id_pegawai`, `tbl_pegawai`.`nama` AS `nama`, `tbl_pegawai`.`nomor_hp` AS `nomor_hp`, `tbl_pegawai`.`alamat` AS `alamat`, `m_jabatan`.`nama_jabatan` AS `nama_jabatan` from (`tbl_pegawai` join `m_jabatan` on((`tbl_pegawai`.`jabatan_id` = `m_jabatan`.`id_jabatan`)))" . $where_cari . " order by `tbl_pegawai`.`nama` asc");

$no = 1;
$rows = array();
while ($data = mysqli_fetch_array($qry)) {
    $rows[] = array(
        'no' => $no++,
        'nama' => $data['nama'],
        'jabatan' => $data['nama_jabatan'],
        'hp' => $data['nomor_hp'],
        'alamat' => $data['alamat'],
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
            <h3 class="card-title"><i class="fas fa-users mr-2"></i>Laporan Data Pegawai</h3>
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
                <h5 class="mb-1">Laporan Data Pegawai</h5>
                <p class="mb-0"><?php echo 'Per ' . date('d-m-Y'); ?></p>
            </div>

            <form method="GET" class="laporan-filter mb-3">
                <input type="hidden" name="page" value="lap_pegawai">
                <div class="row">
                    <div class="col-md-4">
                        <label>Cari Pegawai</label>
                        <input type="text" name="cari" class="form-control" value="<?php echo $cari; ?>" placeholder="Nama Pegawai">
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
                        <th>Nama Pegawai</th>
                        <th>Jabatan</th>
                        <th>Nomor HP</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows as $row) {
                    ?>
                        <tr>
                            <td><?php echo $row['no']; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['jabatan']; ?></td>
                            <td><?php echo $row['hp']; ?></td>
                            <td><?php echo $row['alamat']; ?></td>
                        </tr>
                    <?php
                    }
                    if (empty($rows)) {
                    ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak Ada Data</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
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
            ['No', 'Nama Pegawai', 'Jabatan', 'Nomor HP', 'Alamat']
        ];
        data.forEach(function(r) {
            body.push([r.no, r.nama, r.jabatan, r.hp, r.alamat]);
        });
        var dd = {
            content: [{
                text: 'AMPON KUPHIE',
                style: 'header'
            }, {
                text: 'Laporan Data Pegawai',
                style: 'subheader'
            }, {
                text: 'Per <?php echo date('d-m-Y'); ?>',
                style: 'periode'
            }, {
                table: {
                    headerRows: 1,
                    widths: ['auto', '*', '*', 'auto', '*'],
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
        pdfMake.createPdf(dd).download('laporan_pegawai.pdf');
    }
</script>
