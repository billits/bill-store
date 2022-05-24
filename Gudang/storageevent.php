<?php
  include ('akses.php');
  include ('../_partials/partial_gudang.php');
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
            <li class="breadcrumb-item active">Stok Produk Gudang Event <?php echo $_COOKIE['office_bill']; ?></li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataStok">          
          </div>

          <!-- Modal Popup untuk Pilih Data Event--> 
          <div id="ModalEv" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Pilih Event</h5>
                  <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="form-ev">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="keterangan">Data Event*</label>
                        <select class="form-control m-bot15" name="event" id="event">
                          <?php
                          
	                          include "../db_proses/koneksi.php";
                            $kantor=$_COOKIE["office_bill"];
                            $query = "SELECT * FROM tb_detail_events INNER JOIN tb_events ON tb_events.id_events=tb_detail_events.event_det_event
                            WHERE tb_detail_events.status_det_event='ON' AND tb_detail_events.office_det_event='$kantor'";
                            $result = mysqli_query($kon, $query);
                            
                            while($baris = mysqli_fetch_assoc($result)){
                          ?>
                              <option value="<?php echo $baris['id_det_event']; ?>"><?php echo $baris['nama_det_event']." (".$baris['event_det_event'].")"; ?></option>
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
        var datastok = "data_stokevent.php";
        $('#DataStok').load(datastok); 

        $('#form-ev').submit(function(e){
          e.preventDefault();          
          $('#ModalEv').modal('hide');
          var datatmp = document.getElementById("event").value;
          var dataevt = "data_detstokevent.php?evt="+datatmp;
          $('#DataStok').load(dataevt); 
        })

        $(document).on('click','#kembali',function(e){
          e.preventDefault();
          $('#DataStok').load(datastok); 
        });
        
      })
    </script>

  </body>
  
</html>

