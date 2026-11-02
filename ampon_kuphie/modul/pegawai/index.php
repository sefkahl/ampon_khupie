<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Pegawai</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="txtnama" class="form-control" placeholder="Masukkan Nama" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')">
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <select name="txtjabatan" class="form-control" required oninvalid="this.setCustomValidity('Pilih Jabatan')" oninput="setCustomValidity('')">
                            <option value="">-- Pilih Jabatan --</option>
                            <?php
                            $qry_jabatan = mysqli_query($konek, "SELECT * FROM m_jabatan ORDER BY nama_jabatan ASC");
                            while ($data_jabatan = mysqli_fetch_array($qry_jabatan)) {
                            ?>
                                <option value="<?php echo $data_jabatan['id_jabatan']; ?>"><?php echo $data_jabatan['nama_jabatan']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nomor HP</label>
                        <input type="text" name="txtnomor" class="form-control" placeholder="Masukkan Nomor HP">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="txtalamat" class="form-control" placeholder="Masukkan Alamat" rows="2"></textarea>
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
    $txtnama = $_POST['txtnama'];
    $txtjabatan = $_POST['txtjabatan'];
    $txtnomor = $_POST['txtnomor'];
    $txtalamat = $_POST['txtalamat'];
    $simpan = mysqli_query($konek, " INSERT INTO tbl_pegawai(nama, jabatan_id, nomor_hp, alamat) VALUES('$txtnama', '$txtjabatan', '$txtnomor', '$txtalamat') ");

    if ($simpan) {

        echo "<script>
                    alert('Data berhasil disimpan');
                    window.location='?page=pegawai';
                </script>";
    } else {

        echo "<script>alert('Data Anda Gagal di simpan')</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=pegawai'>";
    }
}
?>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-id-badge mr-2"></i> Data Pegawai
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="tabel_pegawai" class="table table-bordered table-hover ">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Nomor HP</th>
                        <th>Alamat</th>
                        <th width="18%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $qry = mysqli_query($konek, "select `tbl_pegawai`.`id_pegawai` AS `id_pegawai`, `tbl_pegawai`.`nama` AS `nama`, `tbl_pegawai`.`jabatan_id` AS `jabatan_id`, `tbl_pegawai`.`nomor_hp` AS `nomor_hp`, `tbl_pegawai`.`alamat` AS `alamat`, `m_jabatan`.`nama_jabatan` AS `nama_jabatan` from (`tbl_pegawai` join `m_jabatan` on((`tbl_pegawai`.`jabatan_id` = `m_jabatan`.`id_jabatan`))) order by `tbl_pegawai`.`nama` asc");
                    while ($data = mysqli_fetch_array($qry)) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['nama']; ?></td>
                            <td><?php echo $data['nama_jabatan']; ?></td>
                            <td><?php echo $data['nomor_hp']; ?></td>
                            <td><?php echo $data['alamat']; ?></td>
                            <td class="text-center">
                                <a href="?page=edit_pegawai&id=<?php echo base64_encode($data['id_pegawai']); ?>" class="btn btn-warning btn-sm"> <i class="fas fa-edit"></i> Edit</a>
                                <a href="?page=pegawai&hapus=<?= $data['id_pegawai']; ?>" onclick="return confirm('Yakin Anda Menghapus ?')" class="btn btn-danger btn-sm"> <i class="fas fa-eraser"></i> Hapus</a>
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
    $qry = mysqli_query($konek, "delete from tbl_pegawai where id_pegawai='" . $_GET["hapus"] . "'");
    if ($qry) {
        echo "<script>alert('Data Berhasil di Hapus')</script>";
        echo "<meta http-equiv='refresh' content='0; url=?page=pegawai'>";
    } else {
        echo "Gagal di Hapus" . mysqli_error();
        echo "<meta http-equiv='refresh' content='0; url=?page=pegawai'>";
    }
}
?>
