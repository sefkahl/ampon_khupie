<?php
$id = base64_decode($_GET["id"]);
$sqlku = mysqli_query($konek, "SELECT * FROM tbl_pegawai WHERE id_pegawai='$id'");
$data  = mysqli_fetch_array($sqlku);

$jabatan = $data['jabatan_id'];
?>


<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-id-badge mr-2"></i>Edit Data Pegawai
            </h3>
        </div>
        <form method="POST">
            <div class="card-body">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" id="nama" name="txtnama" value="<?php echo $data['nama']; ?>" placeholder="Nama" required oninvalid="this.setCustomValidity('Tidak Boleh Kosong')" oninput="setCustomValidity('')" />
                </div>
                <div class="form-group">
                    <label>Jabatan</label>
                    <select class="form-control" id="jabatan" name="txtjabatan" required oninvalid="this.setCustomValidity('Pilih Jabatan')" oninput="setCustomValidity('')">
                        <option value="">-- Pilih Jabatan --</option>
                        <?php
                        $qry_jabatan = mysqli_query($konek, "SELECT * FROM m_jabatan ORDER BY nama_jabatan ASC");
                        while ($data_jabatan = mysqli_fetch_array($qry_jabatan)) {
                        ?>
                            <option value="<?php echo $data_jabatan['id_jabatan']; ?>" <?php if ($jabatan == $data_jabatan['id_jabatan']) { echo "selected"; } ?>><?php echo $data_jabatan['nama_jabatan']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nomor HP</label>
                    <input type="text" class="form-control" id="nomor" name="txtnomor" value="<?php echo $data['nomor_hp']; ?>" placeholder="Nomor HP">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" id="alamat" name="txtalamat" rows="2" placeholder="Alamat"><?php echo $data['alamat']; ?></textarea>
                </div>
            </div>
            <div class="card-footer">
                <a href="?page=pegawai" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" name="btnedit" class="btn btn-primary float-right">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>

        <?php
        if (isset($_POST["btnedit"])) {
            $txtnama = $_POST['txtnama'];
            $txtjabatan = $_POST['txtjabatan'];
            $txtnomor = $_POST['txtnomor'];
            $txtalamat = $_POST['txtalamat'];
            $edit = mysqli_query($konek, "UPDATE  tbl_pegawai SET nama='$txtnama', jabatan_id='$txtjabatan', nomor_hp='$txtnomor', alamat='$txtalamat' WHERE id_pegawai='$id'");
            if ($edit) {
                echo "<script>
                    alert('Data berhasil disimpan');
                    window.location='?page=pegawai';
                </script>";
        ?>
                <script type="text/javascript">
                    document.location.href = "?page=pegawai";
                </script>
        <?php
            } else {
                echo "<script>alert('Terjadi Kesalahan Inputan')</script>";
                echo "<meta http-equiv='refresh' content='0; url=?page=pegawai'>";
            }
        }
        ?>

    </div>
</div>
