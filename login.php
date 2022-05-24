<?php
  unset($_COOKIE["idstaff_bill"]);
  unset($_COOKIE["office_bill"]);
  unset($_COOKIE["status_bill"]);
  unset($_COOKIE["region_bill"]);
  setcookie("idstaff_bill", null, time() - (86400 * 30), '/');
  setcookie("office_bill", null, time() - (86400 * 30), '/');
  setcookie("status_bill", null, time() - (86400 * 30), '/');
  setcookie("region_bill", null, time() - (86400 * 30), '/');
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Billionaires Store">
    <meta name="author" content="Billionaires">
    <meta name="keyword" content="Billionaires Store">
    <link rel="shortcut icon" href="img/favcon.png">
    <title>BillStore - Login</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
  </head>

  <body class="bg-dark">
    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header"><center>Login Billionaires Store</center></div>
        <div class="card-body">
          <form  action="db_proses/login.php" method="POST">
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="inputEmail" class="form-control" name="inputEmail" placeholder="Username" required="required" autofocus="autofocus">
                <label for="inputEmail">Username</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="inputPassword" class="form-control" name="inputPassword" placeholder="Password" required="required">
                <label for="inputPassword">Password</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <select class="form-control" name="akses" id="akses">
                  <option value="">Pilih Akses</option>
                  <option value="SUPERADMIN">SUPERADMIN</option>
                  <option value="ADMIN">ADMIN</option>
                  <option value="PUSAT">PUSAT</option>
                  <option value="HEAD">HEAD</option>  
                  <option value="COUNTER">COUNTER</option>
                  <option value="GUDANG">GUDANG</option>
                </select>
              </div>
            </div>
            <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-block" value="LOGIN">
          </form>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  </body>

</html>
