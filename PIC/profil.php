<?php
  include ('akses.php');
  include ('../_partials/partial_pic.php');
  include ('../db_proses/koneksi.php');

  if(isset($_POST["submit"])) {
    $cek=0;
    $uname = $_POST['uname'];
    $pwd = $_POST['pwd']; 
    $id_peg = $_POST['id_peg']; 

    if (empty($uname)||empty($pwd)){
      echo "<script type='text/javascript'>alert('Data Tidak Boleh Kosong !');</script>";
    }else{
      mysqli_autocommit($kon, false);
      $countr = 0;
      $sqlr = "SELECT * FROM tb_staff WHERE uname_staff='$uname' AND kode_staff!='$id_peg'";
      $resultr = mysqli_query($kon,$sqlr);
      $rowr = mysqli_fetch_array($resultr,MYSQLI_ASSOC);
      $countr = mysqli_num_rows($resultr);

      if ($countr!=0){
        echo "<script type='text/javascript'>alert('Username Sudah Digunakan !');</script>";
      }else{
        $quersql="UPDATE tb_staff SET uname_staff='$uname', pass_staff='$pwd' WHERE kode_staff='$id_peg'";
        $result = mysqli_query($kon,$quersql);
        if(!$result) {    
          $cek=$cek+1;
        }
        
        if ($cek==0){
          mysqli_commit($kon);
          echo "<script type='text/javascript'>alert('Data Berhasil Dirubah');</script>";
        }else{          
          mysqli_rollback($kon);
          header("HTTP/1.1 302 Found");
          echo "<script type='text/javascript'>alert('Data Gagal Dirubah');window.location='profil.php';</script>";
        }
        mysqli_close($kon);
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
            
            $pg = $_COOKIE['idstaff_bill'];

            $sqlre= "SELECT * FROM tb_staff 
                      INNER JOIN tb_office ON tb_office.id_office=tb_staff.office_staff
                      INNER JOIN tb_akses ON tb_akses.staff_akses=tb_staff.kode_staff 
                      WHERE tb_staff.kode_staff='$pg' AND tb_akses.status_akses='HEAD'";
            $resultre = mysqli_query($kon,$sqlre);
            $rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
          ?>
          <div class="card mb-3">
            <div class="card-body">
            <form method="post" id="form-approv">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nama">Nama*</label>
                      <input class="form-control" type="text" name="nama" id="nama" value="<?php echo $rowre['nama_staff']; ?>" readonly required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="status_peg">Status Pegawai*</label>
                      <input class="form-control" type="text" name="status_peg" id="status_peg" value="<?php echo $rowre['status_akses']." - ".$rowre['nama_office']; ?>" readonly required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="uname">Username*</label>
                      <input class="form-control" type="text" name="uname" id="uname" value="<?php echo $rowre['uname_staff']; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="pwd">Password*</label>
                      <input class="form-control" type="text" name="pwd" id="pwd" value="<?php echo $rowre['pass_staff']; ?>" required/>  
                    </div>
                    <div class="modal-footer">
                      <input type="hidden" name="id_peg" id="id_peg" value="<?php echo $rowre['kode_staff']; ?>">
                      <button class="btn btn-success" id="btn-save" type="submit" name="submit" onClick = "this.style.visibility= 'hidden';">Update</button>
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
