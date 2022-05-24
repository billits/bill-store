<?php
  include ('akses.php');
  include ('../_partials/partial_evt.php');
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
            <li class="breadcrumb-item active"> Laporan Konsi Event Kantor <?php echo $_COOKIE['nama_office']; ?> </li>
          </ol>

          <!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-body">
              <form method="post" id="form-approv" action="view_evt.php">
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
                      <label for="keterangan">Data Event*</label>
                        <select class="form-control m-bot15" name="event" id="event">
                          <option value="">Pilih Jenis Events</option>
    <?php
      session_start();
      include "../db_proses/koneksi.php";   
      $kantor=$_COOKIE["id_office"];
      $query = "SELECT * FROM detail_events INNER JOIN events ON events.id_events=detail_events.event_det_event
      WHERE detail_events.event_det_event!='BST' AND detail_events.event_det_event!='RTS' AND detail_events.event_det_event!='BIG' AND detail_events.event_det_event!='BMW' AND detail_events.event_det_event!='BCP' AND detail_events.event_det_event!='ELT'";
      $result = mysqli_query($kon, $query);

      while($baris = mysqli_fetch_assoc($result)){
    ?>
                      <option value="<?php echo $baris['id_det_event']; ?>"><?php echo $baris['nama_det_event']; ?></option>
    <?php
        }
    ?>
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