<?php
  include ('akses.php');
  include ('../_partials/partial_evt.php');
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
            <li class="breadcrumb-item active"> Events <?php echo $_COOKIE['nama_office']; ?></li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataEvents">          
          </div>


          <!-- Modal Popup untuk Tambah Data Events--> 
          <div id="ModalAdd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Tambah Data Events</h5>
                  <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="form-tambah">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Nama Events">Nama Events</label>
                      <input type="text" name="nama_events"  id="nama_events" class="form-control" placeholder="Nama Events" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Jenis Events">Jenis Events*</label>
                      <select class="form-control" name="jenis_events" id="jenis_events">
                        <option value="">Pilih Jenis Events</option>
    <?php
      include "../db_proses/koneksi.php";
      $kantor=$_COOKIE["id_office"];

      $query = "SELECT * FROM events";
      $result = mysqli_query($kon, $query);

      while($baris = mysqli_fetch_assoc($result)){
    ?>
                      <option value="<?php echo $baris['id_events']; ?>"><?php echo $baris['nama_events']." (".$baris['id_events'].")"; ?></option>
    <?php
        }
    ?>
                      </select>                      
                      <input class="form-control" type="hidden" name="kantor" id="kantor" value="<?php echo $kantor; ?>"/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Keterangan Event">Keterangan Events</label>
                      <input type="text" name="ket_events" id="ket_events" class="form-control" placeholder="Keterangan Events" required/>
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
      $(document).ready(function(){
        var dataevt = "data_event.php";
        $('#DataEvents').load(dataevt); 

        $('#form-tambah').submit(function(e){
          e.preventDefault();
          var dataform = $("#form-tambah").serialize();
          $.ajax({
            url:"../db_proses/add_det_events.php",
            type:"POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 
                $("#nama_events").val('');
                $("#jenis_events").val('');
                $("#ket_events").val('');
                $('#ModalAdd').modal('hide');
                $('#DataEvents').load(dataevt);
              }else{
                alert(obj.error); 
              }
            }
          })
        })

        $(document).on('click','#edit',function(e){
          e.preventDefault();
          $("#ModalEdit").modal('show');
          $.post('edit_events.php',
            {id:$(this).attr('data-id')},
            function(html){
              $("#data-edit").html(html);
            }  
          );
        });

        $(document).on('click','#down',function(e){
          e.preventDefault();
          var pid = $(this).attr('data-id');
          var pnama = $(this).attr('data-nama');
          bootbox.dialog({
            message: "Apakah Anda Ingin Menonaktifkan Event "+pnama+" ?",
            title: "",
            buttons: {
              danger: {
                label: "Ya",
                className: "btn-success",
                callback: function() {
                  $.post('../db_proses/off_events.php', { 'mati':pid })
                  .done(function(html){             
                    $('#DataEvents').load(dataevt);
                  })
                  .fail(function(){
                    bootbox.alert('Something Went Wrog ....');
                  })
                }
              }, 
              success: {
                label: "Tidak",
                className: "btn-danger",
                callback: function() {
                  $('.bootbox').modal('hide');
                }
              }
            }
          });
        });

        
        $("#form-edit").submit(function(e) {
          e.preventDefault();
          var dataform = $("#form-edit").serialize();
          $.ajax({
            url: "../db_proses/update_det_events.php",
            type: "POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 
                $('#ModalEdit').modal('hide');
                $('#DataEvents').load(dataevt);
              }else{
                alert(obj.error); 
              }
            }
          });
        });
      })
    </script>

  </body>
  
</html>

