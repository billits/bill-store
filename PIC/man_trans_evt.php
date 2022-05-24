<?php
  include ('akses.php');
  include ('../_partials/partial_pic.php');
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
              <a href="home.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Manual Transaksi Events <?php echo $_COOKIE['office_bill']; ?></li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataEvents">          
          </div>


          <!-- Modal Popup untuk Tambah Data Events--> 
          <div id="ModalAdd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Transakasi Events</h5>
                  <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="form-tambah">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Jenis Events">Jenis Events*</label>
                      <select class="form-control" name="jenis_events" id="jenis_events">
                        <option value="">Pilih Jenis Events</option>
    <?php
      include "../db_proses/koneksi.php";   
      $kantor=$_COOKIE["office_bill"];
      $query = "SELECT * FROM tb_detail_events INNER JOIN tb_events ON tb_events.id_events=tb_detail_events.event_det_event
      WHERE tb_detail_events.status_det_event='ON' AND tb_detail_events.office_det_event='$kantor'";
      $result = mysqli_query($kon, $query);

      while($baris = mysqli_fetch_assoc($result)){
    ?>
                      <option value="<?php echo $baris['id_det_event']; ?>"><?php echo $baris['nama_det_event']; ?></option>
    <?php
        }
    ?>
                      </select>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-success" id="btn-save" type="submit">Pilih</button>
                      <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">Batal</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        <?php
          echo $footer;
        ?>
        
      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
		<?php
      echo $logout;
    ?>

    <?php
      echo $csjs2;
    ?>

    <script type="text/javascript">
      $(document).ready(function(){
        var dataevt = "data_event_man.php";
        $('#DataEvents').load(dataevt); 

        $('#form-tambah').submit(function(e){
          e.preventDefault();          
          var datatmp = document.getElementById("jenis_events").value;
          window.location= 'man_transaksi_det_evt.php?evt='+datatmp;
        })
       

      })
    </script>

  </body>
  
</html>

