<?php
  include ('akses.php');
  include ('../_partials/partial_evt.php');

  if(isset($_POST["submit"])) {
    $uname = $_POST['uname'];
    $pwd = $_POST['pwd']; 
    $id_peg = $_POST['id_peg']; 

    if (empty($uname)||empty($pwd)){
      echo "<script type='text/javascript'>alert('Data Tidak Boleh Kosong !');</script>";
      header("Refresh:0");
      exit(); 
    }else{
      $countr = 0;
      $sqlr = "SELECT * FROM pegawai WHERE username_pegawai='$uname'";
      $resultr = mysqli_query($kon,$sqlr);
      $rowr = mysqli_fetch_array($resultr,MYSQLI_ASSOC);
      $countr = mysqli_num_rows($resultr);

      if ($countr!=0){
        echo "<script type='text/javascript'>alert('Username Sudah Digunakan !');</script>";
        header("Refresh:0");
        exit(); 
      }else{
        $quersql="UPDATE pegawai SET username_pegawai='$uname', passwd_pegawai='$pwd' WHERE id_pegawai='$id_peg'";
        $result = mysqli_query($kon,$quersql);
        echo "<script type='text/javascript'>alert('Data Berhasil Dirubah');</script>";
        header("Refresh:0");
        exit(); 
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <?php echo $csjs1; ?>
  </head>

  <body id="page-top">
    <?php echo $topnav; ?>

    <div id="wrapper">
      <?php echo $topside; ?>

      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Profil</li>
          </ol>

          <!-- DataTables Example -->
          <?php
            include "../db_proses/koneksi.php";
            $pg = $_COOKIE['id_pegawai'];
            $sqlre= "SELECT * FROM pegawai 
            INNER JOIN office ON office.id_office=pegawai.office_pegawai WHERE pegawai.id_pegawai='$pg'";
            $resultre = mysqli_query($kon,$sqlre);
            $rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
          ?>
          <div class="card mb-3">
            <div class="card-body">
            <form method="post" id="form-approv">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nama">Nama*</label>
                      <input class="form-control" type="text" name="nama" id="nama" value="<?php echo $rowre['nama_pegawai']; ?>" readonly required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="jekel">Jenis Kelamin*</label>
                      <input class="form-control" type="text" name="jekel" id="jekel" value="<?php echo $rowre['jenis_kelamin_pegawai']; ?>" readonly required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="tlp">Telepon*</label>
                      <input class="form-control" type="text" name="tlp" id="tlp" value="<?php echo $rowre['tlp_pegawai']; ?>" readonly required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="almt">Alamat*</label>
                      <input class="form-control" type="text" name="almt" id="almt" value="<?php echo $rowre['alamat_pegawai']; ?>" readonly required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="status_peg">Status Pegawai*</label>
                      <input class="form-control" type="text" name="status_peg" id="status_peg" value="<?php echo $rowre['status_pegawai']." - ".$rowre['nama_office']; ?>" readonly required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="uname">Username*</label>
                      <input class="form-control" type="text" name="uname" id="uname" value="<?php echo $rowre['username_pegawai']; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="pwd">Password*</label>
                      <input class="form-control" type="text" name="pwd" id="pwd" value="<?php echo $rowre['passwd_pegawai']; ?>" required/>  
                    </div>
                    <div class="modal-footer">
                      <input type="hidden" name="id_peg" id="id_peg" value="<?php echo $rowre['id_pegawai']; ?>">
                      <button class="btn btn-success" id="btn-save" type="submit" name="submit">Update</button>
                    </div>
                  </form>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        
        <?php echo $footer; ?>
      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
		<?php echo $logout; ?>
    <?php echo $csjs2; ?>
    <script type="text/javascript">
      $(document).ready(function(){
        var datapro = "data_produk.php";
        $('#DataProduk').load(datapro); 
      })
    </script>
  </body>
</html>
