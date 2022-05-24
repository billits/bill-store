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
            <li class="breadcrumb-item active">Retur Produk Event</li>
          </ol>

          <!-- DataTables Example -->
          <!-- <div id="DataNTJK">          
          </div> -->
          <div class="card mb-3">
            <div class="card-body">
              <form method="post" id="form-approv" >
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="keterangan">Pilih Event*</label>
                        <select class="form-control m-bot15" name="event" id="event">
                          <option value="">Pilih Jenis Events</option>
    <?php
      include "../db_proses/koneksi.php";   
      $kantor=$_COOKIE["office_bill"];
      if ($kantor=='SBY'){
        $query = "SELECT * FROM tb_detail_events 
        INNER JOIN tb_events ON tb_events.id_events=tb_detail_events.event_det_event
        WHERE tb_detail_events.office_det_event='$kantor' AND tb_events.level_events='SEDANG' ORDER BY tb_detail_events.id_det_event DESC";
      }else{
        $query = "SELECT * FROM tb_detail_events 
        INNER JOIN tb_events ON tb_events.id_events=tb_detail_events.event_det_event
        WHERE tb_detail_events.office_det_event='$kantor' ORDER BY tb_detail_events.id_det_event DESC";
      }
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
                      <button class="btn btn-success" id="btn-save" type="submit" name="submit">Retur</button>
                    </div>
                  </form>
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
        var datakat = "data_retur.php";
        $('#DataNTJK').load(datakat); 

        $('#form-approv').submit(function(e){
          e.preventDefault();
          var dataform = $("#form-approv").serialize();
          $.ajax({
            url:"../db_proses/add_ret_evt.php",
            type:"POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                // alert(obj.error); 
                var nota_temp = obj.nota_id;
                var evt = document.getElementById("event").value;   
                window.location= 'det_retur.php?nota='+nota_temp+'&evt='+evt;
              }else{
                alert(obj.error); 
              }
            }
          })
        })
        
      })
    </script>

  </body>
  
</html>

