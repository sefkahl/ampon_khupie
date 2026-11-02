<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AMPON KUPHIE | Login Owner</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="index.php"><b>AMPON   </b>KUPHIE</a>
    </div>
    <div class="login-box">
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Login Owner</p>
          <form action="" method="post">
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="txtusername" placeholder="Email / User Name">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" name="txtpassword" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
           <div class="row">
          <div class="col-4">
            <button type="submit" name="btnlogin" class="btn btn-primary">Login</button>
          </div>
        </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php
  if (isset($_POST["btnlogin"])) {
    $txtusername = $_POST['txtusername'];
    $txtpassword = $_POST['txtpassword'];
    $statement_login = mysqli_prepare($konek, "SELECT tbl_user.*, tbl_pegawai.nama FROM tbl_user LEFT JOIN tbl_pegawai ON tbl_user.id_pegawai = tbl_pegawai.id_pegawai WHERE tbl_user.username = ?");
    mysqli_stmt_bind_param($statement_login, 's', $txtusername);
    mysqli_stmt_execute($statement_login);
    $result_login = mysqli_stmt_get_result($statement_login);
    $hasil = mysqli_fetch_array($result_login);
    $count = mysqli_num_rows($result_login);
    $nama_user = $hasil['nama'];
    $id_user1 = $hasil['id_user'];
    $username1 = $hasil['username'];
    $role1 = $hasil['role'];
    if ($count > 0 && password_verify($txtpassword, $hasil['password'])) {
      if ($role1 != 'Owner') {
        echo "<div class='alert alert-danger' role='alert'>Akun tidak sesuai dengan halaman Login Owner...!!!</div>";
      } else {
        session_start();
        $_SESSION['id_user'] = $id_user1;
        $_SESSION['username'] = $username1;
        $_SESSION['nama'] = $nama_user;
        $_SESSION['role'] = $role1;
        header("location:beranda_owner.php");
        exit;
      }
    } else {
      echo "<div class='alert alert-danger' role='alert'>Email dan Password Salah...!!!</div>";
    }
  }
  ?>
  <br><br>
  </div>
  <div class="clearfix"> </div>
</body>

</html>