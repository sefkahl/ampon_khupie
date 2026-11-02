<?php
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan Login Terlebih Dahulu')</script>";
    echo "<meta http-equiv='refresh' content='0; url=login_admin.php'>";
}
?>

<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-id-card mr-2"></i> Profil Saya
            </h3>
        </div>
        <div class="card-body">
            <?php
            $nama_profil = isset($_SESSION['nama']) && $_SESSION['nama'] != '' ? $_SESSION['nama'] : '-';
            $inisial = strtoupper(substr(trim($nama_profil), 0, 1));
            ?>
            <div class="text-center mb-4">
                <div class="d-inline-flex justify-content-center align-items-center rounded-circle bg-primary text-white"
                    style="width: 100px; height: 100px; font-size: 42px;">
                    <?php echo $inisial; ?>
                </div>
                <h4 class="mt-3 mb-0"><?php echo $nama_profil; ?></h4>
                <small class="text-muted"><?php echo isset($_SESSION['role']) ? $_SESSION['role'] : '-'; ?></small>
            </div>
            <table class="table table-bordered">
                <tr>
                    <td><b>Nama</b></td>
                    <td><?php echo $nama_profil; ?></td>
                </tr>
                <tr>
                    <td><b>Username</b></td>
                    <td><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : '-'; ?></td>
                </tr>
                <tr>
                    <td><b>Role</b></td>
                    <td><?php echo isset($_SESSION['role']) ? $_SESSION['role'] : '-'; ?></td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="?page=ubah_password" class="btn btn-primary">
                <i class="fas fa-key"></i> Ubah Password
            </a>
            <a href="keluar_admin.php" class="btn btn-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
</div>
