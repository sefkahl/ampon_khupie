<?php
session_start();
include 'koneksi.php';

if (isset($_POST['btnlogin'])) {

    $username_input = $_POST['txtusername'];
    $password_input = $_POST['txtpassword'];

    $statement_login = mysqli_prepare($konek, "SELECT tbl_user.*, tbl_pegawai.nama FROM tbl_user LEFT JOIN tbl_pegawai ON tbl_user.id_pegawai = tbl_pegawai.id_pegawai WHERE tbl_user.username = ?");
    mysqli_stmt_bind_param($statement_login, 's', $username_input);
    mysqli_stmt_execute($statement_login);
    $result_login = mysqli_stmt_get_result($statement_login);
    $data_user = mysqli_fetch_assoc($result_login);

    if ($data_user && password_verify($password_input, $data_user['password'])) {

        if ($data_user['role'] != 'Admin') {
            header('Location: login_admin.php?error=Akun%20tidak%20sesuai%20dengan%20halaman%20Login%20Admin');
            exit;
        }

        $_SESSION['id_user']  = $data_user['id_user'];
        $_SESSION['username'] = $data_user['username'];
        $_SESSION['nama']     = $data_user['nama'];
        $_SESSION['role']     = $data_user['role'];

        header('Location: beranda.php');
        exit;
    }

    header('Location: login_admin.php?error=Username%20atau%20password%20salah');
    exit;
}

header('Location: login_admin.php');
exit;
