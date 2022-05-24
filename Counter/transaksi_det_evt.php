<?php
  include ('akses.php');
  include ('../_partials/partial_counter.php');
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
            <li class="breadcrumb-item active">Transaksi Events <?php echo $_COOKIE['office_bill']; ?></li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataEvents">          
          </div>


          <!-- Modal Popup untuk Tambah Data Events--> 
          <div id="ModalAdd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Pilih Transakasi Events</h5>
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

      $query = "SELECT * FROM tb_detail_events INNER JOIN tb_events ON tb_events.id_events=tb_detail_events.event_det_event
      WHERE tb_detail_events.status_det_event='ON'";
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

          <!-- Modal Popup untuk Edit Data Events-->
          <div id="ModalEdit" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form role="form" id="form-edit">
                  <div class="modal-header">
                    <h5 class='modal-title' id='exampleModalLabel'>Edit Data Events</h5>
                    <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                      <span aria-hidden='true'>×</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="data-edit">
                    </div>             
                  </div>
                  <div class="modal-footer">                  
                    <button class="btn btn-success" id="btn-save" type="submit">Simpan</button>
                    <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">Batal</button>
                  </div>
                </form>    
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
      function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
          vars[key] = value;
        });
        return vars;
      }
      $(document).ready(function(){
        var datatmp = getUrlVars()["evt"];

        var dataevt = "data_det_trans_evt.php?evt="+datatmp;
        $('#DataEvents').load(dataevt);  

        $(document).on('click','#kembali',function(e){
          e.preventDefault();
          window.location= 'transaksi_evt.php';
        });

        $(document).on('click','#back',function(e){
          e.preventDefault();
          $('#DataEvents').load(dataevt);  
        });


        $(document).on('click','#cetak',function(e){
          e.preventDefault();          
          var nota_tmp = $(this).attr('data-id');
          window.open(
            '../Print Nota NTJ1.php?nota='+nota_tmp,
            '_blank' // <- This is what makes it open in a new window.
          );
        });

        $(document).on('click','#detail',function(e){
          e.preventDefault();
          var datatmp = $(this).attr('data-id');
          var datalap = "data_detail_trans_evt.php?id="+datatmp;
          $('#DataEvents').load(datalap); 
        });

        $(document).on('click','#addtrans',function(e){
          e.preventDefault();
          var event_note={
            event_id : $(this).attr('data-evn'),
            event_jenis : $(this).attr('data-jenis'),
          }
          $.ajax({
            url:"../db_proses/add_newtrans_evt.php",
            type:"POST",
            data: event_note,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                window.location= 'add_trans_evt.php?nota='+obj.nota;
                //alert(obj.error); 
              }else{
                alert(obj.error); 
              }
            }
          })
        });

      })
    </script>

  </body>
  
</html>

