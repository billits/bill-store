<?php
  include ('akses.php');
  include ('../_partials/partial_pusat.php');
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <?php echo $csjs1; ?>
  </head>
  
  <!-- input tanggal -->
  <link rel="stylesheet" href="../datepicker/bootstrap-datepicker3.css"/>

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
            <li class="breadcrumb-item active">Report Control BTB Cabang <?php echo $_COOKIE['office_bill']; ?> </li>
          </ol>

          <!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-body">
              <form method="post" id="form-approv" action="view_cabang.php">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="tgl">Mulai Tanggal*</label>
					            <input type="text" name="tgl_start" id="tgl_start" class="form-control" placeholder="Mulai Tanggal" autocomplete="off" required>
					          </div>	
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="tgl">Sampai Tanggal*</label>
					            <input type="text" name="tgl_end" id="tgl_end" class="form-control" placeholder="Sampai Tanggal" autocomplete="off" required>
					          </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="pdk">Kode Produk*</label>
                      <!-- <input class="form-control" type="text" name="pdk" id="pdk" required placeholder="Keseluruhan Produk Isikan (ALL)" autocomplete="off"/>   -->
                      <input class="form-control" type="text" name="pdk" id="pdk" required value="ALL" autocomplete="off"/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nota">Kode Nota*</label>
                      <!-- <input class="form-control" type="text" name="nota_start" id="nota_start" required placeholder="Keseluruhan Nota Isikan (ALL)" autocomplete="off"/>  -->
                      <input class="form-control" type="text" name="nota_start" id="nota_start" required value="ALL" autocomplete="off"/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="offc">Kantor*</label>
                      <select class="form-control" name="offc" id="offc">
    <?php
      include "../db_proses/koneksi.php";
      $query1 = "SELECT * FROM tb_office WHERE id_office!='PST'";
      $result1 = mysqli_query($kon, $query1);
      
      while($baris1 = mysqli_fetch_assoc($result1)){
    ?>
                      <option value="<?php echo $baris1['id_office']; ?>"><?php echo $baris1['nama_office']; ?></option>
    <?php
        }
    ?>
                      </select>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="stat">Status*</label>
                      <select class="form-control" name="stat" id="stat">
                        <option value="APPROVE">APPROVE</option>
                        <option value="SUCCESS">SUCCESS</option>
                      </select>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="model">Model*</label>
                      <select class="form-control" name="model" id="model">
                        <option value="REKAP">Rekap</option>
                        <option value="DETAIL">Detail</option>
                      </select>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-success" id="btn-save" type="submit" name="submit">Lihat</button>
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

    <!-- input tanggal -->
    <script src="../datepicker/bootstrap-datepicker.js"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        // input tanggal 
        $('#tgl_start').datepicker({
          format: 'dd-mm-yyyy',
          autoclose: true,
          todayHighlight: true,
        });
        $('#tgl_end').datepicker({
          format: 'dd-mm-yyyy',
          autoclose: true,
          todayHighlight: true,
        });
      })
    </script>
  </body>
</html>
